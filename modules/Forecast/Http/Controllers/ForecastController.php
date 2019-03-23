<?php

namespace Modules\Forecast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Forecast\Entities\ForecastAccuracy;

class ForecastController extends Controller
{
    function __construct() {

    }


    public function index() {
        $data['moving_avg'] = $this->movingAvg(30);
        die(var_dump($data));
        return view('forecast::index', $data);
    }


    public function movingAvg($xt, $n_last_period = 3) {
        // get last 3 period sell history
        $data = [1,2,3];
        $ft = avg($data);
        // die(var_dump($ft));


        $log = ForecastAccuracy::addLog("moving_average", $ft, $xt);
        if(isset($log)) {
            $data = ForecastAccuracy::forView('moving_average');
            // $data->mad = $this->avg($data->error_abs);
            // $data->mse = $this->avg($data->error_square);
            // $data->mape = $this->avg($data->error_abs_percent);
        }

        return $data;
    }

    public function avg(array $data) {
        return array_sum($data) / count($data);
    }
}
