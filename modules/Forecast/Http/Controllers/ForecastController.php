<?php

namespace Modules\Forecast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Forecast\Entities\ForecastAccuracy;
use Illuminate\Support\Facades\Session;
use Modules\SellHistory\Entities\SellHistory;
use Modules\Inventory\Entities\Products;
use Illuminate\Support\Facades\DB;
use Validator;

class ForecastController extends Controller
{
    function __construct() {

    }


    public function index() {
        $data['title'] = ucwords('peramalan');
        $subSelect = SellHistory::select(DB::raw("count(id) as rows"), "product_id as id")
                                  ->groupBy('sell_histories.product_id');
        $products = Products::select('products.id', 'products.product_name', 'subs.rows')
                            ->leftJoin('sell_histories', 'products.id', '=', 'sell_histories.product_id')
                            ->leftJoinSub($subSelect, 'subs', function($join) {
                                $join->on('subs.id', '=', 'products.id');
                            })->distinct()->get();
        
        $data['products'] = $products;

        $check = array_filter($products->toArray(), function($product) {
            return intval($product["rows"]) > 3;
        });

        if (count($check) < 1) {
            Session::forget(['message', 'type']);
            Session::flash('message', "Belum dapat dilakukan peramalan. Belum ada produk dengan riwayat penjualan minimal 3 periode.");
            Session::flash('type', "warning");
        }

        $data['check'] = $check;

        return view('forecast::forecast', $data);
    }

    public function calculate(Request $request) {
        $request = $request->fc;

        $validator = Validator::make($request, [
            "product_id"    => "required",
            "alpha"         => "required",
            "beta"          => "required",
            "gamma"         => "required",
        ], [
            "product_id.required" => "Mohon pilih produk yang tersedia",
            "alpha.required"      => "Semua kolom variabel waji diisi",
            "beta.required"       => "Semua kolom variabel waji diisi",
            "gamma.required"      => "Semua kolom variabel waji diisi",
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $this->doForecast($request['product_id'], 12, [
            'a' => $request["alpha"], 
            'b' => $request["beta"], 
            'c' => $request["gamma"]
        ]);

        return redirect()->route('forecast.result', ['product' => $product]);
    }

    private function doForecast($product, $n_last_period = 3, $variable = ['a' => 0, 'b' => 0, 'c' => 0]) {
        $shs = SellHistory::select('id', 'amount', 'product_id', 'period', 'quarter')->where('product_id', $product)
                        ->orderBy('id', 'desc')
                        ->take($n_last_period)
                        ->get();
        
        foreach ($shs->reverse() as $sh) {
            $ft_mva = SellHistory::avgLastAmount([
                [
                    'key' => 'product_id',
                    'operand' => '=',
                    'value' => $product
                ],
                [
                    'key' => 'id',
                    'operand' => '<',
                    'value' => $sh->id
                ],   
            ], 3);            

            ForecastAccuracy::addLog('moving-average', $sh->id, $ft_mva, $sh->amount);
            
            $constraint = $this->getConstraint($sh, $variable);
            ForecastAccuracy::addLog('multiplicative', $sh->id, $constraint['ft'], $sh->amount, [
                'st' => $constraint["st"], 
                'at' => $constraint["at"], 
                'bt' => $constraint["bt"]
            ]);
        }
    }

    // private function multiplicative()

    public function getConstraint($sh, $variable = ['a' => 0, 'b' => 0, 'c' => 0]) {
        $current_period = intval($sh->period);
        $current_quarter = intval($sh->quarter);
        if ($current_period <= 4) {
            $avg = SellHistory::avgLastAmount([
                [
                    'key' => 'product_id', 
                    'value'=> $sh->product_id,
                    'operand' => '='
                ],
                [
                    'key' => 'period', 
                    'value'=> 4,
                    'operand' => '<='
                ]
            ], 4);
            if ($current_period === 4) {
                $at = $avg;
                // $lastAt = $at;
            } else {
                $at = floatval(0);
            }
            
            $st = floatval($sh->amount) / $avg;  
            $bt = floatval(0);
            $ft = floatval(0);
        } else {
            $l  = ForecastAccuracy::select('forecast_accuracy.at', 'forecast_accuracy.bt', 'sell_histories.amount as xt', 'sell_histories.product_id')
            ->join('sell_histories', 'sell_histories.id', '=', 'forecast_accuracy.sell_history_id')
            ->orderBy('sell_histories.id', 'desc')
            ->where('method', 'multiplicative')
            ->first();
            
            
            $q = ForecastAccuracy::select('st')
            ->join('sell_histories', 'sell_histories.id', '=', 'forecast_accuracy.sell_history_id')
            ->where('sell_histories.product_id', '=', $l->product_id)
            ->where('sell_histories.quarter', '=', $current_quarter)
            ->where('method', 'multiplicative')
            ->orderBy('sell_histories.id', 'desc')
            ->first();
            
            // dd($q->st);
            $lastStQuarter = floatval($q->st);
            
            $a = floatval($variable['a']);
            $b = floatval($variable['b']);
            $c = floatval($variable['c']);
            $lastXt = floatval($l['xt']);
            $lastBt = floatval($l['bt']);
            $xt = $sh->amount;
            $lastAt = floatval($l['at']);
            
            $at = ( $a*($lastXt/$lastStQuarter) ) + ( (1-$a)*($lastAt+$lastBt) );
            $bt = ( $b*($at-$lastAt) ) + ( (1-$b)*$lastBt );
            $st = ( $c*($xt/$at) ) + ( (1-$c)*$lastStQuarter );
            $ft = ($lastAt+$lastBt)*$lastStQuarter;
        }
    

        return [
            "st" => $st,
            "at" => $at,
            "bt" => $bt,
            "ft" => $ft
        ];
    }

    public function result(Request $request, $product) {
        $data['title'] = ucwords("hasil peramalan");
        $data['moving_avg'] = ForecastAccuracy::getRaw('moving-average', intval($product));
        $data['multiplicative'] = ForecastAccuracy::getRaw('multiplicative', intval($product));
        $data['calc']['hwm'] = ForecastAccuracy::getCalculation('multiplicative', intval($product));
        $data['calc']['mva'] = ForecastAccuracy::getCalculation('moving-average', intval($product));
        return view('forecast::result', $data);
    }

}
