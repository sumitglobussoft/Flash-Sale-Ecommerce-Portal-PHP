<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Controllers\Controller;
use FlashSale\Http\Modules\Admin\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

/**
 * Class CurrencyController
 * @package FlashSale\Http\Modules\Admin\Controllers
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class CurrencyController extends Controller
{

    /**
     * Manage currencies action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @since 20-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function manageCurrencies()
    {

        $objCurrencyModel = Currency::getInstance();
        $whereForCurrency = ['rawQuery' => 1];
        $allCurrencies = $objCurrencyModel->getAllCurrenciesWhere($whereForCurrency);
        return view('Admin/Views/currency/manageCurrencies', ['allCurrencies' => $allCurrencies]);
    }

    /**
     * Add new currency action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 20-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addCurrency(Request $request)
    {

        if ($request->isMethod('post')) {
            $inputData = $request->input('currency_data');
            $rules = array(
                'currency_name' => 'required|max:50|unique:currencies,currency_name',
                'currency_code' => 'required|max:50|unique:currencies,currency_code',
                'coefficient' => 'required',
                'decimals' => 'integer|min:0|max:5'
            );
            $validator = Validator::make($inputData, $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $objCurrencyModel = Currency::getInstance();
                try {
                    $inputData['currency_code'] = strtoupper($inputData['currency_code']);
                    $inputData['position'] = DB::table('currencies')->max('position') + 1;
                    //$inputData = array_filter($inputData);
                    $inputData = array_diff($inputData, array(''));

                    $insertResult = $objCurrencyModel->addNewCurrency($inputData);
                    return Redirect::back()->with(
                        ($insertResult > 0) ?
                            ['status' => 'success', 'msg' => 'New currency "' . $inputData['currency_name'] . '" has been added.'] :
                            ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                    );
                } catch (\Exception $e) {
                    return Redirect::back()->with(['status' => 'error', 'msg' => $e->getMessage()]);
                }
            }

        }
        return view('Admin/Views/currency/addCurrency');
    }

    /**
     * Edit currency action
     * @param Request $request
     * @param $currencyId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function editCurrency(Request $request, $currencyId)
    {
        $objCurrencyModel = Currency::getInstance();

        if ($request->isMethod('post')) {
            $inputData = $request->input('currency_data');
            $rules = array(
                'currency_name' => 'required|max:50|unique:currencies,currency_name,' . $currencyId . ',currency_id',
                'currency_code' => 'required|max:50|unique:currencies,currency_code,' . $currencyId . ',currency_id',
                'coefficient' => 'required_without:is_primary',
                'decimals' => 'integer|min:0|max:5'
            );
            $validator = Validator::make($inputData, $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $isPrimaryFlag = array_key_exists('is_primary', $inputData);

                    $inputData['currency_code'] = strtoupper($inputData['currency_code']);
                    $inputData['is_primary'] = ($isPrimaryFlag || array_key_exists('is_primary_old', $request->all())) ? 'Y' : 'N';
                    $inputData['coefficient'] = ($isPrimaryFlag) ? '1' : $inputData['coefficient'];

                    $inputData = array_diff($inputData, array(''));
                    
                    $whereForUpdateCurrency = ['rawQuery' => 'currency_id =?', 'bindParams' => [$currencyId]];
                    $updateResult = $objCurrencyModel->updateCurrencyWhere($inputData, $whereForUpdateCurrency);
                    if ($updateResult == 1) {
                        if ($isPrimaryFlag) {
                            $updateAllPrimaryValue['is_primary'] = 'N';
                            $whereForUpdateAllPrimaryValue = ['rawQuery' => 'currency_id !=?', 'bindParams' => [$currencyId]];
                            $updateResult = $objCurrencyModel->updateCurrencyWhere($updateAllPrimaryValue, $whereForUpdateAllPrimaryValue);
                        }
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Your changes have been saved.']);
                    } else {
                        return Redirect::back()->with(['status' => 'info', 'msg' => 'Nothing to update.']);
                    }
                } catch (\Exception $e) {
                    return Redirect::back()->with(['status' => 'error', 'msg' => $e->getMessage()]);
                }
            }
        }

        $whereForCurrency = ['rawQuery' => 'currency_id =?', 'bindParams' => [$currencyId]];
        $currencyDetails = $objCurrencyModel->getCurrencyWhere($whereForCurrency);

        return view('Admin/Views/currency/editCurrency', ['currencyDetails' => $currencyDetails]);
    }


    /**
     * Handle ajax calls
     * @param Request $request
     * @throws \Exception
     * @since 20-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function currencyAjaxHandler(Request $request)
    {
        $objCurrencyModel = Currency::getInstance();

        $inputData = $request->input();
        $method = $inputData['method'];
        try {
            switch ($method) {
                case 'changePosition':
                    $positionData = $inputData['position'];

                    $case = implode(' ', array_map(function ($v, $k) {
                        return ' WHEN ' . $v . ' THEN ' . $k;
                    }, $positionData, array_keys($positionData)));

                    echo json_encode(
                        ($objCurrencyModel->updateCurrencyWhere(
                                ['position' => DB::raw("(CASE currency_id $case END)")],
                                ['rawQuery' => 'currency_id IN(' . implode(',', $positionData) . ')']) > 0) ?
                            ['status' => 'success', 'msg' => 'Positions of currencies were updated.'] :
                            ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                    );
                    break;

                case 'deleteCurrency':
                    echo json_encode(
                        ($objCurrencyModel->deleteCurrencyWhere(
                                ['rawQuery' => 'currency_id =? AND is_primary !=?', 'bindParams' => [$inputData['currencyId'], 'Y']]) == 1) ?
                            ['status' => 'success', 'msg' => 'The currency has been deleted successfully.'] :
                            ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                    );
                    break;

                case 'changeCurrencyStatus':
                    echo json_encode(
                        ($objCurrencyModel->updateCurrencyWhere(
                                ['status' => $inputData['status']],
                                ['rawQuery' => 'currency_id =? ', 'bindParams' => [$inputData['currencyId']]]) == 1) ?
                            ['status' => 'success', 'msg' => 'Status has been changed.'] :
                            ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                    );
                    break;

                default:
                    break;
            }
        } catch (\Exception $e) {
//            echo json_encode(['status' => 'error', 'msg' => 'An exception occurred, please reload the page and try again.']);
            echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
        }
    }


}
