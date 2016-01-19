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

    protected $dateTimeFormat = 'Y-m-d h:i:s';

    /**
     * Manage option action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since xx-xx-xxxx
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function manageOptions()
    {
        $objProductOptionModel = ProductOption::getInstance();
        $where = ['rawQuery' => 'status IN (0, 1, 2)'];
        $allOptions = $objProductOptionModel->getAllOptionsWhere($where);
        return view('Admin/Views/option/manageOptions', ['allOptions' => $allOptions]);
    }

    /**
     * Add option action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 19-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
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
            $validator = Validator::make($inputData, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
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
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'New option "' . $inputData['option_name'] . '" has been added.']);
                } else {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
            }

        }
        return view('Admin/Views/option/addOption');
    }

    /**
     * Edit option action
     * @param Request $request
     * @param $id Category id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 31-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
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
                        $rules['variants.' . $variantKey . '.' . $filedName] = 'max:20|required_with:variants.' . $variantKey . '.price_modifier,variants.' . $variantKey . '.weight_modifier|unique:product_option_variants,variant_name,' .( isset($variantVal['variant_id']) ? $variantVal['variant_id'] : 'NULL') . ',variant_id,option_id,' . $id;
                        $messages['variants.' . $variantKey . '.' . $filedName . '.max'] = 'The variant name may not be greater than 20 characters.';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.required_with'] = 'The variant name field is required.';
                        $messages['variants.' . $variantKey . '.' . $filedName . '.unique'] = 'The variant name has already been taken.';
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
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $updateOptionData = array();
                    $updateOptionData['option_name'] = $inputData['option_name'];
                    $updateOptionData['shop_id'] = $inputData['shop_id'];
                    $updateOptionData['option_type'] = $inputData['option_type'];
                    $updateOptionData['description'] = $inputData['description'];
                    $updateOptionData['comment'] = $inputData['comment'];
                    if (isset($inputData['required']) && $inputData['required'] == 'on') {
                        $updateOptionData['required'] = '1';
                    } else {
                        $updateOptionData['required'] = '0';
                    }

                    $whereForUpdate = ['rawQuery' => 'option_id =?', 'bindParams' => [$id]];
                    $updateOptionResult = $objProductOptionModel->updateOptionWhere($updateOptionData, $whereForUpdate);

                    $whereForVariantId = ['rawQuery' => 'option_id =?', 'bindParams' => [$id]];
                    $selectedVariantColumn = array(DB::raw('GROUP_CONCAT(variant_id) AS variant_ids'));
                    $oldVariantIds = explode(',', $objProductOptionVariantModel->getVariantWhere($whereForVariantId, $selectedVariantColumn)->variant_ids);
                    $inputVariantIds = array();
                    $updateVariantResultFlag = false;
                    $newVariantResultFlag = false;
                    $deletedVariantResultFlag = false;
                    foreach ($variantInputData as $variantKey => $variantValues) {
                        if ($variantValues['variant_name'] != '') {
                            if (isset($variantValues['variant_id']) && in_array($variantValues['variant_id'], $oldVariantIds)) {//UPDATE VARIANT DETAILS
                                $inputVariantIds[] = $variantValues['variant_id'];

                                $updateVariantData = '';
                                $updateVariantData['variant_name'] = $variantValues['variant_name'];
                                $updateVariantData['price_modifier'] = $variantValues['price_modifier'];
                                $updateVariantData['price_modifier_type'] = $variantValues['price_modifier_type'];
                                $updateVariantData['weight_modifier'] = $variantValues['weight_modifier'];
                                $updateVariantData['weight_modifier_type'] = $variantValues['weight_modifier_type'];
                                $updateVariantData['status'] = $variantValues['status'];

                                $whereForUpdateVariant = ['rawQuery' => 'variant_id =?', 'bindParams' => [$variantValues['variant_id']]];
                                $updateVariantResult = $objProductOptionVariantModel->updateVariantWhere($updateVariantData, $whereForUpdateVariant);
                                if ($updateVariantResult) {
                                    $updateVariantResultFlag = true;
                                }
                            } else {//ADD NEW VARIANT DETAILS
                                $newVariantData['option_id'] = $id;
                                $newVariantData['variant_name'] = $variantValues['variant_name'];
                                $newVariantData['price_modifier'] = $variantValues['price_modifier'];
                                $newVariantData['price_modifier_type'] = $variantValues['price_modifier_type'];
                                $newVariantData['weight_modifier'] = $variantValues['weight_modifier'];
                                $newVariantData['weight_modifier_type'] = $variantValues['weight_modifier_type'];
                                $newVariantData['added_by'] = $userId;
                                $newVariantData['status'] = $variantValues['status'];
                                $newInsertedVariantId = $objProductOptionVariantModel->addNewVariant($newVariantData);
                                if ($newInsertedVariantId) {
                                    $newVariantResultFlag = true;
                                }
                            }
                        }
                    }

                    $variantIdsToDelete = array_diff($oldVariantIds, $inputVariantIds);
                    if (!empty($variantIdsToDelete)) {
                        $whereForDeleteVariant = ['rawQuery' => 'variant_id IN (?)', 'bindParams' => [implode(',', $variantIdsToDelete)]];
                        $deletedVariantResult = $objProductOptionVariantModel->deleteVariantWhere($whereForDeleteVariant);
                        if ($deletedVariantResult) {
                            $deletedVariantResultFlag = true;
                        }
                    }

                    if ((isset($updateOptionResult) && $updateOptionResult) ||
                        (isset($updateVariantResultFlag) && $updateVariantResultFlag) ||
                        (isset($newVariantResultFlag) && $newVariantResultFlag) ||
                        (isset($deletedVariantResultFlag) && $deletedVariantResultFlag)
                    ) {//ALL DETAILS UPDATED
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Option details has been updated.']);
                    } else {//NOTHING TO UPDATE
                        return Redirect::back()->with(['status' => 'info', 'msg' => 'Nothing to update.']);
                    }
                } catch (\Exception $e) {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Sorry, an error occurred. Please reload the page and try again.']);
                }
            }
        }

        $whereForOption = ['rawQuery' => 'option_id =? and status IN (0,1,2)', 'bindParams' => [$id]];
        $optionDetails = $objProductOptionModel->getOptionWhere($whereForOption);

        $variantDetails = $objProductOptionVariantModel->getAllVariantsWhere($whereForOption);
        if ($variantDetails) {
            $optionDetails->variantDetails = $variantDetails;
        }
        return view('Admin/Views/option/editOption', ['optionDetails' => $optionDetails]);
    }

    /**
     * Handle ajax calls
     * @param Request $request
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 22-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function optionAjaxHandler(Request $request)
    {
        $objProductOptionModel = ProductOption::getInstance();
        $objProductOptionVariantModel = ProductOptionVariant::getInstance();
        $inputData = $request->input();
        $method = $inputData['method'];

        switch ($method) {
            case 'changeOptionStatus':
                $optionId = $inputData['optionId'];
                $whereForUpdate = ['rawQuery' => 'option_id =?', 'bindParams' => [$optionId]];
                $dataToUpdate['status'] = $inputData['status'];
                $updateResult = $objProductOptionModel->updateOptionWhere($dataToUpdate, $whereForUpdate);
                if ($updateResult) {
                    echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
                break;

            case 'deleteOption':
                $optionId = $inputData['optionId'];
                $whereForDeleteOption = ['rawQuery' => 'option_id =?', 'bindParams' => [$optionId]];
                $deleteOptionResult = $objProductOptionModel->deleteOptionWhere($whereForDeleteOption);
                if ($deleteOptionResult) {//SEND NOTIFICATION TO ALL SUPPLIER
                    $deleteVariantResult = $objProductOptionVariantModel->deleteVariantWhere($whereForDeleteOption);
                    echo json_encode(['status' => 'success', 'msg' => 'Selected option has been deleted.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
                break;
            default:
                break;
        }
    }
}
