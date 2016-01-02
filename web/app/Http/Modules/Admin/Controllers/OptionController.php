<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductOption;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariant;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class OptionController extends Controller
{

    public function manageOptions()
    {
        $objProductOptionModel = ProductOption::getInstance();
        $where = [
            'rawQuery' => 'status IN (0, 1, 2)'
//            'bindParams' => [0, 1, 2]
        ];
        $allOptions = $objProductOptionModel->getAllOptionsWhere($where);
//        echo '<pre>';
//        print_r($allOptions);
//        die;
        return view('Admin/Views/option/manageOptions', ['allOptions' => $allOptions]);
    }

    public function addOption(Request $request)
    {
        $userId = Session::get('fs_admin')['id'];
        if ($request->isMethod('post')) {
            $inputData = $request->input('option_data');
            $variantInputData = $request->input('option_data')['variants'];
            $rules = array(
                'option_name' => 'required|max:50|unique:product_options,option_name,NULL,option_id,shop_id,' . $inputData['shop_id'] . ',added_by,' . $userId,
                'description' => 'max:255',
                'comment' => 'max:100'
            );
            $filedNames = array_keys($variantInputData[key($variantInputData)]);
            foreach ($variantInputData as $variantKey => $variantVal) {
                foreach ($filedNames as $key => $filedName) {
                    if ($filedName == 'variant_name') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'max:20|required_with:variants.' . $variantKey . '.price_modifier,variants.' . $variantKey . '.weight_modifier';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.max'] = 'The variant name may not be greater than 20 characters.';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.required_with'] = 'The variant name field is required.';
                    }
                    if ($filedName == 'price_modifier') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'regex:/^\d*(\.\d{4})?$/';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.regex'] = 'The price modifier format is invalid.';
                    }
                    if ($filedName == 'weight_modifier') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'regex:/^\d*(\.\d{4})?$/';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.regex'] = 'The weight modifier format is invalid.';
                    }
                }
            }
//            echo '<pre>';
//            print_r($rules);
//            die;
            $validator = Validator::make($inputData, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $objProductOptionModel = ProductOption::getInstance();
                $objProductOptionVariantModel = ProductOptionVariant::getInstance();

                $optionData = array();
                $optionData['option_name'] = $inputData['option_name'];
                $optionData['shop_id'] = $inputData['shop_id'];
                $optionData['option_type'] = $inputData['option_type'];
                $optionData['description'] = $inputData['description'];
                $optionData['comment'] = $inputData['comment'];
                $optionData['added_by'] = $userId;
                $optionData['status'] = '1';
                if (isset($inputData['required']) && $inputData['required'] == 'on') {
                    $optionData['required'] = '1';
                }

                $insertedOptionId = $objProductOptionModel->addNewOption($optionData);
                if ($insertedOptionId) {
                    $variantData = array();
                    foreach ($variantInputData as $variantKey => $variantValue) {
                        if ($variantValue['variant_name'] != '') {
                            $variantData['option_id'] = $insertedOptionId;
                            $variantData['variant_name'] = $variantValue['variant_name'];
                            $variantData['added_by'] = $userId;
                            $variantData['status'] = $variantValue['status'];
                            if ($variantValue['price_modifier'] != '') {
                                $variantData['price_modifier'] = $variantValue['price_modifier'];
                                $variantData['price_modifier_type'] = $variantValue['price_modifier_type'];
                            }
                            if ($variantValue['weight_modifier'] != '') {
                                $variantData['weight_modifier'] = $variantValue['weight_modifier'];
                                $variantData['weight_modifier_type'] = $variantValue['weight_modifier_type'];
                            }
                            $insertedVariantId = $objProductOptionVariantModel->addNewVariant($variantData);
                        }
                        $variantData = '';
                    }
                    return Redirect::back()->with(['status' => '1', 'msg' => 'New option "' . $inputData['option_name'] . '" has been added.']);
                } else {
                    return Redirect::back()->with(['status' => '0', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
            }

        }
        return view('Admin/Views/option/addOption');
    }

    public function editOption(Request $request, $id)
    {

        $objProductOptionModel = ProductOption::getInstance();
        $objProductOptionVariantModel = ProductOptionVariant::getInstance();
        $userId = Session::get('fs_admin')['id'];

        if ($request->isMethod('post')) {
            $inputData = $request->input('option_data');
            $variantInputData = $request->input('option_data')['variants'];
            $rules = array(
                'option_name' => 'required|max:50|unique:product_options,option_name,' . $id . ',option_id,shop_id,' . $inputData['shop_id'] . ',added_by,' . $userId,
                'description' => 'max:255',
                'comment' => 'max:100'
            );
            $filedNames = array_keys($variantInputData[key($variantInputData)]);
            foreach ($variantInputData as $variantKey => $variantVal) {
                foreach ($filedNames as $key => $filedName) {
                    if ($filedName == 'variant_name') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'max:20|required_with:variants.' . $variantKey . '.price_modifier,variants.' . $variantKey . '.weight_modifier';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.max'] = 'The variant name may not be greater than 20 characters.';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.required_with'] = 'The variant name field is required.';
                    }
                    if ($filedName == 'price_modifier') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'regex:/^\d*(\.\d{1,5})?$/';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.regex'] = 'The price modifier format is invalid.';
                    }
                    if ($filedName == 'weight_modifier') {
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'regex:/^\d*(\.\d{1,5})?$/';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.regex'] = 'The weight modifier format is invalid.';
                    }
                }
            }
            $validator = Validator::make($inputData, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $optionData = array();
                $optionData['option_name'] = $inputData['option_name'];
                $optionData['shop_id'] = $inputData['shop_id'];
                $optionData['option_type'] = $inputData['option_type'];
                $optionData['description'] = $inputData['description'];
                $optionData['comment'] = $inputData['comment'];
                if (isset($inputData['required']) && $inputData['required'] == 'on') {
                    $optionData['required'] = '1';
                } else {
                    $optionData['required'] = '0';
                }
                $whereForUpdate = [
                    'rawQuery' => 'option_id =:id',
                    'bindParams' => ['id' => $id]
                ];

//                $updateOptionResult = $objProductOptionModel->updateOptionWhere($optionData, $whereForUpdate);

                $whereForVariantId = [
                    'rawQuery' => 'option_id =:id',
                    'bindParams' => ['id' => $id]
                ];
                $selectedVariantColumn = array(DB::raw('GROUP_CONCAT(variant_id) AS variant_ids'));
                $allVariantIds = $objProductOptionVariantModel->getVariantWhere($whereForVariantId, $selectedVariantColumn);
                echo '<pre>';
                print_r($allVariantIds);
                die;
                $variantData = array();
                foreach ($variantInputData as $variantKey => $variantValues) {

                    if (isset($variantValues->variant_id)) {

                    }
                }
//                if ($updateOptionResult) {
//
//                }
            }

        }

        $whereForOption = [
            'rawQuery' => 'option_id =:id and status IN (0,1,2)',
            'bindParams' => ['id' => $id]
        ];
        $optionDetails = $objProductOptionModel->getOptionWhere($whereForOption);

        $variantDetails = $objProductOptionVariantModel->getAllVariantsWhere($whereForOption);

        if ($variantDetails) {
            $optionDetails->variantDetails = $variantDetails;
        }
//        echo '<pre>';
//        print_r($optionDetails);
//        die;
        return view('Admin/Views/option/editOption', ['optionDetails' => $optionDetails]);

    }

    public function optionAjaxHandler(Request $request)
    {
        $objProductOptionModel = ProductOption::getInstance();
        $inputData = $request->input();
        $method = $inputData['method'];

        switch ($method) {
            case 'changeOptionStatus':
                $optionId = $inputData['optionId'];
                $whereForUpdate = ['rawQuery' => "option_id =$optionId"];
                $dataToUpdate['status'] = $inputData['status'];
                $updateResult = $objProductOptionModel->updateOptionWhere($dataToUpdate, $whereForUpdate);
                if ($updateResult) {
                    echo json_encode('1');
                } else {
                    echo json_encode('0');
                }
                break;
            default:
                break;
        }
    }
}
