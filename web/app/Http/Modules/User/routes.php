<?php

Route::group(array('module' => 'User', 'namespace' => 'User\Controllers'), function () {

    Route::resource('/profile-setting', 'profileController@profileSetting');
    Route::resource('/profile-ajax-handler', 'profileController@profileAjaxHandler');
//    Route::resource('/home-ajax-handler', 'HomeController@homeAjaxHandler');
//    Route::resource('/logout', 'HomeController@logout');

});

