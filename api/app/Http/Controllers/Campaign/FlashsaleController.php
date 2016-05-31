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
     * @author: Vini Dubey<vinidubey@globussoft.in>
     * @since: 23-02-2016
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
                $where = ['rawQuery' => 'available_from < ? AND available_upto > ? AND campaign_status = ?', 'bindParams' => [time(), time(), 1]];
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
     * @author Vini Dubey <vinidubey@globussoft.in>
     */
    public function flashsaleProducts(Request $request)
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
                    $camp = json_decode($campaignDetails[0]->for_category_ids, true);
                    $categoryMerge = array_merge(array_keys($camp), array_flatten($camp));
                    //echo'<pre>';print_r($categoryMerge);die("dch");

//                    echo"<pre>";print_r(array_values($camp));
//                    echo"<pre>";print_r(implode(",",array_keys($camp)));die("dx");
//                    $where = ['rawQuery' => 'category_id IN(' . implode(",",$categoryMerge) . ')'];
//                    $selectedColumn = ['product_categories.*'];
//                    $getcategory = $objCategoryModel->getCategoryWhere($where, $selectedColumn);
//                    $catval = "";
//                    $category = "";
//                    foreach ($getcategory as $key => $val) {
//                        $catval[$key] = $val->category_id;
//                        $category[$val->category_id] = $val->category_name;
//                    }
                    $where = ['rawQuery' => 'category_id IN(' . implode(",", $categoryMerge) . ') OR
                    products.product_id IN(' . $campaignDetails[0]->for_product_ids . ') AND
                    product_images.image_type = 0'
                    ];

//                    $selectedColumn = ['products.*',
//                        'product_images.image_url',
//                        'productmeta.*','product_option_variants.*', 'product_options.*',
//                        'product_option_variant_relation.*',
//                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids)AS variant_id'),
//                        DB::raw('GROUP_CONCAT(DISTINCT product_options.option_id)AS option_id'),
//                        DB::raw('GROUP_CONCAT(DISTINCT product_options.option_name)AS option_name'),
//                        DB::raw('GROUP_CONCAT(DISTINCT product_options.option_type)AS option_type')];


                    $selectedColumn = ['products.*',
                        'product_images.image_url',
                        'productmeta.*',
                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id)AS option_ids'),
                        DB::raw('GROUP_CONCAT(DISTINCT product_options.option_name)AS option_names'),
                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_data  SEPARATOR "____")AS variant_datas'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination')
                    ];
                    $getProducts = $objProductModel->getProductDetailsByCategoryIds($where, $selectedColumn);
                    $campaignDetails[0]->product_info = $getProducts;

                    // For getting all productinfo and respective category name for that particular products //
//                    array_walk($campaignDetails[0]->product_info,function($productInfo) use ($category){ // where $productInfo is user-defined function
//                        $productInfo->category = $category[$productInfo->category_id];
//                    });
                    // End //

//                    $campaignDetails[0]->category = $category;
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
     * @author Vini Dubey <vinidubey@globussoft.in>
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
//                $selectedColumn = ['products.*', 'productmeta.*','product_images.*', 'product_option_variant_relation.*','product_option_variants_combination.*',DB::raw('GROUP_CONCAT(DISTINCT product_images.image_url) AS image_url'), DB::raw('GROUP_CONCAT(product_images.image_type) AS image_type'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_ids'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id) AS option_id')];
//                $selectedColumn = ['products.*', 'productmeta.*','product_images.*', 'product_option_variant_relation.*',DB::raw('GROUP_CONCAT(DISTINCT product_images.image_url) AS image_url'), DB::raw('GROUP_CONCAT(product_images.image_type) AS image_type'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_ids'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id) AS option_id')];
//                $selectedColumn = ['products.*', 'productmeta.*', 'product_option_variant_relation.*', 'product_option_variants_combination.*',DB::raw('GROUP_CONCAT(product_images.image_type) AS image_type'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.combination_id) AS combination_ids'),DB::raw('GROUP_CONCAT(DISTINCT product_images.image_url) AS image_urls'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id) AS option_id'),DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_id')];
                $selectedColumn = [
                    'products.*',
                    'product_images.*',
                    'productmeta.*',
                    'product_option_variants_combination.combination_id', 'product_option_variants_combination.variant_ids', 'product_option_variants_combination.product_id', 'product_option_variants_combination.barcode_gtin', 'product_option_variants_combination.barcode_upc', 'product_option_variants_combination.barcode_ean', 'product_option_variants_combination.shippinginfo(wi,h,we)', 'product_option_variants_combination.exception_flag',
                    'product_option_variant_relation.*',
//                    DB::raw('GROUP_CONCAT(product_images.image_type) AS image_types'),
                    DB::raw('GROUP_CONCAT(
                    CASE
                    WHEN ((SELECT COUNT(pi_id) FROM product_images  WHERE product_images.for_product_id ="' . $productId . '" AND product_images.for_combination_id !="0")!=0)
                    THEN
                        CASE
                            WHEN (product_images.image_type =1 AND (product_images.for_combination_id!=0 OR product_images.for_combination_id!=""))
                            THEN product_images.image_type
                         END
                     ELSE  product_images.image_type
                    END) AS image_types'),
                    DB::raw('GROUP_CONCAT(DISTINCT
                    CASE
                    WHEN ((SELECT COUNT(pi_id) FROM product_images  WHERE product_images.for_product_id ="' . $productId . '" AND product_images.for_combination_id !="0")!=0)
                    THEN
                        CASE
                            WHEN (product_images.image_type =1 AND (product_images.for_combination_id!=0 OR product_images.for_combination_id!=""))
                            THEN product_images.image_url
                         END
                     ELSE  product_images.image_url
                    END) AS image_urls'),
                    DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.quantity) AS combination_quantity'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.quantity_sold) AS combination_quantity_sold'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_id')
                ];
                $productDetailsForPopUp = $objProductModel->getProductAndImages($where, $selectedColumn);

                if ($productDetailsForPopUp[0]->combination_id != 0 && ($productDetailsForPopUp[0]->combination_id != '')) {
                    $whereVariant = ['rawQuery' => 'variant_id IN(' . str_replace("_", ",", $productDetailsForPopUp[0]->variant_ids_combination) . ')'];
                } else {
                    $whereVariant = ['rawQuery' => 'variant_id IN(' . $productDetailsForPopUp[0]->variant_id . ')'];

                }
                $selectedColumn = ['product_option_variants.*', 'product_options.*'];
                $variantDetails = $objOptionVariant->getOptionVariantsInfo($whereVariant, $selectedColumn);
                $uniqueOptionIDs = array_values(array_unique(array_map(function ($variantDetails) {
                    return $variantDetails->option_id;
                }, $variantDetails)));

                $temp = array();
                foreach ($uniqueOptionIDs as $OKey => $OValue) {
                    $tempOption = array();
                    foreach ($variantDetails as $VKey => $VValue) {
                        if ($OValue == $VValue->option_id) {
                            $tempOption['option_name'] = $VValue->option_name;
                            $tempOption['option_id'] = $VValue->option_id;
                            $tempOption['option_type'] = $VValue->option_type;
                            $tempOption['description'] = $VValue->description;
                            $tempOption['required'] = $VValue->required;
                            $tempOption['comment'] = $VValue->comment;
                            $tempOption['variantData']['variant_id'][] = $VValue->variant_id;
                            $tempOption['variantData']['variant_name'][] = $VValue->variant_name;
                            $tempOption['variantData']['price_modifier'][] = $VValue->price_modifier;
                            $tempOption['variantData']['price_modifier_type'][] = $VValue->price_modifier_type;
                            $tempOption['variantData']['weight_modifier'][] = $VValue->weight_modifier;
                            $tempOption['variantData']['weight_modifier_type'][] = $VValue->weight_modifier_type;

                        }

                    }
                    $temp[] = $tempOption;
                }

                $productDetailsForPopUp[0]->options = $temp;
//                echo "<pre>";print_r($productDetailsForPopUp);die;
//                echo "<pre>";print_r($optionName);die("ghk");
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
                //       echo '<pre>';print_r($productDetailsForPopUp[0]);die("fch");
//                echo'<pre>';print_r($productDetailsForPopUp);die("DXfv");
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


    /**
     * Flashsale Ajax Handler
     * @param Request $request
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
    public function flashsaleAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $objUserModel = new User();
        $objCategoryModel = ProductCategories::getInstance();
        $objProductModel = Products::getInstance();
        $objOptionVariant = ProductOptionVariants::getInstance();
        $objCampaigns = Campaigns::getInstance();
        if ($method != "") {
            switch ($method) {
                case 'optionVariantDetails':
                    $postData = $request->all();
                    $response = new stdClass();
                    if ($postData) {
                        $userId = '';
                        if (isset($postData['id'])) {
                            $userId = $postData['id'];
                        }
                        $productId = '';
                        if (isset($postData['variant_id'])) {
                            $variantId = $postData['variant_id'];
                        }
                        if (isset($postData['product_id'])) {
                            $productId = $postData['product_id'];
                        }
                        if (isset($postData['selectedCombination'])) {
                            $selectedCombination = $postData['selectedCombination'];
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
                        $variantDetails = '';
                        if ($authflag) {

                            $where = ['rawQuery' => 'product_option_variants_combination.product_id = ? AND product_option_variants_combination.variant_ids IN("' . $selectedCombination . '","' . strrev($selectedCombination) . '")', 'bindParams' => [$productId]];
                            $selectedColumn = ['product_option_variants.*', 'product_images.*',
                                'product_option_variants_combination.*',
                                'product_option_variant_relation.*',
                                DB::raw('GROUP_CONCAT(
                    CASE
                    WHEN ((SELECT COUNT(pi_id) FROM product_images  WHERE product_images.for_combination_id !="0")!=0)
                    THEN
                        CASE
                            WHEN (product_images.image_type =1 AND (product_images.for_combination_id!=0 OR product_images.for_combination_id!=""))
                            THEN product_images.image_type
                         END
                     ELSE  product_images.image_type
                    END) AS image_types'),
                                DB::raw('GROUP_CONCAT(DISTINCT
                    CASE
                    WHEN ((SELECT COUNT(pi_id) FROM product_images  WHERE product_images.for_combination_id !="0")!=0)
                    THEN
                        CASE
                            WHEN (product_images.image_type =1 AND (product_images.for_combination_id!=0 OR product_images.for_combination_id!=""))
                            THEN product_images.image_url
                         END
                     ELSE  product_images.image_url
                    END) AS image_urls'),
                                DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination'), DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_ids) AS variant_id')];
                            $optionVariantDetailsForPopUp = $objOptionVariant->getOptionVariantDetailsForPopup($where, $selectedColumn);
                            //  echo'<pre>';print_r($optionVariantDetailsForPopUp);die("fchb");
                            if ($optionVariantDetailsForPopUp[0]) {
                                $response->code = 200;
                                $response->message = "Success";
                                $response->data = $optionVariantDetailsForPopUp[0];

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
                case 'getCampaignsForMenu':
                    $postData = $request->all();
                    $response = new stdClass();
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
                        $variantDetails = '';
                        if ($authflag) {
                            $where = ['rawQuery' => 'available_from < ? AND available_upto > ? AND campaign_status = ?', 'bindParams' => [time(), time(), 1]];
                            $selectedColumns = ['Campaigns.*'];
                            $campaignDetails = $objCampaigns->getFlashsaleDetail($where, $selectedColumns);

                            $campData = [];
                            foreach ([1 => 'DS', 2 => 'FS'] as $index => $item) {
                                $campData[$item] = implode(",", array_unique(array_flatten(array_filter(array_map(function ($camp) use ($index) {
                                    if ($camp->campaign_type == $index) {
                                        return array_unique(array_merge(array_keys(json_decode($camp->for_category_ids, true)), array_flatten(json_decode($camp->for_category_ids, true))));
                                    } else {
                                        return null;
                                    }
                                }, $campaignDetails)))));
                            }
                            foreach ([1 => 'DS', 2 => 'FS'] as $index => $item) {
                                $campDatasForCampaignName[$item] = implode(",", array_unique(array_flatten(array_filter(array_map(function ($campDatasForCampaignName) use ($index) {
                                    if ($campDatasForCampaignName->campaign_type == $index) {
//                                        return array_unique(array_merge(array_keys(json_decode($camp->for_category_ids, true)), array_flatten(json_decode($camp->for_category_ids, true))));
                                        return $campDatasForCampaignName->campaign_banner;
                                    } else {
                                        return null;
                                    }
                                }, $campaignDetails)))));
                            }
                            $where = ['rawQuery' => 'category_status = ? AND category_id IN(' . implode(',', array_unique(explode(',', implode(',', $campData)))) . ')', 'bindParams' => [1]];
                            $selectColumn = ['product_categories.*'];
                            $categoryInfo = $objCategoryModel->getCategoryWhere($where, $selectColumn);
                            $final['categoryInfo'] = $categoryInfo;
                            $final['campaignCatId'] = $campData;
                            $final['campName'] = $campDatasForCampaignName;
//                            echo'<pre>';print_r($final);die("fgvj");
                            if ($final) {
                                $response->code = 200;
                                $response->message = "Success";
                                $response->data = $final;

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
    }
}
