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

//  \DB::listen(function($sql, $bindings, $time) {
//    var_dump($sql);
//    var_dump($bindings);
//    var_dump($time);
//});
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
        Route::resource('/admin/add-product', 'ProductController@addProduct');

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

        /* Feature controller route start */
        Route::resource('/admin/manage-features', 'FeaturesController@manageFeatures');
        Route::resource('/admin/add-feature-group', 'FeaturesController@addFeatureGroup');
        Route::get('/admin/edit-feature-group/{featureId}', 'FeaturesController@editFeatureGroup');
        Route::post('/admin/edit-feature-group/{featureId}', 'FeaturesController@editFeatureGroup');
//        Route::resource('/admin/edit-feature-group/{featureId}', 'FeaturesController@editFeatureGroup');
        Route::resource('/admin/add-feature', 'FeaturesController@addFeature');
        Route::get('/admin/edit-feature/{featureId}', 'FeaturesController@editFeature');
        Route::post('/admin/edit-feature/{featureId}', 'FeaturesController@editFeature');
//        Route::resource('/admin/edit-feature/{featureId}', 'FeaturesController@editFeature');
        /* Feature controller route end */

        Route::resource('/admin/add-new-filtergroup', 'FilterController@addNewFiltergroup');
        Route::resource('/admin/manage-filtergroup', 'FilterController@manageFilterGroup');

        Route::resource('/admin/filter-ajax-handler', 'FilterController@filterAjaxHandler');

        Route::get('/admin/edit-filtergroup/{id}', 'FilterController@editFilterGroup');
        Route::post('/admin/edit-filtergroup/{id}', 'FilterController@editFilterGroup');

        Route::resource('/admin/available-customer', 'CustomerController@availableCustomer');
        Route::resource('/admin/customer-ajax-handler', 'CustomerController@customerAjaxHandler');
        Route::resource('/admin/add-new-customer', 'CustomerController@addNewCustomer');
        Route::get('/admin/edit-customer/{uid}', 'CustomerController@editCustomer');
        Route::post('/admin/edit-customer/{uid}', 'CustomerController@editCustomer');
        Route::resource('/admin/pending-customer', 'CustomerController@pendingCustomer');
        Route::resource('/admin/deleted-customer', 'CustomerController@deletedCustomer');


        Route::resource('/admin/add-new-supplier', 'SupplierController@addNewSupplier');
        Route::resource('/admin/available-supplier', 'SupplierController@availableSupplier');
        Route::resource('/admin/supplier-ajax-handler', 'SupplierController@supplierAjaxHandler');
        Route::resource('/admin/pending-supplier', 'SupplierController@pendingSupplier');
        Route::resource('/admin/deleted-supplier', 'SupplierController@deletedSupplier');
        Route::get('/admin/edit-supplier/{sid}', 'SupplierController@editSupplier');
        Route::post('/admin/edit-supplier/{sid}', 'SupplierController@editSupplier');
//        Route::resource('/admin/supplier-detail', 'SupplierController@supplierDetail');


        Route::resource('/admin/add-new-manager', 'ManagerController@addNewManager');
        Route::resource('/admin/available-manager', 'ManagerController@availableManager');
        Route::get('/admin/edit-manager/{mid}', 'ManagerController@editManager');
        Route::post('/admin/edit-manager/{mid}', 'ManagerController@editManager');
        Route::resource('/admin/pending-manager', 'ManagerController@pendingManager');
     //   Route::resource('/admin/manage-manager-permission', 'ManagerController@pendingManager');
        Route::resource('/admin/manager-ajax-handler', 'ManagerController@managerAjaxHandler');


        Route::resource('/admin/add-new-language', 'AdministrationController@addNewLanguage');
        Route::resource('/admin/add-language-value', 'AdministrationController@addLanguageValue');
        Route::resource('/admin/manage-language', 'AdministrationController@manageLanguage');
        Route::resource('/admin/administration-ajax-handler', 'AdministrationController@administrationAjaxhandler');
        Route::get('/admin/edit-language/{lid}', 'AdministrationController@editLanguage');
        Route::post('/admin/edit-language/{lid}', 'AdministrationController@editLanguage');



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

