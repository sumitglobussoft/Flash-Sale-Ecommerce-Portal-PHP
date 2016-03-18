<?php

namespace FlashSale\Http\Modules\Campaign\Controllers;


use FlashSale\Http\Modules\Admin\Models\ProductOption;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use PDO;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\curl\CurlRequestHandler;

class FlashsaleController extends Controller
{
//    public function __call(){
//
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        return view("Admin\admin")
    }

    /**
     * Get Flashsale Products And Category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Vini Dubey
     * @since 24-02-2016
     */
    public function flashsaleDetails(Request $request, $flashid)
    {

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "flashsale-products";

        $mytoken = env("API_TOKEN");
        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $flashId = $request->input('flashId');
        $data = array('api_token' => $mytoken, 'id' => $user_id, 'campaign_id' => $flashid);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.flashsale.flashsale-list', ['flashsaledetails' => $curlResponse->data]);
        }
    }


    public function flashsaleAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $objProductOption = ProductOption::getInstance();
        switch ($method) {

            case 'getProductDetailsForPopUp':
                $productId = $request->input('prodId');
                $objCurl = CurlRequestHandler::getInstance();
                $url = env("API_URL") . '/' . "product-popup";
                $mytoken = env("API_TOKEN");
                $user_id = '';
                if (Session::has('fs_customer')) {
                    $user_id = Session::get('fs_customer')['id'];
                }
                $flashId = $request->input('flashId');
                $data = array('api_token' => $mytoken, 'id' => $user_id, 'product_id' => $productId);
                $curlResponse = $objCurl->curlUsingPost($url, $data);
                $variations = $curlResponse->data['varian'];
                $uniqueOptionIDs = array_values(array_unique(array_map(function ($variations) {
//                    $variant['option_id'] = $variations['option_id'];
//                    $variant['variant'] = $variations['variant_name'];
                    return $variations['option_id'];
                }, $variations)));
                $temp = array();
                foreach ($uniqueOptionIDs as $OKey => $OValue) {
                    foreach ($variations as $VKey => $VValue) {
                        if ($OValue == $VValue['option_id']) {
                            $temp[$VValue['option_name']][] = $VValue;
                        }
                    }
                }
                foreach ($temp as $colorKey => $colorVal) {
                    foreach ($colorVal as $mainKey => $mainVal) {

                    }
                }
//                $vat = $temp['Color'];
//                $newData = array_map(function ($vat) {
//                        $actual = $vat;
//                    return $actual;
//                },$vat);
//                print_a($temp);
                $colorData = array();
                foreach ($temp['Color'] as $colorkey => $colorValue) {
//                 foreach($colorValue as $actualKey => $actualval){
                    $colorData[$colorkey] = $colorValue;
//                 }
//                print_a($colorValue);
//                    $data = implode(",",$colorValue['variant_id']);
//                   echo'<pre>';print_r($data);
                }
//                die("xdh");
//                $data = implode(",",$colorData['variant_name']);


//                $newData = array_map(function ($colorData) {
//                    $actual = $colorData;
//                    return $actual;
//                },$colorData);
//$variationInfo['variant'] = $temp;
                $variationInfo['actualData'] = $curlResponse->data;
//                print_a($variationInfo);
                if ($curlResponse->code == 200) {
//                    $curlResponse->data['varian']  = array();
//                    $newData = array_map(function ($option_name) {
//                        $temp['option_name'] = $option_name->option_name;
////                        $temp['OID'] = $option_name->OID;
////                        $temp['SID'] = $option_name->SID;
////                        $temp['DESC'] = $option_name->DESC;
////                        $temp['OT'] = $option_name->OT;
////                        $temp['CMNT'] = $option_name->CMNT;
////                        $temp['STTS'] = $option_name->STTS;
////                        $temp['RQRD'] = $option_name->RQRD;
////                        $temp['VD'] = $option_name->VD;
////                        $temp['VD'] = array_map(function ($tmp) {
////                            $Values = $tmp;
////                            return $Values;
////                        }, $option_name->VD);
//                        return $temp;
//                    },($curlResponse->data['varian']));
////                    $curlResponse->data['varian'] = $newData;
//                    print_a($newData);die;

                    echo json_encode($variationInfo);
                }
                break;
            default:
                break;

        }
    }


}