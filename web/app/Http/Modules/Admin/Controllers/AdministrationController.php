<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Controllers\Controller;
use FlashSale\Http\Modules\Admin\Models\Currency;
use FlashSale\Http\Modules\Admin\Models\Languages;
use FlashSale\Http\Modules\Admin\Models\LanguageValues;
use FlashSale\Http\Modules\Admin\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Datatables;
use stdclass;

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
//            echo"<pre>";print_r($request->all());die("Xg");

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

                $dataAddLanguage = array();
                $dataAddLanguage['lang_code'] = $request->input('lang_code');
                $dataAddLanguage['name'] = $request->input('name');
                $dataAddLanguage['country_code'] = $request->input('country_code');
                $dataAddLanguage['status'] = $statdata;
                //echo"<pre>";print_r($dataAddLanguage);die("Xg");

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

    public function administrationAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $ObjLanguageModel = Languages::getInstance();
        $ObjLocationModel = Location::getInstance();
        switch ($method) {
            case 'manageLanguage':
                $available_languages = $ObjLanguageModel->getAvailableLanguageDetails();
//                echo"<pre>";print_r($available_languages);die("xcgh");
//                $available_languages =  DB::table('languages')
//                    ->select(array('lang_id', 'lang_code', 'name', 'status', 'country_code'));
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
                                                                class="fa fa-pencil"></i>&nbsp;Edit</a>
                                                </li>
                                              <li><a href="/admin/edit-language/' . $available_languages->lang_id . '""><i
                                                                class="fa fa-pencil"></i>&nbsp;Export</a>
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
                        $button .= '<button class="btn ' . (($available_languages->status == 1) ? "btn-success" : "btn-danger") . ' language-status" data-id="' . $available_languages->lang_id . '">' . (($available_languages->status == 1) ? "Active" : "Inactive") . ' </button>';
                        $button .= '</td>';
                        return $button;
                    })
//                    ->removeColumn('country_code')
                    ->make();
                break;

            case 'changeLanguageStatus':
                $userId = $inputData['UserId'];
                $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$userId]];
//                echo"<pre>";print_r($where);die("Xgbf");
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
            default:
                break;

        }
    }


    /**
     * @param Request $request
     */
    public function addLanguageValue(Request $request)
    {

        return view('Admin/Views/administration/addLanguageValue');

    }


    /**
     * @param Request $request
     */
    public function manageLanguage(Request $request)
    {


        return view('Admin/Views/administration/manageLanguage');

    }

    public function editLanguage(Request $request,$lid)
    {

        $response = new stdClass();
        $ObjLanguageModel = Languages::getInstance();
        $ObjLocationModel = Location::getInstance();
        $postData = $request->all();
//
        if ($request->isMethod('GET')) {

            $where = ['rawQuery' => 'location_type = ?', 'bindParams' => [0]];
            $countrydetails = $ObjLocationModel->getAllCountryDetails($where);

            $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$lid]];
            $selectedColumns = ['location.name as location_name','languages.*'];
            $languagedetails = $ObjLanguageModel->getAllLanguageDetails($where,$selectedColumns);
            return view('Admin/Views/administration/editLanguage',['countrydetail' => $countrydetails,'languagedetails' => $languagedetails[0]]);

        } elseif ($request->isMethod('POST')) {
//            echo"<pre>";print_r($request->all());die("dgvf");

            $data['lang_code'] = $postData['lang_code'];
            $data['name'] = $postData['name'];
            $data['country_code'] = $postData['country_code'];
           // $data['status'] = $postData['statact'];
            $where = ['rawQuery' => 'lang_id = ?', 'bindParams' => [$lid]];
            //$where['id'] = $mid;
            $updateUser = $ObjLanguageModel->updateLanguageStatus($data, $where);
//            echo"<pre>";print_r($updateUser);die("cfh");
            if($updateUser){


            }

        }



    }

}
