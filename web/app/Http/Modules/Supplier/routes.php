<?php

Route::group(['middleware' => ['guest']], function () {

    /* // Authentication routes...
    //    Route::get('/logout', 'Auth\AuthController@getLogout');
        Route::resource('/login', 'Auth\AuthController@login');

    // Registration routes...
        Route::get('/register', 'Auth\AuthController@getRegister');
        Route::post('/register', 'Auth\AuthController@postRegister');
    */

});


//Route::get('supplier/register', function () {
//    return view("Supplier/Layouts/supplier/register");
//});


Route::group(array('module' => 'Supplier', 'namespace' => 'Supplier\Controllers'), function () {

    Route::resource('supplier/login', 'SupplierController@login');
    Route::resource('supplier/register', 'SupplierController@register');

    Route::group(['middleware' => 'auth'], function () {
        Route::resource('supplier/dashboard', 'SupplierController@dashboard');
    });

});

