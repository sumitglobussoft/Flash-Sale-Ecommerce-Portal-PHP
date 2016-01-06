<?php

namespace FlashSale\Http\Modules\User\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
//use Illuminate\View\View;
use View;
use Illuminate\Support\Facades\Session;
use Illuminate\Curl\CurlRequestHandler;


class ProfileController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function profileSetting(Request $request)
    {
//        echo "<pre>";print_r(Session::get('fs_user'));die;
        $api_url = env('API_URL');
        $API_TOKEN = env('API_TOKEN');
        $objCurlHandler = CurlRequestHandler::getInstance();
        $url = $api_url . "/profile-settings";
        $data['user_id'] = Session::get('fs_user')['id'];
        $data['api_token'] = $API_TOKEN;
        $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//        echo "<pre>";print_r($curlResponse);die;
//        View::make('profiledata', $curlResponse->data);
        $url = "http://".$api_url."/profile-ajax-handler";
        $api_data = array('api_url' => $url,'api_token' => $API_TOKEN);
        return view("User/Views/profile/profileSetting", ['profiledata' => $curlResponse->data],['api_data' => $api_data]);

    }

    public function profileAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $api_url = env('API_URL');
        $API_TOKEN = env('API_TOKEN');
        $objCurlHandler = CurlRequestHandler::getInstance();
        $user_id = '';
        if (isset(Session::get('fs_user')['id'])) {
            $user_id = Session::get('fs_user')['id'];
        }
        if ($method) {
            switch ($method) {
                case "changegeneralinfo":
                    $firstname = $request->input('fname');
                    $lastname = $request->input('lname');
                    $contact = $request->input('contact');
                    $email = $request->input('email');
                    $uname = $request->input('uname');
                    $data = array('user_id' => $user_id, 'api_token' => $API_TOKEN, 'method' => 'changegeneralinfo', 'firstname' => $firstname, 'lastname' => $lastname, 'contact_no' => $contact, 'email' => $email, 'username' => $uname);

                    $url = $api_url . '/profile-ajax-handler';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    echo "<pre>"; print_r($curlResponse); die;
                    echo json_encode($curlResponse);

                    break;
                case "changeshippinginfo":
                    $City = $request->input('City');
                    $State = $request->input('State');
                    $Zipcode = $request->input('Zipcode');
                    $Address1 = $request->input('Address1');
                    $Address2 = $request->input('Address2');
                    $data = array('user_id' => $user_id, 'api_token' => $API_TOKEN, 'method' => 'changeshippinginfo', 'city' => $City, 'state' => $State, 'zipcode' => $Zipcode, 'address_line_1' => $Address1, 'address_line_2' => $Address2);
                    $url = $api_url . '/profile-ajax-handler';

                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    echo "<pre>"; print_r($curlResponse); die;
                    echo json_encode($curlResponse);
                    break;
                case "changepassword":
                    $Old_password = $request->input('oldpassword');
                    $New_password = $request->input('newpassword');
                    $Re_new_password = $request->input('renewpassword');
                    $data = array('user_id' => $user_id, 'api_token' => $API_TOKEN, 'method' => 'changepassword', 'oldPassword' => $Old_password, 'newPassword' => $New_password, 'reNewPassword' => $Re_new_password);
                    $url = $api_url . '/profile-ajax-handler';
                    $curlResponse = $objCurlHandler->curlUsingPost($url, $data);
//                    echo "<pre>"; print_r($curlResponse); die;
                    echo json_encode($curlResponse);
                    break;
                default :
                    break;
            }
        }
    }

}
