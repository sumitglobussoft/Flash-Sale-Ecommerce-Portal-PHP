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

Route::group(array('module' => 'Supplier', 'namespace' => 'Supplier\Controllers'), function () {

    Route::resource('supplier/login', 'SupplierController@login');
    Route::resource('supplier/register', 'SupplierController@register');
    Route::resource('supplier/logout', 'SupplierController@logout');


//IF  YOU NEED TO USE GET POST, USE THIS FORMAT AS IN BELOW BLOCK COMMENT
    /*Route::get('admin/dashboard', function () {
        return view("Admin/Views/dashboard");
    }); */

    Route::group(['middleware' => 'auth:supplier'], function () {
        Route::resource('supplier/dashboard', 'SupplierController@dashboard');
        Route::resource('supplier/profile', 'SupplierController@profile');
        Route::resource('supplier/supplierDetails', 'SupplierController@supplierDetails');
        Route::post('supplier/ajaxHandler', 'SupplierController@ajaxHandler');

//        Route::resource('admin/ads', 'AdminController@dashboard');
    });

});