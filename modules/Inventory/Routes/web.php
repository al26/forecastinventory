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

Route::prefix('administrator/inventory')->group(function () {
    Route::group(['middleware' => ['role:administrator']], function () {
        Route::get('/forecast', 'InventoryController@forcasting');
    });
});
Route::prefix('production/inventory')->group(function () {
    Route::group(['middleware' => ['role:production']], function () {

        // kebutuhan material belum dibuat
        Route::get('/materialneeds', 'InventoryController@materialneeds');

        // belom dibuat result forcastin
        Route::get('/forcastingresult', 'InventoryController@forcastingresult');

        Route::get('/materialstock', 'MaterialController@materialstock');
        // Route For Product
        Route::get('/product', 'ProductsController@getDataProduct')->name('productview');
        Route::get('/adddataproduct', 'ProductsController@addDataProduct')->name('adddataproduct');
        Route::post('/saveproduct', 'ProductsController@saveproduct')->name('savedataproduct');
        Route::get('/editproduct/{id}', 'ProductsController@editproduct')->name('editproduct');
        Route::patch('/updateproduct/{id}', 'ProductsController@updateproduct')->name('updateproduct');
        Route::delete('/deleteproduct/{id}', 'ProductsController@deleteproduct')->name('deletedataproduct');
    });
});
Route::prefix('logistic/inventory')->group(function () {
    Route::group(['middleware' => ['role:logistic|production']], function () {
        // kebutuhan material belum dibuat MENGARAH KE METHOD YANG SAMA DENGAN PRODUKSI
        Route::get('/materialneeds', 'InventoryController@materialneeds');
    });

    Route::group(['middleware' => ['role:logistic']], function () {
        Route::get('/', 'MaterialController@purchasedata');

        Route::get('/materialstock', 'MaterialController@materialstock');

        Route::get('/purchasedata', 'MaterialController@purchasedata')->name('purchasedata');
        Route::get('/purchasingmaterial', 'MaterialController@formpurchasingmaterial')->name('purchasingmaterial');
        Route::post('/savepurchase', 'MaterialController@savepurchase')->name('savepurchase');
        Route::get('/editpurchase/{id}', 'MaterialController@editpurchase')->name('editpurchase');
        Route::patch('/updatepurchase/{id}', 'MaterialController@updatepurchase')->name('updatepurchase');
        Route::delete('/purchasedelete/{id}', 'MaterialController@purchasedelete')->name('purchasedelete');
    });
});
