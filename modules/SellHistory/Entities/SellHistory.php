<?php

namespace Modules\SellHistory\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class SellHistory extends Model
{
    protected $table = "sell_histories";
    protected $fillable = ['period', 'quarter', 'product_id', 'amount'];
    public $timestamps = false;

    public function products() {
        return $this->belongsTo('Modules\Inventory\Entities\Products');
    }

    public function forecastAccuracies(){
        return $this->hasMany('Modules\Inventory\Entities\Products');
    }

    public function scopeProductSellHistory($query, &$where = []) {
        $query->select('forecast_accuracy.sell_history_id as forecasted','sell_histories.*', 'products.product_name', 'products.product_code')
              ->join('products', 'sell_histories.product_id', '=', 'products.id')
              ->leftJoin('forecast_accuracy', 'forecast_accuracy.sell_history_id', '=', 'sell_histories.id')
              ->distinct()
              ->orderBy('id', 'asc')
              ->orderBy('year', 'desc');
        
        if ($where && count($where) > 0) {
            $query->where(key($where), '=', $where[key($where)]);
            return $query->first();
        }

        return $query->get();
    }

    public function scopeGetPeriod($query, &$where = [], &$limit = false, $increment = false) {
        $default = new \stdClass();
        $default->period = "0";
        $default->quarter = "0";

        $default = collect([
            $default
        ]);



        $res = null;

        $query->select('period', 'quarter')->orderBy('id', 'desc');
        if ($where && count($where) > 0) {
            $query->where(key($where), '=', $where[key($where)]);
        }

        if($limit) {
            $res = $query->take($limit)->get();
        } else {
            $res = $query->get();
        }
        
        
        if (count($res) <= 0) {
            $res = $default;
        }

        if ($increment) {
            foreach ($res as $key => $value) {
                $value->period = intval($value->period) + 1;
                if (intval($value->quarter) < 4) {
                    $value->quarter = intval($value->quarter) + 1;
                } else {
                    $value->quarter = 1;
                }
            }    
        }

        return $res;
    }

    public function scopeCountProductActivePeriod($query, $product_id) {
        // dd($product_id);
        $totalPeriod = $query->select('id')->where('sell_histories.product_id', $product_id)->get()->count();
        return intval($totalPeriod) % 12;
    }

    public function scopeAvgLastAmount($query, $condition, $n = 1, $offset = 0) {
        $query->select('amount');

        foreach ($condition as $key => $value) {
            $query->where($value['key'], $value['operand'], $value['value']);    
        }

        $am = $query->take($n)->skip($offset)->orderBy('id', 'desc')->get();

        // dd($am);
        return floatval($am->avg('amount'));
    }

    public function scopeGetNextYear($query, $product_id = null) {
        $query->select('year')
                      ->orderBy('id', 'desc');
        if ( !is_null($product_id) ) {
            $query->where('product_id', $product_id);
        }
        $year = $query->first();
        $year = isset($year->year) ? $year->year : null;
                    
        $year = !is_null($year) ? intval($year)+1 : date('Y');
        
        return $year;
    }

    public function scopeGetYearHistory($query, $product_id = null) {
        $query->select(DB::raw('distinct year'));
        if (!is_null($product_id)) {
            $query->where('product_id', $product_id);
        }

        $years = $query->get()->toArray();
        $years = array_map(function($val){
            return $val['year'];
        }, $years);

        return $years;
    }
}