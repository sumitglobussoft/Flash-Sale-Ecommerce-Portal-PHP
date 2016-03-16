<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use DB;
use FlashSale\Http\Controllers\Controller;
use FlashSale\Http\Modules\Admin\Models\Tax;
use FlashSale\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

/**
 * Class TaxController
 * @package FlashSale\Http\Modules\Admin\Controllers
 * @since 03-03-2016
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class TaxController extends Controller
{

    /**
     * Manage tax details
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 03-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function manageTaxes()
    {
        $objTaxModel = Tax::getInstance();
        $whereForAllTax = ['rawQuery' => 1];
        $selectedColumns = ['tax_id', 'tax_name', 'address_type', 'price_includes_tax', 'regnumber', 'priority', 'status'];
        $allTaxDetails = $objTaxModel->getAllTaxDetailsWhere($whereForAllTax, $selectedColumns);
//        print_a($allTaxDetails);
        return view('Admin/Views/tax/manageTaxes', ['allTaxDetails' => $allTaxDetails]);
    }

    /**
     * Add new tax details
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 03-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addTax(Request $request)
    {
        if ($request->isMethod('post')) {
            $inputData = $request->input('tax_data');
            $rules = array(
                'tax_name' => 'required|unique:taxes,tax_name',
                'regnumber' => 'unique:taxes,regnumber'
            );
            $validator = Validator::make($inputData, $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $objTaxModel = Tax::getInstance();
                $taxData = array_except($inputData, ['tax_rates']);
                $taxData['tax_rates'] = json_encode(array_filter(array_map(function ($taxRate) {
                    if ($taxRate['country_id'] != '') {
                        if ($taxRate['rate_value'] == '')
                            $taxRate['rate_value'] = 0;
                        return $taxRate;
                    }
                }, $inputData['tax_rates'])));
                $insertedTaxId = $objTaxModel->addNewTax($taxData);
                if ($insertedTaxId > 0) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'New tax "' . $inputData['tax_name'] . '" has been added.']);
                } else {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
            }

        }
        return view('Admin/Views/tax/addTax');
    }


    public function editTax(Request $request, $id)
    {
        $objTaxModel = Tax::getInstance();
        $whereForTax = ['rawQuery' => 'tax_id =?', 'bindParams' => [$id]];


        if ($request->isMethod('post')) {
            $inputData = $request->input('tax_data');
//            print_a($inputData);
            $rules = array(
                'tax_name' => 'required|max:50|unique:taxes,tax_name,' . $id . ',tax_id',
                'regnumber' => 'unique:taxes,regnumber,' . $id . ',tax_id'
            );
            $validator = Validator::make($inputData, $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $taxData = array_except($inputData, ['tax_rates']);
                    if (!array_key_exists('price_includes_tax', $inputData))
                        $taxData['price_includes_tax'] = 'N';
                    $taxData['tax_rates'] = json_encode(array_filter(array_map(function ($taxRate) {
                        if ($taxRate['country_id'] != '') {
                            if ($taxRate['rate_value'] == '')
                                $taxRate['rate_value'] = 0;
                            return $taxRate;
                        }
                    }, $inputData['tax_rates'])));

                    return Redirect::back()->with(
                        ($objTaxModel->updateTaxWhere($taxData, $whereForTax) > 0) ?
                            ['status' => 'success', 'msg' => 'Tax details has been updated.'] :
                            ['status' => 'info', 'msg' => 'Nothing to update.']
                    );
                } catch (\Exception $e) {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Sorry, an error occurred. Please reload the page and try again.']);
                }
            }
        }

        $taxDetails = $objTaxModel->getTaxDetailsWhere($whereForTax);
//        print_a($taxDetails);
        return view('Admin/Views/tax/editTax', ['taxDetails' => $taxDetails]);
    }


    /**
     * Tax ajax handler
     * @param Request $request
     * @throws \Exception
     * @since 05-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function taxAjaxHandler(Request $request)
    {
        $objTaxModel = Tax::getInstance();
        $inputData = $request->input();
        $method = $inputData['method'];

        switch ($method) {
            case 'changePosition':
                $positionData = $inputData['position'];
                $case = implode(' ', array_map(function ($v, $k) {
                    return ' WHEN ' . $v . ' THEN ' . $k;
                }, $positionData, array_keys($positionData)));

                echo json_encode(
                    ($objTaxModel->updateTaxWhere(
                            ['priority' => DB::raw("(CASE tax_id $case END)")],
                            ['rawQuery' => 'tax_id IN(' . implode(',', $positionData) . ')']) > 0) ?
                        ['status' => 'success', 'msg' => 'Priority of taxes were updated.'] :
                        ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                );
                break;

            case 'changeTaxStatus':
                echo json_encode(
                    ($objTaxModel->updateTaxWhere(
                            ['status' => trim($inputData['status'])],
                            ['rawQuery' => 'tax_id =?', 'bindParams' => [$inputData['tax_id']]]) == 1) ?
                        ['status' => 'success', 'msg' => 'Status has been changed.'] :
                        ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                );
                break;

            case 'deleteTax':
                echo json_encode(
                    ($objTaxModel->deleteTaxWhere(['rawQuery' => 'tax_id =?', 'bindParams' => [$inputData['tax_id']]]) == 1) ?
                        ['status' => 'success', 'msg' => 'Selected option has been deleted.'] :
                        ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                );
                break;

            default:
                break;
        }
    }
}
