<?php

namespace FlashSale\Http\Modules\Home\Controllers;

use FlashSaleApi\Http\Models\Campaigns;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Curl\CurlRequestHandler;
use Illuminate\Support\Facades\URL;


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

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "flashsale-details";

        $mytoken = env("API_TOKEN");
        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $data = array('api_token' => $mytoken, 'id' => $user_id);

        $curlResponse = $objCurl->curlUsingPost($url, $data);
        if ($curlResponse->code == 200) {
            return view('Home/Views/home',['flashsaledetails' => $curlResponse->data]);
        }
        return view("Home/Views/home",['locale'=>\Session::get('user_locale')]);
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
//                    echo "<pre>";print_r($curlResponse);die;
                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse->code);
                        die();
                    } else {
                        echo json_encode($curlResponse);
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
                        echo json_encode($curlResponse->code);
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

    /**
     * Changes the current language and returns to previous page
     * @return Redirect
     */
    public function changeLang(Request $request, $locale = null)
    {
//        Session::put('locale', $locale);
//        return Redirect::to(URL::previous());
    }


    public static function getTranslatedLanguage(){

        $api_url = env('API_URL');
        $API_TOKEN = env('API_TOKEN');
        $objCurlHandler = CurlRequestHandler::getInstance();
        $url = $api_url . "/language-translate";
        $data['user_id'] = Session::get('fs_user')['id'];
        $data['api_token'] = $API_TOKEN;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
        return $curlResponse->data;

    }

}
