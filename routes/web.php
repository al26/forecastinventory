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

Route::get('/', function () {
    return redirect()->route('login');
});


Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {
    if (\App\Role::getNames()) {
        foreach (\App\Role::getNames() as $key => $value) {
            $role = $value['name'];
            Route::group(
                ['middleware' => ['role:' . $role]],
                function () use ($role) {
                    Route::get($role, "UserController@" . $role)->name($role . ".dashboard");
                }
            );
        }
    }
});
