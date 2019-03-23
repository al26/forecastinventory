<?php
namespace Modules\Forecast\Entities;

use Illuminate\Database\Eloquent\Model;

class ForecastAccuracy extends Model
{
    protected $table = 'forecast_accuracy';
    protected $primaryKey = 'id';
    protected $fillable = ['method', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent'];


    public function scopeAddLog($query, $method, $ft, $xt, &$obj_return = false) {
        $ft = (float)$ft;
        $xt = (float)$xt;
        $error = $ft-$xt;
        $error = (float)$error;
        $errorAbs= abs($error);
        $percentage = ($error/$xt)*100;
        $percentage = (float)$percentage;
        $data = $query->create([
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
        }  

        return true;
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
        
        $query = $query->select('id', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent');
        if($method && $id) {
            $return = $query->where('method', $method)
                            ->where('id', $id)
                            ->get();
        }
        elseif($method) {
            $return = $query->where('method', $method)->get();
        } 
        elseif($id) {
            $return = $query->where('id', $id)->get();
        } 
        else {
            $return = $query->get();
        }

        return $needs_array ? $return->toArray() : $return;
    }

    public function scopeGetCalculation($query, &$needs_array = false) {
        $data['mad'] = $query->avg('error_abs');
        $data['mse'] = $query->avg('error_square');
        $data['mape'] = $query->avg('error_abs_percent');

        return $needs_array ? $data : (object)$data;
    }

}
