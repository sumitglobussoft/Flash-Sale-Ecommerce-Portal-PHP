<?php



Route::group(array('module' => 'Campaign', 'namespace' => 'Campaign\Controllers'), function () {

    Route::get('/product-details/{pid}','ProductController@productdetails');
    Route::put('/product-details/{pid}','ProductController@productdetails');

    Route::get('/flashsale-details/{flashid}','FlashSaleController@flashsaledetails');
    Route::post('/flashsale-details/{flashid}','FlashSaleController@flashsaledetails');
    Route::resource('/flashsale-ajax-handler', 'FlashSaleController@flashsaleAjaxHandler');
    Route::resource('/dailyspecial-details','DailyspecialController@dailyspecialdetails');
    Route::resource('/shop-details','ShopController@shopdetails');
    Route::resource('/product-ajax-handler', 'ProductController@productAjaxHandler');
    Route::resource('/product-filter', 'ProductController@productfilter');

//    Route::group(['middleware' => 'auth:admin'], function () {
//
//        Route::resource('/admin/flashsale-details','FlashSaleController@flashsaleDetailsAdmin');
//        Route::resource('/admin/daily-special','FlashSaleController@dailyspecialDetailsAdmin');
//
//    });
});
