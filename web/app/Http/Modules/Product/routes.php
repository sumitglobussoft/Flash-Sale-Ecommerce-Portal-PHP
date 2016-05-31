<?php


Route::group(array('module' => 'Product', 'namespace' => 'Product\Controllers'), function () {

    Route::resource('/product-list', 'ProductController@productList');
    Route::resource('/product-ajax-handler', 'ProductController@productAjaxHandler');


});

