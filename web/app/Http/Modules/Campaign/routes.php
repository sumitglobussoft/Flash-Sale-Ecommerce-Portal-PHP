<?php



Route::group(array('module' => 'Campaign', 'namespace' => 'Campaign\Controllers'), function () {

    Route::get('/product-details/{pid}','ProductController@productdetails');
    Route::put('/product-details/{pid}','ProductController@productdetails');

    Route::resource('/flashsale-details','FlashSaleController@flashsaledetails');
    Route::resource('/dailyspecial-details','DailyspecialController@dailyspecialdetails');
    Route::resource('/shop-details','ShopController@shopdetails');
    Route::resource('/product-ajax-handler', 'ProductController@productAjaxHandler');
    Route::resource('/product-filter', 'ProductController@productfilter');
});
