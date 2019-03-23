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

// Route::prefix('administrator/inventory')->group(function() {
//     Route::group(['middleware' => ['role:administrator']], function () {
//         Route::get('/forecast', 'InventoryController@forcasting');    
//     });
// });
Route::prefix('production/inventory')->group(function() {
    Route::group(['middleware' => ['role:production|logistic']], function () {
        Route::get('/kebutuhanbahanbaku', 'InventoryController@kebutuhanbahanbaku');
        
        Route::get('/persediaanbahanbaku', 'BahanbakuController@persediaanbahanbaku');
    });
    Route::group(['middleware' => ['role:production']], function () {
        Route::get('/hasilforcasting', 'InventoryController@hasilforcasting');
    });
});
Route::prefix('logistic/inventory')->group(function() {
    Route::group(['middleware' => ['role:logistic']], function () {  
        Route::get('/pemebelianbahanbaku','BahanbakuController@formpembelianbahanbaku')->name('pembelianbahanbaku');
        Route::post('/simpanpembelian','BahanbakuController@simpanpembelian')->name('savepembelian');
        Route::get('/datapembelian','BahanbakuController@datapembelian')->name('datapembelian');
    });
});