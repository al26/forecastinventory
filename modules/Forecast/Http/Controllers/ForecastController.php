<?php

namespace Modules\Forecast\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Forecast\Entities\ForecastAccuracy;
use Illuminate\Support\Facades\Session;

class ForecastController extends Controller
{
    function __construct() {

    }


    public function index() {
        $data['moving_avg'] = $this->movingAvg(20);
        Session::flash('message', 'Forecasted');
        Session::flash('type', 'info');
        return view('forecast::index', $data);
    }


    public function movingAvg($xt, $n_last_period = 3) {
        // get last 3 period sell history
        $history = [51,5,32];
        $ft = avg($history);

        // dd($ft);
        
        $log = ForecastAccuracy::addLog("moving_average", $ft, $xt);
        if($log) {
            $data['raw'] = ForecastAccuracy::getRaw();
            $data['calculation'] =ForecastAccuracy::getCalculation();
        }

        return (object)$data;
    }
}
