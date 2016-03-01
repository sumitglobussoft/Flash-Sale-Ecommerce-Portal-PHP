<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\Location;
use FlashSale\Http\Modules\Admin\Models\SettingsDescription;
use FlashSale\Http\Modules\Admin\Models\SettingsObject;
use FlashSale\Http\Modules\Admin\Models\SettingsSection;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use DB;
use Validator;
use Input;
use Redirect;

/**
 * Class SettingController
 * @package FlashSale\Http\Modules\Admin\Controllers
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class SettingController extends Controller
{
    /**
     * Control panel action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @since 06-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function controlPanel()
    {
        $objSettingsSection = SettingsSection::getInstance();
        $whereForSetting = ['rawQuery' => 'parent_id =? AND type =? AND status =?', 'bindParams' => [0, 'CORE', 1]];
        $allSections = $objSettingsSection->getAllSectionWhere($whereForSetting);
        return view('Admin/Views/setting/controlPanel', ['allSections' => $allSections]);
    }

    /**
     * Manage settings action
     * @param Request $request
     * @param string $section_id Section name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 07-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function manageSettings(Request $request, $section_id)
    {
        $time_start = microtime(true);

        $objSettingsObject = SettingsObject::getInstance();
        $objSettingsSection = SettingsSection::getInstance();

        if ($request->isMethod('post')) {
            $inputData = $request->input('update');
            if (isset($inputData) && !empty($inputData)) {
                try {
                    $updateFlag = false;
                    foreach ($inputData as $objectId => $value) {
                        $whereForUpdate = ['rawQuery' => 'object_id =?', 'bindParams' => [$objectId]];
                        if (is_array($value)) {
                            $tempValue = '#M#';
                            foreach ($value as $checkBoxKey => $checkBoxValue) {
                                if ($checkBoxValue == 'on') {
                                    $tempValue .= $checkBoxKey . '=Y&';
                                }
                            }
                            $tempValue = rtrim($tempValue, '&');
                            $updateData['value'] = $tempValue;
                        } else {
                            $updateData['value'] = ($value == 'on') ? 'Y' : $value;
                        }
                        $updatedObjectResult = $objSettingsObject->updateObjectWhere($updateData, $whereForUpdate);
                        if ($updatedObjectResult)
                            $updateFlag = true;
                        $whereForUpdate = $updateData = '';
                    }
                    return Redirect::back()->with($updateFlag ? ['status' => 'success', 'msg' => 'Your changes have been saved.'] : ['status' => 'info', 'msg' => 'Nothing to update.']);
                } catch (\Exception $e) {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Sorry, an error occurred. Please reload the page and try again.']);
                }
            }
        }
        $whereForSetting = ['rawQuery' => 'parent_id =? AND type =? AND status =?', 'bindParams' => [0, 'CORE', 1]];
        $allSection = $objSettingsSection->getAllSectionWhere($whereForSetting);

        $whereForSetting = [
            'rawQuery' => 'settings_sections.name =? AND settings_descriptions.object_type=? AND settings_descriptions.status=? AND settings_objects.status=?',
            'bindParams' => [$section_id, 'O', 1, 1]
        ];

        $allObjectsOfSection = $objSettingsObject->getAllObjectsAndVariantsOfASectionWhere($whereForSetting);

//        die("Execution time in sec: " . (microtime(true) - $time_start));

        return view('Admin/Views/setting/manageSettings', ['allObjectsOfSection' => $allObjectsOfSection, 'allSection' => $allSection]);
    }

    /**
     * Handle ajax call for settings
     * @param Request $request
     * @throws \Exception
     * @since 07-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function settingsAjaxHandler(Request $request)
    {
        $objLocationModel = Location::getInstance();
        $inputData = $request->input();
        $method = $inputData['method'];
        switch ($method) {
            case 'getLocations':
                $params = array_except($inputData, 'method');
                $filedNames = '';
                foreach ($params as $index => $param) {
                    $filedNames .= $index . '=? AND ';
                }
                $whereForLocation = ['rawQuery' => substr_replace($filedNames, '', strrpos($filedNames, 'AND'), strlen('AND')), 'bindParams' => ($params)];
                $selectedColumns = ['location_id', 'name'];
                $allCountries = $objLocationModel->getAllLocationsWhere($whereForLocation, $selectedColumns);
                echo json_encode($allCountries);
                break;
            default:
                break;
        }
    }


}
