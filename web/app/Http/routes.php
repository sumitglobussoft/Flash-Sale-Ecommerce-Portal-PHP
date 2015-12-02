<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['middleware' => ['guest']], function () {

/* // Authentication routes...
//    Route::get('/logout', 'Auth\AuthController@getLogout');
    Route::resource('/login', 'Auth\AuthController@login');

// Registration routes...
    Route::get('/register', 'Auth\AuthController@getRegister');
    Route::post('/register', 'Auth\AuthController@postRegister');
*/

});


//Route::resource('/admin/dashboard','Admin\AdminController@dashboard');
//Route::get('/admin/dashboard', function () {
//    return view('admin.dashboard');
//});

//Route::resource('/admin/dashboard','Admin\AdminController@adminlogin');
//
//
////Route group for access to authenticated users only.
//Route::group(['middleware' => ['auth']], function () {
//    //Route group for access to only admin
//    Route::group(['middleware' => 'admin'], function () {
//
//    });
//
//    //Route group for access to only admin
//    Route::group(['middleware' => 'user'], function () {
//
//    });
//
//    //Route group for access to only admin
//    Route::group(['middleware' => 'merchant'], function () {
//
//    });
//
//
//});
//
//
////Route group for access to only admin
//Route::group(['middleware' => 'manager'], function () {
//
//});

//Route::group(array('module'=>'Admin','namespace' => 'FlashSale\Http\Modules\Admin\Controllers\Admin'), function() {
//    Route::get('admin/dashboard',function(){
//        return view("Admin/Views/dashboard");
//    });
//});