<?php


namespace FlashSaleApi\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use PDO;
use FlashSaleApi\Http\Models\Campaigns;
use FlashSaleApi\Http\Models\ProductCategories;
use FlashSaleApi\Http\Models\Products;
use FlashSaleApi\Http\Models\User;
use stdClass;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


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
                DB::setFetchMode(PDO::FETCH_ASSOC);
                $objCampaingsModel = new Campaigns();
                $dailyDetails = $objCampaingsModel->getDailyspecialDetail();

                if ($dailyDetails) {

                    $data = $dailyDetails;

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