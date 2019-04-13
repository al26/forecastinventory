<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth', 'role:administrator']], function () {
    Route::prefix('administrator/forecast')->group(function() {
        Route::get('/', 'ForecastController@index')->name('forecast.define');
        Route::post('calculate', 'ForecastController@calculate')->name('forecast');
        Route::get('result', 'ForecastController@result')->name('forecast.result');
    });

    Route::get('ajax/sell-history/get-period/{product}', function ($product) {
        return \Modules\SellHistory\Entities\SellHistory::getPeriod(['product_id' => $product]);
    });
});

