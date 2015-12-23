<?php

namespace FlashSale\Http\Modules\Campaign\Controllers;


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


class ShopController extends Controller
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

    public function shopDetails(Request $request)
    {

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "shop-details";

        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $count = 10;
        $offset = $request->input('offset');
        $mytoken = env("API_TOKEN");
        $data = array('mytoken' => $mytoken, 'id' => $user_id, 'count' => $count, 'offset' => $offset);
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
//        echo "<pre>";print_r((array)$curlResponse->data);die("xdg");
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.shops.shop-details', ['shopdetails' => (array)$curlResponse->data]);
        }


    }


}