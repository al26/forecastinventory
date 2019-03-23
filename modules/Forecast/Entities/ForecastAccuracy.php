<?php
namespace Modules\Forecast\Entities;

use Illuminate\Database\Eloquent\Model;

class ForecastAccuracy extends Model
{
    protected $table = 'forecast_accuracy';
    protected $primaryKey = 'id';
    protected $fillable = ['method', 'error', 'error_abs', 'error_square', 'error_precentage', 'error_abs_percent'];


    public function scopeAddLog($method, $ft, $xt, &$obj_return) {
        // die(var_dump($this));

        $ft = (float)$ft;
        $xt = (float)$xt;
        $error = $ft-$xt;
        $error = (float)$error;
        $percentage = ($error/$xt)*100;
        $percentage = (float)$percentage;
        $data = $this->create([
            'method'            => $method,
            'error'             => -30,
            'error_abs'         => 30,
            'error_square'      => 900,
            'error_precentage'  => 100,
            'error_abs_percent' => 100
        ]);

        if($data) {
            if(isset($obj_return) && $obj_return) {
                return $data;
            }
        }  

        return true;
    }

    public function scopeForView($method = null, $needs_array = false) {
        if($method) {
            $return = $this->select('id', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent') 
                           ->where('method', $method)
                           ->get();
        } else {
            $return = $this->select('id', 'error', 'error_abs', 'error_square', 'error_percentage', 'error_abs_percent')
                           ->get(); 
        }

        return $needs_array ? $return->toArray() : $return;
    }

}
