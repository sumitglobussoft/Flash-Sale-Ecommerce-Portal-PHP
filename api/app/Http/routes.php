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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('/product-details','Campaign\ProductController@productdetails');
Route::resource('/flashsale-details','Campaign\FlashsaleController@flashsaledetails');
Route::resource('/dailyspecial-details','Campaign\DailyspecialController@dailyspecialdetails');
Route::resource('/shop-details','Campaign\ShopController@shopdetails');
Route::resource('/product-ajax-handler','Campaign\ProductController@productAjaxHandler');
Route::resource('/product-filter','Campaign\ProductController@productfilter');
Route::resource('/signup','User\AuthenticationController@signup');
Route::resource('/login','User\AuthenticationController@login');
Route::resource('/forgot-password','User\AuthenticationController@forgotPassword');
Route::resource('/profile-settings','User\ProfileController@profileSettings');
Route::resource('/profile-ajax-handler','User\ProfileController@profileAjaxHandler');