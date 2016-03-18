<?php

namespace FlashSaleApi\Http\Controllers\Campaign;

use FlashSaleApi\Http\Models\ProductOptionVariants;
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


class FlashsaleController extends Controller
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


    /**
     * Service for getting all flashsale campaigns details
     * @param Request $request
     * @author Vini Dubey
     * @since 23-02-2016
     */
    public function flashsaleDetails(Request $request)
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
            if (isset($postData['api_token'])) {
                $mytoken = $postData['api_token'];

                if ($mytoken == env("API_TOKEN")) {
                    $authflag = true;

                } else {
                    if ($userId != '') {
                        $whereForloginToken = $userId;
                        $Userscredentials = $objUserModel->getUsercredsWhere($whereForloginToken);

                        if ($mytoken == $Userscredentials['login_token']) {
                            $authflag = true;
                        }
                    }
                }
            }
            if ($authflag) {//LOGIN TOKEN
                $objCampaingsModel = Campaigns::getInstance();
                $currenttime = time();
                $where = ['rawQuery' => 'campaign_type = ? AND available_from < ? AND available_upto > ? ', 'bindParams' => [2, time(), time()]];
                $selectedColumns = ['Campaigns.*'];
                $campaignDetails = $objCampaingsModel->getFlashsaleDetail($where, $selectedColumns);
                if ($campaignDetails) {
                    $data = $campaignDetails;
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


    /**
     * For Getting All Flashsale Product List
     * @param Request $request
     * @since 24-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function flashsaleProducts(Request $request)
    {
        $postData = $request->all();
        $response = new stdClass();
        $objUserModel = new User();
        $objCategoryModel = ProductCategories::getInstance();
        $objProductModel = Products::getInstance();
        if ($postData) {
            $userId = '';
            if (isset($postData['id'])) {
                $userId = $postData['id'];
            }
            $FlashsaleId = '';
            if (isset($postData['campaign_id'])) {
                $FlashsaleId = $postData['campaign_id'];
            }

            $mytoken = '';
            $authflag = false;
            if (isset($postData['api_token'])) {
                $mytoken = $postData['api_token'];

                if ($mytoken == env("API_TOKEN")) {
                    $authflag = true;

                } else {
                    if ($userId != '') {
                        $whereForloginToken = $userId;
                        $Userscredentials = $objUserModel->getUsercredsWhere($whereForloginToken);

                        if ($mytoken == $Userscredentials['login_token']) {
                            $authflag = true;
                        }
                    }
                }
            }
            $campaignDetails = '';
            if ($authflag) {//LOGIN TOKEN
                $objCampaingsModel = Campaigns::getInstance();
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$FlashsaleId]];
                $selectedColumn = ['Campaigns.*'];
                $campaignDetails = $objCampaingsModel->getFlashsaleDetail($where, $selectedColumn);
                $getProducts = '';
                $getcategory = '';
                if ($campaignDetails[0]) {
                    $campaignDetails[0]->product_info = array();
                    $where = ['rawQuery' => 'parent_category_id IN(' . $campaignDetails[0]->for_category_ids . ')'];
                    $selectedColumn = ['product_categories.*'];
                    $getcategory = $objCategoryModel->getCategoryNameById($where, $selectedColumn);
                    foreach ($getcategory as $key => $val) {
                        $catval[$key] = $val->category_id;
                    }
                    $where = ['rawQuery' => 'category_id IN(' . (implode(",", $catval)) . ') AND products.product_id IN(' .$campaignDetails[0]->for_product_ids.') AND product_images.image_type = 0'];
                    $selectedColumn = ['products.*','product_images.image_url','productmeta.*'];
                    $getProducts = $objProductModel->getProductDetailsByCategoryIds($where, $selectedColumn);
                    $campaignDetails[0]->product_info = $getProducts;

                }

                if (($campaignDetails[0])) {
                    $response->code = 200;
                    $response->message = "Success";
                    $response->data = $campaignDetails[0];

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

    /**
     * Get Product Pop Details For Flashsale Products.
     * @param Request $request
     * @since 25-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function productPopup(Request $request)
    {

        $postData = $request->all();
        $response = new stdClass();
        $objUserModel = new User();
        $objCategoryModel = ProductCategories::getInstance();
        $objProductModel = Products::getInstance();
        $objOptionVariant = ProductOptionVariants::getInstance();
        if ($postData) {
            $userId = '';
            if (isset($postData['id'])) {
                $userId = $postData['id'];
            }
            $productId = '';
            if (isset($postData['product_id'])) {
                $productId = $postData['product_id'];
            }

            $mytoken = '';
            $authflag = false;
            if (isset($postData['api_token'])) {
                $mytoken = $postData['api_token'];

                if ($mytoken == env("API_TOKEN")) {
                    $authflag = true;

                } else {
                    if ($userId != '') {
                        $whereForloginToken = $userId;
                        $Userscredentials = $objUserModel->getUsercredsWhere($whereForloginToken);

                        if ($mytoken == $Userscredentials['login_token']) {
                            $authflag = true;
                        }
                    }
                }
            }
            $campaignDetails = '';
            if ($authflag) {//LOGIN TOKEN
                $where = ['rawQuery' => 'products.product_id = ?', 'bindParams' => [$productId]];
                $selectedColumn = ['products.*', 'productmeta.*','product_option_variant_relation.*', DB::raw('GROUP_CONCAT(DISTINCT product_images.image_url) AS image_url'),DB::raw('GROUP_CONCAT(product_images.image_type) AS image_type'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_ids'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id) AS option_id')];
                $productDetailsForPopUp = $objProductModel->getProductAndImages($where, $selectedColumn);
//                echo"<pre>";print_r($productDetailsForPopUp);die("ghk");
                $where = ['rawQuery' => 'variant_id IN(' . $productDetailsForPopUp[0]->variant_ids . ')'];
                $selectedColumn = ['product_option_variants.*','product_options.*'];
                $variantDetails = $objOptionVariant->getOptionVariantsInfo($where,$selectedColumn);
                $productDetailsForPopUp[0]->varian = $variantDetails;
//                echo"<pre>";print_r($productDetailsForPopUp);die("ghk");
//                $row_array = json_decode($productDetailsForPopUp[0]->product_options);
//                $rowarray = array();
//                $newData = array_map(function ($option_name) {
//                    $temp['ON'] = $option_name->ON;
//                    $temp['OID'] = $option_name->OID;
//                    $temp['SID'] = $option_name->SID;
//                    $temp['DESC'] = $option_name->OID;
//                    $temp['OT'] = $option_name->OID;
//                    $temp['CMNT'] = $option_name->OID;
//                    $temp['STTS'] = $option_name->OID;
//                    $temp['RQRD'] = $option_name->OID;
//                    $temp['VD'] = $option_name->VD;
//                    $temp['VD'] = array_map(function ($tmp) {
//                        $Values = $tmp;
//                        return $Values;
//                    }, $option_name->VD);
//                    return $temp;
//                }, $row_array);
//                $row_array = json_decode($productDetailsForPopUp[0]->varian);
//                $variation = $productDetailsForPopUp[0]->varian;
//                $row_array = array();
//                $variant = array_map(function($variantDetails){
//                    $temp['option_name'] = $variantDetails->option_name;
//                },$row_array);
//                echo '<pre>';print_r($productDetailsForPopUp[0]);die("fch");

                if ($productDetailsForPopUp[0]) {
                    $response->code = 200;
                    $response->message = "Success";
                    $response->data = $productDetailsForPopUp[0];

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