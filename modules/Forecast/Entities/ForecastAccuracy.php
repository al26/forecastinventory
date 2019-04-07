<?php
namespace Modules\Forecast\Entities;

use Modules\SellHistory\Entities\SellHistory;
use Illuminate\Database\Eloquent\Model;

class ForecastAccuracy extends Model
{
    protected $table = 'forecast_accuracy';
    protected $primaryKey = 'id';
    protected $fillable = ['sell_history_id', 'method', 'st', 'at', 'bt', 'ft', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent'];


    public function sellHistory() {
        return $this->belongsTo('Modules\SellHistory\Entities\SellHistory');
    }

    public function scopeAddLog($query, $method, $sh, $ft, $xt, &$additional = ['st' => 0, 'at' => 0, 'bt' => 0], &$obj_return = false) {

        $current_period = $query->select('sell_histories.period')
                                ->rightJoin('sell_histories', 'sell_histories.id', '=', 'forecast_accuracy.sell_history_id')
                                ->where('sell_histories.id', $sh)
                                ->first();

        // dd($current_period->period);

        $current_period = intval($current_period->period);

        $xt = floatval($xt);
        if ( $current_period < 4 || ($method === 'multiplicative' && $current_period === 4) ) {
            $ft = 0;
            $error = 0;
            $percentage = 0;
        } else {
            $ft = floatval($ft);
            $error = $method === 'moving-average' ? $ft-$xt : $xt-$ft;
            $percentage = ($error/$xt)*100;
        }
        
        $error = floatval($error);
        $errorAbs= abs($error);
        $percentage = floatval($percentage);

        $data = $query->create([
            'sell_history_id'   => $sh,
            'st'                => floatval($additional['st']),
            'at'                => floatval($additional['at']),
            'bt'                => floatval($additional['bt']),
            'ft'                => $ft,
            'method'            => $method,
            'error'             => $error,
            'error_abs'         => $errorAbs,
            'error_square'      => pow($error, 2),
            'error_percentage'  => $percentage,
            'error_abs_percent' => abs($percentage)
        ]);

        if($data) {
            if(isset($obj_return) && $obj_return) {
                return $data;
            }

            return true;
        }  

        return false;
    }

    public function scopeGetRaw($query) {
        $numArgs = func_num_args();
        $method = null; $id = null; $needs_array = false;
        if($numArgs > 1 && $numArgs < 5) {
            for ($i = 1; $i < $numArgs; $i++) {
                if(gettype(func_get_arg($i)) === "string") {
                    $method = func_get_arg($i);
                }
                if(gettype(func_get_arg($i)) === "integer") {
                    $id = func_get_arg($i);
                }
                if(gettype(func_get_arg($i)) === "boolean") {
                    $needs_array = func_get_arg($i);
                }
            }   
        }
        
        // dd(["method" => $method, "id" => $id]);

        $query = $query->select('forecast_accuracy.id', 'sell_history_id', 'sell_histories.amount as xt', 'ft', 'at', 'bt', 'st', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent')->join('sell_histories', 'sell_histories.id', '=', 'forecast_accuracy.sell_history_id');
        if($method && $id) {
            $return = $query->where('method', $method)
                            ->where('sell_histories.product_id', $id)
                            ->get();
        }
        elseif($method) {
            $return = $query->where('method', $method)->get();
        } 
        elseif($id) {
            $return = $query->where('sell_histories.product_id', $id)->get();
        } 
        else {
            $return = $query->get();
        }

        return $needs_array ? $return->toArray() : $return;
    }

    public function scopeGetCalculation($query, $method, $product_id, $limit = 12, &$needs_array = false) {
        $a = $query->select('sell_histories.period','error_abs', 'error_square', 'error_abs_percent')
                             ->join('sell_histories', 'forecast_accuracy.sell_history_id', '=', 'sell_histories.id')
                             ->where('method', $method)
                             ->where('sell_histories.product_id', $product_id)
                             ->orderBy('sell_histories.id', 'desc')
                             ->take($limit)->get();

        $data['mad'] = $a->avg('error_abs');
        $data['mse'] = $a->avg('error_square');
        $data['mape'] = $a->avg('error_abs_percent');

        return $needs_array ? $data : (object)$data;
    }

}
