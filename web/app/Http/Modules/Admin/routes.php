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

//Route::resource('/admin/dashboard', 'Admin\AdminController@adminlogin');
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
//});
//
//
////Route group for access to only admin
//Route::group(['middleware' => 'manager'], function () {
//
//});

//Route::get('admin/login', function () {
//    return view("Admin/Layouts/adminlogin");
//});


Route::group(array('module' => 'Admin', 'namespace' => 'Admin\Controllers'), function () {
    \Illuminate\Support\Facades\Session::put("startTime",microtime(true));//FOR CALCULATION IN EXECUTION TIME (ADMIN LAYOUT PAGE)

    Route::get('/admin/cacheClear', function () {
        Cache::flush();
        return Redirect::back()->with(['status' => 'success', 'msg' => 'Cache has been cleared.']);
    });

//    \DB::listen(function ($query, $bindings, $time, $connection) {
//        $fullQuery = vsprintf(str_replace(array('%', '?'), array('%%', '%s'), $query), $bindings);
//        $result = $connection . ' (' . $time . '): ' . $fullQuery;
//        dump($result);
//    });

    Route::resource('/admin/login', 'AdminController@adminlogin');


//IF  YOU NEED TO USE GET POST, USE THIS FORMAT AS IN BELOW BLOCK COMMENT
    /*Route::get('admin/dashboard', function () {
        return view("Admin/Views/dashboard");
    }); */

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::resource('/admin/logout', 'AdminController@adminLogout');
        Route::resource('/admin/dashboard', 'AdminController@dashboard');
        Route::get('/admin/access-denied', function () {
            return view("Admin/Views/accessdenied");
        });

        Route::resource('/admin/pending-products', 'ProductController@pendingProducts');

        Route::resource('/admin/manage-categories', 'CategoryController@manageCategories');
        Route::resource('/admin/add-category', 'CategoryController@addCategory');
        Route::get('/admin/edit-category/{id}', 'CategoryController@editCategory');
        Route::post('/admin/edit-category/{id}', 'CategoryController@editCategory');

        Route::resource('/admin/manage-options', 'OptionController@manageOptions');
        Route::resource('/admin/add-option', 'OptionController@addOption');
        Route::get('/admin/edit-option/{id}', 'OptionController@editOption');
        Route::post('/admin/edit-option/{id}', 'OptionController@editOption');
        Route::post('/admin/option-ajax-handler', 'OptionController@optionAjaxHandler');

        Route::resource('/admin/add-product', 'ProductController@addProduct');
        Route::resource('/admin/manage-products', 'ProductController@manageProducts');


        Route::resource('/admin/control-panel', 'SettingController@controlPanel');
        Route::get('/admin/manage-settings/{section_id}', 'SettingController@manageSettings');
        Route::post('/admin/manage-settings/{section_id}', 'SettingController@manageSettings');
        Route::post('/admin/settings-ajax-handler', 'SettingController@settingsAjaxHandler');


        Route::resource('/admin/manage-currencies', 'currencyController@manageCurrencies');
        Route::resource('/admin/add-currency', 'currencyController@addCurrency');
        Route::get('/admin/edit-currency/{currencyId}', 'currencyController@editCurrency');
        Route::post('/admin/edit-currency/{currencyId}', 'currencyController@editCurrency');
        Route::post('/admin/currency-ajax-handler', 'currencyController@currencyAjaxHandler');


        //-----------------------------ROUTES FOR MANAGER----------------------------------------
        //DON't DO ANYTHING IN THIS BLOCK YET [TO BE DONE AT THE END OF ADMIN MODULE WORK]
        // [COPY ALL ROUTES ABOVE AND REPLACE ADMIN IN URL WITH MANAGER]
        Route::resource('/manager/logout', 'AdminController@managerLogout');

        Route::resource('manager/dashboard', 'AdminController@dashboard');
        Route::get('/manager/access-denied', function () {
            return view("Admin/Views/accessdenied");
        });

    });


});

