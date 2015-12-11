<?php

namespace FlashSale\Http\Modules\Campaign;


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

class DailyspecialController extends Controller
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

    public function dailyspecialDetails(Request $request)
    {

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "dailyspecial-details";

        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $mytoken = env("API_TOKEN");
        $data = array('mytoken' => $mytoken,'id'=>$user_id);
//         echo "<pre>";print_r($data);die('ere');
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
        echo "<pre>";print_r((array)$curlResponse->data);die("xdg");
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.dailyspecial.dailyspecial-list', ['dailyspecialdetails' => (array)$curlResponse->data]);
        }

    }

}