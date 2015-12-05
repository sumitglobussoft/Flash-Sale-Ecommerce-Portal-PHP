<?php

namespace FlashSale\Http\Modules\Home\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Curl\CurlRequestHandler;


class HomeController extends Controller
{
//    public function __call(){
//
//    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
//        die();
        //
        return view("Home/Views/home");
    }

    public function homeAjaxHandler(Request $request){
        $method = $request->input('method');
        $api_url = env('API_URL');
        $objCurlHandler = CurlRequestHandler::getInstance();
//        $user = (array)json_decode(Auth::user());
        if ($method) {
            switch ($method) {
                case "user_signup":
                    $data['firstname'] = trim($request->input('fname'));
                    $data['lastname'] = trim($request->input('lname'));
                    $data['username'] = trim($request->input('uname'));
                    $data['email'] = trim($request->input('email'));
                    echo json_encode($data);
                    die;
//                    $url = $api_url . "/signup";
//                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    if ($curlResponse->code == 200) {
//                        echo 1;
//                        die();
//                    } else {
//                        echo 0;
//                        die();
//                    }
                    break;
                default:
                    break;
            }
        } else {
            echo 0;
            die();
        }
    }




}
