<?php



Route::group(array('module' => 'Campaign', 'namespace' => 'Campaign\Controllers'), function () {

    Route::get('/product-details/{pid}/{pname}','ProductController@productdetails');
    Route::put('/product-details/{pid}/{pname}','ProductController@productdetails');

//    Route::get('/flashsale-details/{campaign_type}/{flashid}','FlashsaleController@flashsaleDetails');
//    Route::post('/flashsale-details/{campaign_type}/{flashid}','FlashsaleController@flashsaleDetails');
    Route::get('/flashsale-details/{flashid}','FlashsaleController@flashsaleDetails');
    Route::post('/flashsale-details/{flashid}','FlashsaleController@flashsaleDetails');
    Route::resource('/flashsale-ajax-handler', 'FlashsaleController@flashsaleAjaxHandler');
    Route::resource('/dailyspecial-details','DailyspecialController@dailyspecialDetails');
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
