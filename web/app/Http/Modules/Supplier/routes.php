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

    Route::resource('/supplier/login', 'SupplierController@login');
    Route::resource('/supplier/register', 'SupplierController@register');
    Route::resource('/supplier/logout', 'SupplierController@logout');
    Route::post('/userAjaxHandler', 'SupplierController@userAjaxHandler');


//IF  YOU NEED TO USE GET POST, USE THIS FORMAT AS IN BELOW BLOCK COMMENT
    /*Route::get('admin/dashboard', function () {
        return view("Admin/Views/dashboard");
    }); */

    Route::group(['middleware' => 'auth:supplier'], function () {
//        Supplier Controller
        Route::resource('/supplier/dashboard', 'SupplierController@dashboard');
        Route::resource('/supplier/profile', 'SupplierController@profile');
        Route::resource('/supplier/supplierDetails', 'SupplierController@supplierDetails');
        Route::post('/supplier/ajaxHandler', 'SupplierController@ajaxHandler');

      Route::get('images/{filename}', function ($filename)
        {
            $path = storage_path() . '/' . $filename;

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        });
//        Product Controller
        Route::resource('/supplier/add-product', 'ProductController@addProduct');
    });

});