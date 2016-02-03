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
//    \DB::listen(function ($query, $bindings, $time, $connection) {
//        $fullQuery = vsprintf(str_replace(array('%', '?'), array('%%', '%s'), $query), $bindings);
//        $result = $connection . ' (' . $time . '): ' . $fullQuery;
//        dump($result);
//    });

    Route::resource('/supplier/login', 'SupplierController@login');
    Route::resource('/supplier/register', 'SupplierController@register');
    Route::resource('/supplier/logout', 'SupplierController@logout');
    Route::post('/userAjaxHandler', 'SupplierController@userAjaxHandler');


//IF  YOU NEED TO USE GET POST, USE THIS FORMAT AS IN BELOW BLOCK COMMENT
    /*Route::get('supplier/dashboard', function () {
        return view("Admin/Views/dashboard");
    }); */

    Route::group(['middleware' => 'auth:supplier'], function () {
//        Supplier Controller
        Route::resource('/supplier/dashboard', 'SupplierController@dashboard');
        Route::resource('/supplier/profile', 'SupplierController@profile');
        Route::resource('/supplier/supplierDetails', 'SupplierController@supplierDetails');
        Route::post('/supplier/ajaxHandler', 'SupplierController@ajaxHandler');

        Route::get('images/{filename}', function ($filename) {
//            die($filename);
            $fileInfo = explode("_", $filename);
            $path = storage_path() . '/uploads/' . $fileInfo[0] . '/' . $filename;
//            die($path);

            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;

//            Route::get('images/{filename}', 'SupplierController@getImages');

        });
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

        Route::get('image/{filename}', function ($filename) {
            $filePath = explode("_", $filename);
            $folderPath = '';
            switch ($filePath[0]) {
                case 'useravatar':
                    $folderPath = $filePath[0];
                    break;
                default:
                    unset($filePath[count($filePath) - 1]);
                    $folderPath = implode('/', array_map(function ($value) {
                        return $value;
                    }, $filePath));
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