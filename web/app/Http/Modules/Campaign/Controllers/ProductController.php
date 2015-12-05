<?php

namespace FlashSale\Http\Modules\Campaign\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\curl\CurlRequestHandler;

class ProductController extends Controller
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

    public function productDetails(Request $request,$productId){

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "product/product-details";
        $mytoken = "123456";
        $data = array('product_id' => $productId, 'mytoken' => $mytoken);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.flashsale', ['product-details' => $curlResponse->data]);
        }


    }


}