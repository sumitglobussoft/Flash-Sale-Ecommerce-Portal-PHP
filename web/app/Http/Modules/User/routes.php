<?php

Route::group(array('module' => 'User', 'namespace' => 'User\Controllers'), function () {

    Route::resource('/profile-setting', 'profileController@profileSetting');
    Route::resource('/profile-ajax-handler', 'profileController@profileAjaxHandler');
//    Route::resource('/home-ajax-handler', 'HomeController@homeAjaxHandler');
//    Route::resource('/logout', 'HomeController@logout');


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

