<?php

namespace Modules\Forecast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Forecast\Entities\ForecastAccuracy;
use Illuminate\Support\Facades\Session;
use Modules\SellHistory\Entities\SellHistory;
use Modules\Inventory\Entities\Products;
use Modules\Production\Entities\Production;
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
            return intval($product["rows"]) >= 12;
        });

        if (count($check) < 1) {
            Session::forget(['message', 'type']);
            Session::flash('message', "Belum dapat dilakukan peramalan. Belum ada produk dengan riwayat penjualan minimal 12 periode.");
            Session::flash('type', "warning");
        }

        $data['check'] = $check;

        return view('forecast::forecast', $data);
    }

    public function calculate(Request $request) {
        $request = $request->fc;

        $validator = Validator::make($request, [
            "product_id"    => [
                "required",
                function ($attribute, $value, $fail) {
                    if ($value === '0') {
                        $fail('Silahkah pilih produk yang tersedia.');
                    }
                },
            ],
            "alpha"         => "required",
            "beta"          => "required",
            "gamma"         => "required",
            "year"          => "required"
        ], [
            "product_id.required" => "Mohon pilih produk yang tersedia",
            "alpha.required"      => "Semua kolom variabel wajib diisi",
            "beta.required"       => "Semua kolom variabel wajib diisi",
            "gamma.required"      => "Semua kolom variabel wajib diisi",
            "year.required"       => "Mohon sertakan tahun",
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $this->doForecast($request['product_id'], 12, [
            'a' => $request["alpha"], 
            'b' => $request["beta"], 
            'c' => $request["gamma"]
        ]);
        $product = $request['product_id'];
        $year = $request['year'];
        
        $suggestion = $this->getSuggestionForProduction(
            $this->getUsedMethod($product), 
            $product,
            [
                'a' => $request["alpha"], 
                'b' => $request["beta"], 
                'c' => $request["gamma"]
            ]
        );
        
        $data_insert = [];
        $period = [
            'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'
        ];

        for ($i=0; $i < 12; $i++) { 
            $quarter_ins = $i % 4;
            array_push($data_insert, [
                'periode'           => $period[$i],
                'quarter'           => $quarter_ins+1,
                'year'              => $year,
                'product_id'        => $product,
                'jumlah_product'    => count($suggestion) > 1 && $quarter_ins < 4 ? $suggestion[$quarter_ins] : $suggestion[0],
                'status'            => 'berjalan',
            ]);
        }

        DB::beginTransaction();
        $ins = Production::query()->insert($data_insert);
        if ( $ins ) { 
            DB::commit(); 
            DB::beginTransaction();
            $update = SellHistory::where('product_id', $product)->where('year', intval($year)-1)->update(['forecasted' => true]);

            if( $update ) { DB::commit(); } else { DB::rollback(); }

        } else { DB::rollback(); }

        return redirect()->route('forecast.result', ['product' => $request["product_id"], 'year' => $request["year"]]);

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

            DB::beginTransaction();
            $add_mv = ForecastAccuracy::addLog('moving-average', $sh->id, $ft_mva, $sh->amount);
            if( $add_mv ) {
                DB::commit();
                DB::beginTransaction();
                $constraint = $this->getConstraint($sh, $variable);
                $add_m = ForecastAccuracy::addLog('multiplicative', $sh->id, $constraint['ft'], $sh->amount,[
                    'st' => $constraint["st"], 
                    'at' => $constraint["at"], 
                    'bt' => $constraint["bt"]
                ]);

                if ($add_m) { DB::commit(); } else { DB::rollback(); }

            } else {
                DB::rollback();
            }

        }
    }

    public function getConstraint($sh = null, $variable = ['a' => 0, 'b' => 0, 'c' => 0], $quarter = null) {
        $period_map = [
            'januari'   => 1,
            'februari'  => 2,
            'maret'     => 3,
            'april'     => 4,
            'mei'       => 5,
            'juni'      => 6,
            'juli'      => 7,
            'agustus'   => 8,
            'september' => 9,
            'oktober'   => 10,
            'november'  => 11,
            'desember'  => 12,
        ];

        if (is_null($sh) && is_null($quarter)) {
            throw new \Exception("This method require at least one between sh and quarter parameter is not null");
        }

        $current_period = !is_null($sh) ? intval($period_map[$sh->period]) : 13;
        $current_quarter = !is_null($sh) ? intval($sh->quarter) : $quarter;
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
            
            $st = $avg ? (floatval($sh->amount) / $avg) : floatval(0);  
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
            $xt = !is_null($sh) ? $sh->amount : 0;
            $lastAt = floatval($l['at']);
            
            $at = ( $lastStQuarter ? ($a*($lastXt/$lastStQuarter)) : 0 ) + ( (1-$a)*($lastAt+$lastBt) );
            $bt = ( $b*($at-$lastAt) ) + ( (1-$b)*$lastBt );
            $st = ( $at ? ($c*($xt/$at)) : 0 ) + ( (1-$c)*$lastStQuarter );
            $ft = ($lastAt+$lastBt)*$lastStQuarter;
        }
    

        return [
            "st" => $st,
            "at" => $at,
            "bt" => $bt,
            "ft" => $ft
        ];
    }

    public function getUsedMethod($product, $n_limit = 12) {
        $hwm = ForecastAccuracy::getCalculation('multiplicative', intval($product), $n_limit, true);
        $mva = ForecastAccuracy::getCalculation('moving-average', intval($product), $n_limit, true);
        $mins = min($hwm, $mva);
        $count_hwm = count(array_diff($hwm, $mins));
        $count_mva = count(array_diff($mva, $mins));
        
        return $count_hwm < $count_mva ? "multiplicative" : "moving-average";
    }

    public function getSuggestionForProduction($used_method, $product, $variable = ['a' => 0, 'b' => 0, 'c' => 0]) {
        $res = [];
        if ( $used_method === 'multiplicative' ) {
            for ($i=1; $i <= 4; $i++) { 
                array_push($res, $this->getConstraint(null, $variable, $i)['ft']);
            }
        } else {
            $sh = SellHistory::select('id')->where('product_id', $product)
                        ->orderBy('id', 'desc')
                        ->first();
        
            $ft_mva = SellHistory::avgLastAmount([
                [
                    'key' => 'product_id',
                    'operand' => '=',
                    'value' => $product
                ],
                [
                    'key' => 'id',
                    'operand' => '<=',
                    'value' => $sh->id
                ],   
            ], 3);

            array_push($res, $ft_mva);
        }
        
        $res = array_map(function($val){
            return intval(ceil($val));
        }, $res);
        
        return $res;
    }

    public function result(Request $request) {
        $product = $request->product;
        $year    = $request->year;
        $data['title'] = ucwords("hasil peramalan");
        $data['moving_avg'] = ForecastAccuracy::getRaw('moving-average', intval($product), false, $year);
        $data['multiplicative'] = ForecastAccuracy::getRaw('multiplicative', intval($product), false, $year);
        $data['calc']['hwm'] = ForecastAccuracy::getCalculation('multiplicative', intval($product), 12, false, $year);
        $data['calc']['mva'] = ForecastAccuracy::getCalculation('moving-average', intval($product), 12, false, $year);
        return view('forecast::result', $data);
    }

    public function history (Request $request) {
        $data['title'] = ucwords("Riwayat perhitungan peramalan");
        $data['products'] = Products::select('products.id', 'products.product_code', 'products.product_name')
                    ->join('sell_histories', 'sell_histories.product_id', '=', 'products.id')
                    ->where('sell_histories.forecasted', true)
                    ->distinct()
                    ->get();
        // dd($data['products']->toArray());    
        if ( !is_null($request->get('product')) && !is_null($request->get('year')) ) {
            $product = $request->get('product');
            $year    = $request->get('year');
            $data['moving_avg'] = ForecastAccuracy::getRaw('moving-average', intval($product), false, $year);
            $data['multiplicative'] = ForecastAccuracy::getRaw('multiplicative', intval($product), false, $year);
            $data['calc']['hwm'] = ForecastAccuracy::getCalculation('multiplicative', intval($product), 12, false, $year);
            $data['calc']['mva'] = ForecastAccuracy::getCalculation('moving-average', intval($product), 12, false, $year);
        }

        return view('forecast::history', $data);
    }
}
