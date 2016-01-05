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
//        Session::put('fs_user', "hhfgh");
//       echo "<pre>"; print_r(Session::get('fs_user')['profilepic']);
//        die();
        //
        return view("Home/Views/home");
    }

    public function homeAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        $api_url = env('API_URL');
        $API_TOKEN = env('API_TOKEN');
        $objCurlHandler = CurlRequestHandler::getInstance();
        if ($method) {
            switch ($method) {
                case "user_signup":
                    $data['first_name'] = trim($request->input('fname'));
                    $data['last_name'] = trim($request->input('lname'));
                    $data['username'] = trim($request->input('uname'));
                    $data['email'] = trim($request->input('email'));
                    $data['api_token'] = $API_TOKEN;
                    $url = $api_url . "/signup";
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
                    if ($curlResponse) {
                        echo json_encode($curlResponse);
                        die();
                    } else {
                        echo 0;
                        die();
                    }
                    break;
                case "user_login":
                    $data['username'] = trim($request->input('uname'));
                    $data['password'] = trim($request->input('password'));
                    $data['api_token'] = $API_TOKEN;
                    $url = $api_url . "/login";
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    echo "<pre>";print_r($data);die();
                    if ($curlResponse->code == 200) {
                        $sessionName = 'fs_user';
                        Session::put($sessionName, $curlResponse->data);
//                        return redirect('/');
                        echo json_encode($curlResponse);
//                        die();
                    } else {
                        echo json_encode($curlResponse);
                        die();
                    }
                    break;
                case "forgotpw":
                    $fpwemail = trim($request->input('fpwemail'));
                    $data['api_token'] = $API_TOKEN;
                    $data['fpwemail'] = $fpwemail;
                    $data['method'] = "EnterEmailId";
                    $url = $api_url . "/forgot-password";
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    echo '<pre>'; print_r($curlResponse);die;
                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse);
                    } else {
                        echo json_encode($curlResponse);
                    }

                    break;
                case "verifyResetCode":
                    $fpwemail = trim($request->input('fpwemail'));
                    $resetcode = trim($request->input('resetcode'));
                    $data['api_token'] = $API_TOKEN;
                    $data['fpwemail'] = $fpwemail;
                    $data['resetcode'] = $resetcode;
                    $data['method'] = "verifyResetCode";
                    $url = $api_url . "/forgot-password";
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                        echo '<pre>'; print_r($curlResponse); die;
                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse);
                    } else {
                        echo json_encode($curlResponse);
                    }

                    break;
                case "resetPassword":
                    $fpwemail = trim($request->input('fpwemail'));
                    $resetcode = trim($request->input('reset_code'));
                    $password = trim($request->input('password'));
                    $re_password = trim($request->input('re_password'));
                    $data['api_token'] = $API_TOKEN;
                    $data['fpwemail'] = $fpwemail;
                    $data['resetcode'] = $resetcode;
                    $data['password'] = $password;
                    $data['re_password'] = $re_password;
                    $data['method'] = "resetPassword";
//                        echo '<pre>'; print_r($data); die;
                    $url = $api_url . "/forgot-password";
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                        echo '<pre>'; print_r($curlResponse); die;
                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse);
                    } else {
                        echo json_encode($curlResponse);
                    }

                    break;
                default:
                    break;
            }
        } else {
            echo 0;
            die();
        }
    }

    public function logout()
    {
        Session::forget('fs_user');
        return redirect('/');
    }

}
