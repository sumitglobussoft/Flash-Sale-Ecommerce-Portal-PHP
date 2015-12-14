<?php

namespace FlashSaleApi\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use PDO;
use stdClass;
use FlashSaleApi\Http\Models\Products;
use FlashSaleApi\Http\Models\User;
use FlashSaleApi\Http\Models\Shops;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


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
        $postData = $request->all();
        $response = new stdClass();
        $objUserModel = new User();

        if ($postData) {
            $userId = '';
            if (isset($postData['id'])) {
                $userId = $postData['id'];

            }

            $mytoken = '';
            $authflag = false;
            if (isset($postData['mytoken'])) {
                $mytoken = $postData['mytoken'];

                if ($mytoken == env("API_TOKEN")) {
                    $authflag = true;

                } else {
                    if ($userId != '') {
                        $whereForloginToken = $userId;
                        DB::setFetchMode(PDO::FETCH_ASSOC);
                        $Userscredentials = $objUserModel->getUsercredsWhere($whereForloginToken);
                        if ($mytoken == $Userscredentials['login_token']) {
                            $authflag = true;
                        }
                    }
                }
            }
            if ($authflag) {//LOGIN TOKEN

                $count = 10; // The number of rows to return.    //THIS FIELD IS STATIC AS OF NOW
                if (isset($postData['count'])) {
                    $count = $postData['count'];
                }

                $offset = ''; //Start returning after this many rows.
                if (isset($postData['offset'])) {
                    $offset = $postData['offset'];
                }
                $objShopsModel = new Shops();
                $shopDetails = $objShopsModel->getShopDetail($count, $offset);  //Get all shops list and pagination for all shops
                if ($shopDetails) {

                    $data = $shopDetails;

                    $response->code = 200;
                    $response->message = "Success";
                    $response->data = $data;

                } else {
                    $response->code = 100;
                    $response->message = "Something went Wrong. No Product Details found.";
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

    }


} 