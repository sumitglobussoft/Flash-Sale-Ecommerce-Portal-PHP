<?php

namespace FlashSale\Http\Modules\Campaign\Controllers;


//use FlashSale\Http\Modules\Admin\Models\ProductOption;
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
//        print_a($curlResponse);

        if ($curlResponse->code == 200) {

            return view('Campaign.Views.flashsale.flashsale-list', ['flashsaledetails' => $curlResponse->data]);
        }
    }


    /**
     * @param Request $request
     */
    public function flashsaleAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
//        $objProductOption = ProductOption::getInstance();
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
//                print_a($curlResponse);
                if ($curlResponse->code == 200) {
                    echo json_encode($curlResponse->data);
                }
                break;
            case 'getOptionVariantDetails':
                $variantId = $request->input('variantId');
                $priceModifier = $request->input('priceModifier');
                $prodId = $request->input('prodId');
                $selectedCombination = implode("_",$request->input('selectedCombination'));
                $objCurl = CurlRequestHandler::getInstance();
                $url = env("API_URL") . '/' . "/flashsale-ajax-handler";
                $mytoken = env("API_TOKEN");
                $user_id = '';
                if (Session::has('fs_customer')) {
                    $user_id = Session::get('fs_customer')['id'];
                }
                $data = array('api_token' => $mytoken, 'id' => $user_id, 'variant_id' => $variantId,'product_id' => $prodId ,'selectedCombination' => $selectedCombination,'method' => 'optionVariantDetails');
                $curlResponse = $objCurl->curlUsingPost($url, $data);
//                $variationInfo['variant'] = $colorData;
                if ($curlResponse->code == 200) {
                    echo json_encode($curlResponse->data);
                }
                break;
            default:
                break;

        }
    }


}