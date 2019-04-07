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
    Route::group(['prefix' => 'administrator'], function () {
        Route::prefix('sell-history')->group(function() {
            Route::get('/', 'SellHistoryController@index')->name('sh.index');
            Route::get('/add', 'SellHistoryController@create')->name('sh.create');
            Route::post('/', 'SellHistoryController@store')->name('sh.store');
            Route::get('/{id}', 'SellHistoryController@edit')->name('sh.edit');
            Route::patch('/{id}', 'SellHistoryController@update')->name('sh.update');
            Route::delete('/{id}', 'SellHistoryController@destroy')->name('sh.delete');
        });
    });

    Route::get('ajax/sell-history/last-period-of/{product}', 'SellHistoryController@getLastPeroidOfProduct');
});
