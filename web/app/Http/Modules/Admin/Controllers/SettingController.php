<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductCategory;
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


class SettingController extends Controller
{

    /**
     * Control panel action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 06-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function controlPanel(Request $request)
    {
        $objSettingsSection = SettingsSection::getInstance();
        $whereForSetting = ['rawQuery' => 'parent_id =? AND type =? AND status =?', 'bindParams' => [0, 'CORE', 1]];
        $allSections = $objSettingsSection->getAllSectionWhere($whereForSetting);
        return view('Admin/Views/setting/controlPanel', ['allSections' => $allSections]);
    }

    /**
     * Manage settings action
     * @param Request $request
     * @param $section_id Section name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 07-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function manageSettings(Request $request, $section_id)
    {

        $objSettingsObject = SettingsObject::getInstance();
        $objSettingsDescription = SettingsDescription::getInstance();
        $objSettingsSection = SettingsSection::getInstance();

        $whereForSetting = ['rawQuery' => 'parent_id =? AND type =? AND status =?', 'bindParams' => [0, 'CORE', 1]];

        $allSection = $objSettingsSection->getAllSectionWhere($whereForSetting);

        $whereForSetting = ['rawQuery' => 'settings_sections.name =? AND settings_descriptions.object_type=?', 'bindParams' => [$section_id, 'O']];


        $allObjectsOfSeciton = $objSettingsObject->getAllObjectsAndVariantsOfASectionWhere($whereForSetting);
        echo '<pre>';
        print_r($allObjectsOfSeciton);
        die;

        return view('Admin/Views/setting/manageSettings', ['allObjectsOfSeciton' => $allObjectsOfSeciton, 'allSection' => $allSection]);
    }


}
