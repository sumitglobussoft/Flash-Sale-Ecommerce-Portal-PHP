<?php

namespace FlashSaleApi\Http\Controllers\User;

use DB;
use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;
use Validator;
use Mandrill;
use FlashSaleApi\Http\Models\User;
use FlashSaleApi\Http\Models\MailTemplate;
use Illuminate\Support\Facades\Hash;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     *  This service is use to get User profile Details
     *  @param user_id, api_token
     *  @return $userdetails
     */
    public function profileSettings(Request $request) {
        $response = new stdclass();
        $objuser = new User();
        $API_TOKEN = env('API_TOKEN');
        if ($request->isMethod("POST")) {
            $postData = $request->all();
            $userId = "";
            if (isset($postData['user_id'])) {
                $userId = $postData['user_id'];
            }
            $apitoken = 0;
            $authFlag = false;
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];
                if ($apitoken == $API_TOKEN) {
                    $authFlag = true;
                } else {
                    if ($userId != '') {
                        $Userscredentials = $objuser->getUsercredsWhere($userId);
                        if ($apitoken == $Userscredentials->login_token) {
                            $authFlag = true;
                        }
                    }
                }
            }
            if ($authFlag) {
                if ($userId != '') {
                    $userdetails = $objuser->getUsercreds($userId);
                    if ($userdetails) {
                        $response->code = 200;
                        $response->message = "Success";
                        $response->data = $userdetails;
                    } else {
                        $response->code = 400;
                        $response->message = "No user Details found.";
                        $response->data = null;
                    }
                } else {
                    $response->code = 400;
                    $response->message = "You need to login to view profile setting.";
                    $response->data = null;
                }
            } else {
                $response->code = 401;
                $response->message = "Access Denied";
                $response->data = null;
            }
        } else {
            $response->code = 401;
            $response->message = "Invalid request";
            $response->data = null;
        }
        echo json_encode($response, true);
        die;
    }
}