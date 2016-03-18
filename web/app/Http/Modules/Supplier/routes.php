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


        Route::resource('/supplier/add-flashsale', 'FlashsaleController@addFlashsale');
        Route::resource('/supplier/manage-flashsale', 'FlashsaleController@manageFlashsale');
        Route::get('/supplier/edit-flashsale/{fid}', 'FlashsaleController@editFlashsale');
        Route::post('/supplier/edit-flashsale/{fid}', 'FlashsaleController@editFlashsale');
        Route::resource('/supplier/flashsale-ajax-handler', 'FlashsaleController@flashsaleAjaxHandler');

        Route::resource('/supplier/add-new-campaign', 'DailyspecialController@addDailyspecial');
        Route::resource('/supplier/manage-campaign', 'DailyspecialController@manageDailyspecial');
        Route::get('/supplier/edit-campaign/{did}', 'DailyspecialController@editDailyspecial');
        Route::post('/supplier/edit-campaign/{did}', 'DailyspecialController@editDailyspecial');
        Route::resource('/supplier/dailyspecial-ajax-handler', 'DailyspecialController@dailyspecialAjaxHandler');
        Route::post('/supplier/campaign-list-ajax-handler/{method}', 'DailyspecialController@campaignListAjaxHandler');


        Route::resource('/supplier/add-wholesale', 'WholesaleController@addWholesale');
        Route::resource('/supplier/manage-wholesale', 'WholesaleController@manageWholesale');
        Route::get('/supplier/edit-wholesale/{wid}', 'WholesaleController@editWholesale');
        Route::post('/supplier/edit-wholesale/{wid}', 'WholesaleController@editWholesale');
        Route::post('/supplier/wholesale-ajax-handler/{method}', 'WholesaleController@wholesaleAjaxHandler');


//        Route::get('image/{filename}', function ($filename) {
//return $filename;
//            $filePath = explode("_", $filename);
//            $folderPath = '';
//            switch ($filePath[0]) {
//
//                case 'special_case':
//                    unset($filePath[count($filePath) - 1]);
//                    $folderPath = implode('/', array_map(function ($value) {
//                        return $value;
//                    }, $filePath));
//                    break;
//
////                case 'useravatar':
////                    $folderPath = $filePath[0];
////                    break;
////                case 'shopbanner':
////                    $folderPath = $filePath[0];
////                    break;
////                case 'shoplogo':
////                    $folderPath = $filePath[0];
////                    break;
////
////                case 'flashsale':
////                    $folderPath = $filePath[0];
////                    break;
////                case 'dailyspecial':
////                    $folderPath = $filePath[0];
////                    break;
//
//                default:
//                    $folderPath = $filePath[0];
//                    break;
//            }
//            $path = storage_path() . '/uploads/' . $folderPath . '/' . $filename;
//            $file = File::get($path);
//            $type = File::mimeType($path);
//            $response = Response::make($file, 200);
//            $response->header("Content-Type", $type);
//            return $response;
//        });

        Route::get('image/{filename}', function ($filename) {
            return $filename;
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

        Route::get('supplier/lang/{locale}', [
            'as'=>'lang',
            'uses'=>'SupplierController@changeLang'
        ]);
    });
});