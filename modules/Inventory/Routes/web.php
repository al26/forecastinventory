<?php
use Illuminate\Support\Facades\Auth;

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


    Route::middleware(['role:administrator'])->group(function () {
        Route::get('/forecast', 'InventoryController@forcasting');
    });
    
    // route('someRoute', [$user->role])
    
    Route::prefix('{role}/inventory')->group(function () {
        Route::middleware(['role:logistic|production|administrator'])->group(function () {
            Route::get('/materialneeds', 'MaterialController@materialNeedProduction')->name('materialneeds');
        });
    });


Route::prefix('logistic/inventory')->group(function () {
    Route::middleware(['role:logistic|administrator'])->group(function () {
        Route::get('/materialstock', 'MaterialController@materialstock')->name('materialstock');
        Route::get('/reducematerial/{id}','MaterialController@getmaterialstock')->name('reducematerial');
        Route::patch('/updatematerial/{id}','MaterialController@updatematerial')->name('updatematerial');
        Route::get('/purchasedata', 'MaterialController@purchasedata')->name('purchasedata');
        Route::get('/purchasingmaterial', 'MaterialController@formpurchasingmaterial')->name('purchasingmaterial');
        Route::post('/savepurchase', 'MaterialController@savepurchase')->name('savepurchase');
        Route::get('/editpurchase/{id}', 'MaterialController@editpurchase')->name('editpurchase');
        Route::patch('/updatepurchase/{id}', 'MaterialController@updatepurchase')->name('updatepurchase');
        Route::delete('/purchasedelete/{id}', 'MaterialController@purchasedelete')->name('purchasedelete');
    });
});

Route::prefix('production/inventory')->group(function () {
    Route::middleware(['role:production|administrator'])->group(function () {
        // Route::get('/forcastingresult', 'InventoryController@forcastingresult');
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