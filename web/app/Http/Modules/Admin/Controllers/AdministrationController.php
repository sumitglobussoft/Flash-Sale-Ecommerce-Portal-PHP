<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Controllers\Controller;
use FlashSale\Http\Modules\Admin\Models\Currency;
use FlashSale\Http\Modules\Admin\Models\Languages;
use FlashSale\Http\Modules\Admin\Models\LanguageValues;
use FlashSale\Http\Modules\Admin\Models\Location;
use FlashSale\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;
use stdclass;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Config;
use Illuminate\Support\Facades\Session;
//use Xinax\LaravelGettext\Facades\LaravelGettext;
use Illuminate\Support\Facades\URL;
//use Xinax\LaravelGettext\Config\Models\Config;
use Illuminate\Support\Facades\File;


/**
 * Class AdministrationController
 * @package FlashSale\Http\Modules\Admin\Controllers
 */
class AdministrationController extends Controller
{


    /**
     * Add New Language action
     * @param Request $request
     * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 22-01-2016
     * @author Vini Dubey
     */
    public function addNewLanguage(Request $request)
    {

        $response = new stdClass();
        $ObjLanguageModel = Languages::getInstance();
        $ObjLocationModel = Location::getInstance();
//
        if ($request->isMethod('GET')) {

            $where = ['rawQuery' => 'location_type = ?', 'bindParams' => [0]];
            $countrydetails = $ObjLocationModel->getAllCountryDetails($where);

            return view('Admin/Views/administration/addNewLanguage', ['countrydetail' => $countrydetails]);

        } elseif ($request->isMethod('POST')) {
            $postData = $request->all();
            $rules = array(
                'lang_code' => 'required|unique:languages',
                'name' => 'required|max:255|unique:languages',
                'country_code' => 'required|max:255|unique:languages',
//                'activeid' => 'required',
                'statact' => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $status = $request->input('statact');
                if ($status == "on") {
                    $statdata = 1;
                } else {
                    $statdata = 0;
                }
                $destinationPath = $request->input('lang_code');
                // $languageName = $request->input('name');
                Schema::table('language_values', function ($table) use ($destinationPath) {
                    $table->text($destinationPath)->nullable()->collation('utf8_unicode_ci');
                });
                $filePath = 'message.php';
                File::makeDirectory((env('LANG_PATH') . '/' . $destinationPath), 0777, true, true);
                $uploadResponse = File::put(env('LANG_PATH') . '/' . $destinationPath . '/' . $filePath, '');

                $dataAddLanguage = array();
                $dataAddLanguage['lang_code'] = $request->input('lang_code');
                $dataAddLanguage['name'] = $request->input('name');
                $dataAddLanguage['country_code'] = $request->input('country_code');
                $dataAddLanguage['status'] = $statdata;

                $langData = $ObjLanguageModel->addlanguages($dataAddLanguage);
                if ($langData) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'New Language  has been added.']);
                } else {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }

            }
        }

//        return view('Admin/Views/administration/addNewLanguage');

    }

    /**
     * Administration Ajax Handler
     * @param Request $request
     * @return mixed
     * @author Vini Dubey
     */
    public function administrationAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $ObjLanguageModel = Languages::getInstance();
        $ObjLocationModel = Location::getInstance();
        $ObjLanguageValuesModel = LanguageValues::getInstance();
        switch ($method) {

            case 'manageLanguage':
                $available_languages = $ObjLanguageModel->getAvailableLanguageDetails();
                return Datatables::of($available_languages)
                    ->addColumn('action', function ($available_languages) {
                        return '<div role="group" class="btn-group ">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default dropdown-toggle" type="button">
                                                <i class="fa fa-cog"></i>&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/admin/edit-language/' . $available_languages->lang_id . '""><i
                                                                class="fa fa-pencil"></i>&nbsp;' . trans('message.langedit') . '</a>
                                                </li>
                                              <li><a href="/admin/edit-language/' . $available_languages->lang_id . '""><i
                                                                class="fa fa-pencil"></i>&nbsp;' . trans('message.langexport') . '</a>
                                                </li>
                                            </ul>
                                        </div>
                                             &nbsp;&nbsp;
                                            <span class="tooltips" title="Delete Language Details." data-placement="top"> <a href="#" data-cid="' . $available_languages->lang_id . '" class="btn btn-danger delete-language" style="margin-left: 10%;">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </span>';
                    })
                    ->addColumn('status', function ($available_languages) {

                        $button = '<td style="text-align: center">';
                        $button .= '<button class="btn ' . (($available_languages->status == 1) ? "btn-success" : "btn-danger") . ' language-status" data-id="' . $available_languages->lang_id . '">' . (($available_languages->status == 1) ? trans('message.langactive') : trans('message.langinactive')) . ' </button>';
                        $button .= '</td>';
                        return $button;
                    })
                    ->addColumn('Add Langauge', function ($available_languages) {
                        return '<a href="/admin/multi-lang-text/' . $available_languages->lang_code . '">Add Converted Langauge Variables</a>';

                    })
//                    ->removeColumn('country_code')
                    ->make();
                break;

            case 'changeLanguageStatus':
                $userId = $inputData['UserId'];
                $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$userId]];
                $dataToUpdate['status'] = $inputData['status'];
                $updateResult = $ObjLanguageModel->updateLanguageStatus($dataToUpdate, $where);

                if ($updateResult == 1) {
                    echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
                break;

            case 'deleteLanguageStatus':
                $userId = $inputData['UserId'];
                $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$userId]];
                $deleteStatus = $ObjLanguageModel->deleteLanguage($where);
                if ($deleteStatus) {
                    echo json_encode(['status' => 'success', 'msg' => 'Language Deleted']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again . ']);

                }
                break;
            case 'manageLanguageValue':
                $manage_language_value = $ObjLanguageValuesModel->getLanguageValueDetails();
                return Datatables::of($manage_language_value)
                    ->addColumn('action', function ($manage_language_value) {
                        return '<div role="group" class="btn-group ">
                                            <button aria-expanded="false" data-toggle="dropdown"
                                                    class="btn btn-default dropdown-toggle" type="button">
                                                <i class="fa fa-cog"></i>&nbsp;
                                                <span class="caret"></span>
                                            </button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="/admin/edit-language-value/' . $manage_language_value->lang_value_id . '""><i
                                                                class="fa fa-pencil"></i>&nbsp;' . trans('message.langedit') . '</a>
                                                </li>

                                            </ul>
                                        </div>
                                             &nbsp;&nbsp;
                                            <span class="tooltips" title="Delete Language Details." data-placement="top"> <a href="#" data-cid="' . $manage_language_value->lang_value_id . '" class="btn btn-danger delete-language" style="margin-left: 10%;">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </span>';

                    })
                    ->addColumn('check', function ($manage_language_value) {
                        return '<input id="' . $manage_language_value->lang_value_id . '" class="questionCheckBox" type="checkbox" />';
                    })
                    ->make();

                break;
            case 'multi-lang-text':
                $ObjLanguageValue = LanguageValues::getInstance();
                $lcode = Lang::getLocale();

                if ($lcode == 'en') {
                    $lcode = 'value';
                }
                $selectColumn = ['language_values.*'];
                $langDetail = $ObjLanguageValue->getAllLanguageVariable($selectColumn, $lcode);
                unset($lcode);

                $langInfo = json_decode(json_encode($langDetail), true);
                $lang = new Collection();
                $lcode = Lang::getLocale();
                if ($lcode == 'en') {
                    $lcode = 'en';
                }

                foreach ($langInfo as $key => $val) {
                    $lang->push([
                        'lang_value_id' => $val['lang_value_id'],
                        'name' => $val['name'],
                        'value' => $val['value'],
                        $lcode => $val[$lcode],
//                        $lvname = $val['name'],
                    ]);

                }

                return Datatables::of($lang, $lcode)
                    ->editColumn('value', function ($lang) use ($lcode) {
                        if ($lcode == 'en') {
//                            return '<td class="text-center"><input type="text" class="form-control" readonly="readonly" id="langValue"
//                                                                   value="' . $lang['value'] . '" name="lang_value"></td>';

                            return '<td class="text-center" style="display:none"><input type="text" class="form-control" style="display:none" id="lnagId"
                                                                                        value="' . $lang['lang_value_id'] . '"
                                                                                        name="lang_id[]"></td><td class="text-center" style="display:none"><input type="text" class="form-control" style="display:none" id="lnagId"
                                                                                        value="' . $lang['name'] . '"> <td class="text-center" ><input type="text" class="form-control" id="langName" readonly="readonly"                                                                                        value="' . $lang['name'] . '"
                                                                                       name="lang_name[]"></td>';
                        } else {
                            return '<td class="text-center" style="display:none"><input type="text" class="form-control" style="display:none" id="lnagId"
                                                                                        value="' . $lang['lang_value_id'] . '"
                                                                                        name="lang_id[]"></td> <td class="text-center" ><input type="text" class="form-control" style="display:none" id="langName"
                                                                                        value="' . $lang['name'] . '"
                                                                                        name="lang_name[]"></td>
                                    <td class="text-center"><input type="text" class="form-control" readonly="readonly" id="langValue"
                                                                   value="' . $lang['value'] . '" name="lang_value"></td>';
                        }
                    })
                    ->editColumn($lcode, function ($lang) use ($lcode) {
                        if ($lcode == 'en') {
                            return '<td class="text-center"><input type="text" class="form-control" id="langCode"
                                                                   value="' . $lang['value'] . '" name="convertname[]"></td>';
                        } else {
                            return '<td class="text-center"><input type="text" class="form-control" id="langCode"
                                                                   value="' . $lang[$lcode] . '" name="convertname[]"></td>';
                        }
                    })
                    ->removeColumn('lang_value_id')
                    ->removeColumn('name')
                    ->make();

                break;
            case 'submitconvertlang':
                $ObjLanguageValue = LanguageValues::getInstance();
                $lcode = Lang::getLocale();
                if ($lcode == 'en') {
                    $lcode = 'value';
                }
                $postData = $request->all();
                $lang_name['name'] = $postData['lang_name'];
                $lang_id['lang_value_id'] = $postData['lang_id'];
                $convertName[$lcode] = $postData['convertname'];
                $case = implode(' ', array_map(function ($v, $k) {
                    return ' WHEN ' . $v . ' THEN "' . $k . '"';
                }, $postData['lang_id'], $postData['convertname']));
                if ($lcode == 'en') {
                    $lcode = 'value';
                    $updateData = [$lcode => DB::raw("(CASE lang_value_id $case END)")];
                } else {
                    $updateData = [$lcode => DB::raw("(CASE lang_value_id $case END)")];
                }
                $whereForUpdate = ['rawQuery' => 'lang_value_id IN(' . implode(',', $postData['lang_id']) . ')'];
                $updateLang = $ObjLanguageValue->updateLanguageValueStatus($updateData, $whereForUpdate);
                $langval = array_combine($lang_name['name'], $convertName[$lcode]);

                $whereForAllValues = ['rawQuery' => '1'];
                $selectedColumns = ['name', $lcode . ' AS code'];

                $array = $ObjLanguageValue->getAllLanguageVariableWhere($whereForAllValues, $selectedColumns);

                $case = ('<?php return [');
                $case .= implode(',', array_map(function ($v) {
                    return "'" . $v->name . "'" . '=>' . "'" . $v->code . "'";
                }, $array));
                $case = rtrim($case, ',');
                $case .= '];';

                File::put(env('LANG_PATH') . '/' . Lang::getLocale() . '/message.php', $case);

//                echo json_encode($updateLang) ?
//                    ['status' => 'success', 'msg' => 'Language Updated.'] :
//                    ['status' => 'error', 'msg' => 'Nothing to update.'];

                if ($updateLang) {
                    echo json_encode(['status' => 'success', 'msg' => 'Language Updated.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Nothing to update.']);
                }
                break;
            default:
                break;

        }
    }


    /**
     * Add Language Value Action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Vini Dubey
     */
    public function addLanguageValue(Request $request)
    {
        $response = new stdClass();
        $ObjLanguageModel = Languages::getInstance();
        $ObjLanguageValuesModel = LanguageValues::getInstance();

        if ($request->isMethod('POST')) {
            $postData = $request->all();
            $rules = array(
                'name' => 'required|unique:language_values',
                'value' => 'required|max:255',
            );
//            $rules = array(
//                'name' => 'required',
//                'value' => 'required',
//            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $namedata = array();
                $data['lang_code'] = 'en';
                $data['name'] = $request->input('name');
                $data['value'] = $request->input('value');

                $newData = array_map(function ($v, $k) {
                    $temp['lang_code'] = 'en';
                    $temp['name'] = $v;
                    $temp['value'] = $k;
                    return $temp;
                }, $data['name'], $data['value']);


                $array = array_merge((include env('LANG_PATH') . '/' . 'en' . '/message.php'), array_combine($data['name'], $data['value']));

                $case = ('<?php return [');
                $case .= implode(' ', array_map(function ($v, $k) {
                    return "'" . $k . "'" . '=>' . "'" . $v . "',";
                }, $array, array_keys($array)));
                $case = rtrim($case, ',');
                $case .= '];';
                File::put(env('LANG_PATH') . '/' . 'en' . '/message.php', $case);


                $languagevalue = $ObjLanguageValuesModel->addLanguagesValue($newData);

                if ($languagevalue) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'Language values Added Successfully!!.']);
                } else {
                    return Redirect::back()->with(['status' => 'info', 'msg' => 'Some Error!!.']);
                }
            }
        }

        return view('Admin/Views/administration/addLanguageValue');

    }


    /**
     * Manage Language
     * @param Request $request
     */
    public function manageLanguage(Request $request)
    {

        return view('Admin/Views/administration/manageLanguage');

    }


    /**
     * Edit Language Action
     * @param Request $request
     * @param $lid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Vini Dubey
     */
    public function editLanguage(Request $request, $lid)
    {

        $response = new stdClass();
        $ObjLanguageModel = Languages::getInstance();
        $ObjLocationModel = Location::getInstance();
        $postData = $request->all();

        if ($request->isMethod('GET')) {

            $where = ['rawQuery' => 'location_type = ?', 'bindParams' => [0]];
            $countrydetails = $ObjLocationModel->getAllCountryDetails($where);

            $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$lid]];
            $selectedColumns = ['location.name as location_name', 'languages.*'];
            $languagedetails = $ObjLanguageModel->getAllLanguageDetails($where, $selectedColumns);
            return view('Admin/Views/administration/editLanguage', ['countrydetail' => $countrydetails, 'languagedetails' => $languagedetails[0]]);

        } elseif ($request->isMethod('POST')) {

            $rules = array(
                'lang_code' => 'unique:languages,lang_code,' . $lid . ',lang_id',
                'name' => trans('unique:languages,name,' . $lid . ',lang_id'),
                'country_code' => 'unique:languages,country_code,' . $lid . ',lang_id'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $data['lang_code'] = $postData['lang_code'];
                $data['name'] = $postData['name'];
                $data['country_code'] = $postData['country_code'];
                // $data['status'] = $postData['statact'];
                $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$lid]];
                $updateUser = $ObjLanguageModel->updateLanguageStatus($data, $where);
                if ($updateUser) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'Language details has been updated.']);
                } else {//NOTHING TO UPDATE
                    return Redirect::back()->with(['status' => 'info', 'msg' => 'Nothing to update.']);
                }
            }
        }

    }

    /**
     * Manage Language Values Action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageLanguageValue(Request $request)
    {

        return view('Admin/Views/administration/manageLanguageValue');

    }

    /**
     * Edit Language Values Action
     * @param Request $request
     * @param $vid
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Vini Dubey
     */
    public function editLanguageValue(Request $request, $vid)
    {

        $response = new stdClass();
        $ObjLanguageValueModel = LanguageValues::getInstance();
        $postData = $request->all();
        if ($request->isMethod('GET')) {

            $where = ['rawQuery' => 'lang_value_id = ?', 'bindParams' => [$vid]];
            $langval = $ObjLanguageValueModel->getLanguageValueDetailsById($where);

            return view('Admin/Views/administration/editLanguageValue', ['langdetails' => $langval]);
        } elseif ($request->isMethod('POST')) {

            $rules = array(
//                'name' => 'unique:language_values,name,' . $vid . ',lang_value_id',
                'value' => 'unique:language_values,value,' . $vid . ',lang_value_id'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {

//                $data['name'] = $postData['name'];
                $data['value'] = $postData['value'];
                // $data['status'] = $postData['statact'];
                $where = ['rawQuery' => 'lang_value_id = ?', 'bindParams' => [$vid]];
                $updateUser = $ObjLanguageValueModel->updateLanguageValueStatus($data, $where);
                if ($updateUser == 1) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'Language Value has been updated.']);
                } else {//NOTHING TO UPDATE
                    return Redirect::back()->with(['status' => 'info', 'msg' => 'Nothing to update.']);
                }
            }
        }
    }


    /**
     * Changes the current language and returns to previous page
     * @param Request $request
     * @param null $locale
     * @return mixed
     * @author Vini Dubey
     */
    public function changeLang(Request $request, $locale = null)
    {

        Session::put('locale', $locale);
        return Redirect::to(URL::previous());
    }


    /**
     * Get All Language Details
     * @return mixed
     * @author Vini Dubey
     */
    public static function getLanguageDetails()
    {

        $ObjLanguageModel = Languages::getInstance();
        $selectColumn = ['languages.*'];
        $langInfo = $ObjLanguageModel->getAllLanguages($selectColumn);
        return $langInfo;

    }

    /**
     * @param Request $request
     * @param $lcode
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addmultilangtext(Request $request, $lcode)
    {
        return view('Admin/Views/administration/addMultiLangText');
    }


}
