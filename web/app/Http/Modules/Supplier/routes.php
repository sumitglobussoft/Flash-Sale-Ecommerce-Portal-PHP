<?php
Route::get('/supplier', function () {
    return redirect('supplier/login');
});

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
//    \DB::listen(function ($query, $bindings, $time, $connection) {
//        $fullQuery = vsprintf(str_replace(array('%', '?'), array('%%', '%s'), $query), $bindings);
//        $result = $connection . ' (' . $time . '): ' . $fullQuery;
//        dump($result);
//    });

    Route::resource('/supplier/login', 'SupplierController@login');
    Route::resource('/supplier/register', 'SupplierController@register');
    Route::resource('/supplier/logout', 'SupplierController@logout');
    Route::post('/userAjaxHandler', 'SupplierController@userAjaxHandler');
    Route::resource('/supplier/supplierDetails', 'SupplierController@supplierDetails');

//IF  YOU NEED TO USE GET POST, USE THIS FORMAT AS IN BELOW BLOCK COMMENT
    /*Route::get('supplier/dashboard', function () {
        return view("Admin/Views/dashboard");
    }); */

    Route::group(['middleware' => 'auth:supplier'], function () {
//        Supplier Controller
        Route::resource('/supplier/dashboard', 'SupplierController@dashboard');
        Route::resource('/supplier/profile', 'SupplierController@profile');
        // Route::resource('/supplier/supplierDetails', 'SupplierController@supplierDetails');
        Route::resource('/supplier/ajaxHandler', 'SupplierController@ajaxHandler');
        Route::resource('/supplier/addNewShop', 'SupplierController@addNewShop');
        Route::resource('/supplier/shopList', 'SupplierController@shopList');
        Route::get('/supplier/editShop/{shop_id}', 'SupplierController@editShop');
        Route::post('/supplier/editShop/{shop_id}', 'SupplierController@editShop');

//        Product Controller
        Route::resource('/supplier/add-product', 'ProductController@addProduct');

//        Category Controller
        Route::resource('/supplier/manage-categories', 'CategoryController@manageCategories');
        Route::resource('/supplier/add-category', 'CategoryController@addCategory');
        Route::get('/supplier/edit-category/{id}', 'CategoryController@editCategory');
        Route::post('/supplier/edit-category/{id}', 'CategoryController@editCategory');

        Route::resource('/supplier/manage-options', 'OptionController@manageOptions');
        Route::resource('/supplier/add-option', 'OptionController@addOption');
        Route::get('/supplier/edit-option/{id}', 'OptionController@editOption');
        Route::post('/supplier/edit-option/{id}', 'OptionController@editOption');
        Route::post('/supplier/option-ajax-handler', 'OptionController@optionAjaxHandler');

//        Get image source
        Route::get('image/{filename}', function ($filename) {
            $filePath = explode("_", $filename);
            $folderPath = '';
            switch ($filePath[0]) {
                case 'product'://product_14_0_1456562271.jpg
                    $folderPath = $filePath[0] . '/' . $filePath[1];
                    break;
                default://folderName_id_timeStamp.jpg
                    $folderPath = $filePath[0];
                    break;
            }
            $path = storage_path() . '/uploads/' . $folderPath . '/' . $filename;
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        });
    });
});