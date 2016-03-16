<?php
if (!function_exists('cachePut')) {
    /**
     * Store data into cache
     * @param $key
     * @param $value
     * @param int $minutes
     * @since 15-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cachePut($key, $value, $minutes = 10)
    {
        if (!Cache::has(md5($key))) {
            if (count(explode('::', $key)) > 1 && explode('::', $key)[0] != '') {
                $groupName = explode('::', $key)[0];
                if (!Cache::has(md5($groupName))) {
                    Cache::put(md5($groupName), json_encode(array(md5($key))), $minutes);
                    Cache::put(md5($key), $value, $minutes);
                } else {
                    $groupValues = json_decode(Cache::get(md5($groupName)));
                    if (!in_array(md5($key), $groupValues)) {
                        array_push($groupValues, md5($key));
                        Cache::put(md5($groupName), json_encode($groupValues), $minutes);
                        Cache::put(md5($key), $value, $minutes);
                    }
                }
            } else {
                Cache::put(md5($key), $value, $minutes);
            }
        }
    }
}
if (!function_exists('cacheForever')) {
    /**
     * Store data into cache forever
     * @param $key
     * @param $value
     * @since 18-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cacheForever($key, $value)
    {
        if (!Cache::has(md5($key))) {
            if (count(explode('::', $key)) > 1 && explode('::', $key)[0] != '') {
                $groupName = explode('::', $key)[0];
                if (!Cache::has(md5($groupName))) {
                    Cache::forever(md5($groupName), json_encode(array(md5($key))));
                    Cache::forever(md5($key), $value);
                } else {
                    $groupValues = json_decode(Cache::get(md5($groupName)));
                    if (!in_array(md5($key), $groupValues)) {
                        array_push($groupValues, md5($key));
                        Cache::forever(md5($groupName), json_encode($groupValues));
                        Cache::forever(md5($key), $value);
                    }
                }
            } else {
                Cache::forever(md5($key), $value);
            }
        }
    }
}
if (!function_exists('cacheGet')) {
    /**
     * Get data from cache
     * @param $key
     * @return bool|array|object
     * @since 15-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cacheGet($key)
    {
        if (Cache::has(md5($key))) return Cache::get(md5($key));
        return false;
    }
}
if (!function_exists('cacheClearByKey')) {
    /**
     * Clear cache by key
     * @param $key
     * @since 16-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cacheClearByKey($key)
    {
        if (Cache::has(md5($key))) Cache::forget(md5($key));
    }
}
if (!function_exists('cacheClearByGroupNames')) {
    /**
     * Clear cache by group names
     * @param array|string $groupNames Group names to be cleared from cache data
     * @since 16-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cacheClearByGroupNames($groupNames)
    {
        if (is_array($groupNames)) {
            foreach ($groupNames as $groupName) {
                if (Cache::has(md5($groupName))) {
                    $groupValues = json_decode(Cache::get(md5($groupName)));
                    foreach ($groupValues as $groupValue) {
                        if (Cache::has($groupValue)) Cache::forget($groupValue);
                    }
                    Cache::forget(md5($groupName));
                }
            }
        } else {
            if (Cache::has(md5($groupNames))) {
                $groupValues = json_decode(Cache::get(md5($groupNames)));
                foreach ($groupValues as $groupValue) {
                    if (Cache::has($groupValue)) Cache::forget($groupValue);
                }
                Cache::forget(md5($groupNames));
            }
        }
    }
}
if (!function_exists('cacheClearByTableNames')) {
    /**
     * Clear cache by table names
     * @param array|string $tableNames Array of table names or a table name
     * @since 16-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function cacheClearByTableNames($tableNames)
    {
        if (is_array($tableNames)) {
            foreach ($tableNames as $tableName) {
                if (Cache::has(md5($tableName))) {
                    $tableNameValues = json_decode(Cache::get(md5($tableName)));
                    foreach ($tableNameValues as $tableNameValue) {
                        if (Cache::has($tableNameValue)) Cache::forget($tableNameValue);
                    }
                    Cache::forget(md5($tableName));
                }
            }
        } else {
            if (Cache::has(md5($tableNames))) {
                $tableNameValues = json_decode(Cache::get(md5($tableNames)));
                foreach ($tableNameValues as $tableNameValue) {
                    if (Cache::has($tableNameValue))
                        Cache::forget($tableNameValue);
                }
                Cache::forget(md5($tableNames));
            }
        }
    }
}

if (!function_exists('getSetting')) {
    /**
     * Get setting value and cache the value for a day
     * @param string $settingObject
     * @return mixed
     * @throws Exception
     * @since 19-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function getSetting($settingObject)
    {
        switch ($settingObject) {
            case 'price_symbol':
                $objCurrencyModel = \FlashSale\Http\Modules\Admin\Models\Currency::getInstance();
                $whereForPrice = ['rawQuery' => 'is_primary=? AND status=?', 'bindParams' => ['Y', 1]];
                $selectedColumns = ['symbol'];
                $cacheKey = "settings_objects::" . implode('-', array_flatten($whereForPrice));
                if (cacheGet($cacheKey)) {
                    $priceSymbol = cacheGet($cacheKey);
                } else {
                    $priceSymbol = $objCurrencyModel->getCurrencyWhere($whereForPrice, $selectedColumns);
                    cachePut($cacheKey, $priceSymbol, 86400);
                }
                $settingValue = $priceSymbol->symbol;
                break;
            default:
                $objSettingObject = \FlashSale\Http\Modules\Admin\Models\SettingsObject::getInstance();
                $whereForSettingObject = ['rawQuery' => 'name=?', 'bindParams' => [$settingObject]];
                $selectedColumns = ['value'];

                $cacheKey = "settings_objects::" . implode('-', array_flatten($whereForSettingObject));
                if (cacheGet($cacheKey)) {
                    $settingValue = cacheGet($cacheKey);
                } else {
                    $settingValue = $objSettingObject->getSettingObjectWhere($whereForSettingObject, $selectedColumns);
                    cachePut($cacheKey, $settingValue, 86400);
                }
                $settingValue = $settingValue->value;
                break;
        }
        return $settingValue;
    }
}

if (!function_exists('uploadImageToStoragePath')) {
    /**
     * Upload image to storage path
     * @param $image
     * @param null $folderName Folder name (mainFolder_subFolder_subSubFolder)
     * @param null $fileName
     * @param int $imageWidth
     * @param int $imageHeight
     * @return bool|string
     * @since 02-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function uploadImageToStoragePath($image, $folderName = null, $fileName = null, $imageWidth = 1024, $imageHeight = 1024)
    {
        $destinationFolder = 'uploads/';
        if ($folderName != '') {
            $folderNames = explode('_', $folderName);
            $folderPath = implode('/', array_map(function ($value) {
                return $value;
            }, $folderNames));
            $destinationFolder .= $folderPath . '/';
        }
        $destinationPath = storage_path($destinationFolder);
        if (!File::exists($destinationPath)) File::makeDirectory($destinationPath, 0777, true, true);
        $filename = ($fileName != '') ? $fileName : $folderName . '_' . time() . '.jpg';
        $imageResult = Image::make($image)->resize($imageWidth, $imageHeight, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath . $filename, imageQuality($image));
        if ($imageResult) return '/image/' . $filename;
        return false;
    }
}

if (!function_exists('imageQuality')) {
    /**
     * Get image quality for compression
     * @param $image
     * @return int
     * @since 02-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function imageQuality($image)
    {
        $imageSize = filesize($image) / (1024 * 1024);
        if ($imageSize < 0.5) return 70;
        elseif ($imageSize > 0.5 && $imageSize < 1) return 60;
        elseif ($imageSize > 1 && $imageSize < 2) return 50;
        elseif ($imageSize > 2 && $imageSize < 5) return 40;
        elseif ($imageSize > 5) return 30;
        else return 50;
    }
}


if (!function_exists('deleteImageFromStoragePath')) {
    /**
     * Delete an image from storage path
     * @param $fileName Name of the image (Ex. category_2_1432423423.jpg)
     * @return int
     * @since 03-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function deleteImageFromStoragePath($fileName)
    {
        if ($fileName != '') {
            $folderNames = explode('_', explode('/', $fileName)[2]);
            $filePath = '/uploads/';
            switch ($folderNames[0]) {
                case 'product': //product_14_0_1456562271.jpg
                    $filePath .= $folderNames[0] . '/' . $folderNames[1] . '/' . explode('/', $fileName)[2];
                    break;
                default://folderName_id_timeStamp.jpg
                    $filePath .= $folderNames[0] . '/' . explode('/', $fileName)[2];
                    break;
            }
            return (\Illuminate\Support\Facades\File::delete(storage_path() . $filePath));
        }
    }
}

if (!function_exists('print_a')) {
    /**
     * Print human-readable information about a variable and stop execution(die)
     * @param $data
     * @since 08-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    function print_a($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}
?>