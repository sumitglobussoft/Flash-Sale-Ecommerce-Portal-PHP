<?php

namespace FlashSaleApi\Http\Controllers\Campaign;

use FlashSaleApi\Http\Models\Campaigns;
use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use PDO;
use stdClass;
use FlashSaleApi\Http\Models\Products;
use FlashSaleApi\Http\Models\Productmeta;
use FlashSaleApi\Http\Models\ProductImages;
use FlashSaleApi\Http\Models\ProductCategories;
use FlashSaleApi\Http\Models\ProductFilterOption;
use FlashSaleApi\Http\Models\ProductMaterials;
use FlashSaleApi\Http\Models\ProductPatterns;
use FlashSaleApi\Http\Models\User;
use FlashSaleApi\Http\Models\ProductTags;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
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

//        return view("Admin\admin")
    }

    /**
     * Service for product details
     * @param Request $request
     * @author Vini Dubey
     * @since  31-03-2016
     */
    public function productDetails(Request $request)
    {
        $objProductModel = Products::getInstance();
        $objProductmetaModel = Productmeta::getInstance();
        $objProductImagesModel = ProductImages::getInstance();
        $objUserModel = User::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductTag = ProductTags::getInstance();
        $postData = $request->all();
        $response = new stdClass();
        if ($postData) {
            $userId = '';
            if (isset($postData['id'])) {
                $userId = $postData['id'];
            }
            $productId = '';
            if (isset($postData['product_id'])) {
                $productId = $postData['product_id'];
            }
            $mytoken = 0;
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
            if ($authflag) {
                if ($productId != '') {
                    $whereProductName = $productId;
                    $productDetails = $objProductModel->getProductDetailsWhere($whereProductName);
//                    $productDetails = (array)$productDetails;
//                    $productmaterial = array($productDetails[0]['material_ids']);
//                    $productpatternId = array($productDetails[0]['pattern_ids']);
//                    $producttagsId = array($productDetails[0]['tag_ids']);
//                    $materialId = explode(",", $productmaterial[0]);
//                    $patternId = explode(",", $productpatternId[0]);
//                    $tagId = explode(",", $producttagsId[0]);
////                    $productmaterial = $objProductMaterial->getProductMaterialWhere($materialId);
////                    $productpattern = $objProductPattern->getProductPatternWhere($patternId);
//                    $producttags = $objProductTag->getProductTagWhere($tagId);
//                    //  $campaigns = $objCampaignModel->getCampaignProduct($whereProductName);
//                    if ($productDetails[0]) {
//                        if ($productDetails[0]['product_id'] != '') {
//                            $productsizeDetails = $objProductmetaModel->getProductsizeDetails($productDetails[0]['product_id']);
////                            echo"<pre>";print_r($productsizeDetails);die("zxdsg");
//                            $whereProductId = $productDetails[0]['product_id'];
//                            $productimages = $objProductImagesModel->getProductimagesWhere($whereProductId);
//
//                            $data['productDetails'] = $productDetails[0];
//                            //  $data['productsizes'] = $productsizeDetails;
//                            $data['productimages'] = $productimages;
//                            $data['productmaterials'] = $productmaterial;
//                            $data['productpatterns'] = $productpattern;
//                            $data['producttags'] = $producttags;
//                            $data['productUrl'] = env('WEB_URL') . "/product-details/" . $productId;
//                            $presentTime = time();
//                            $productDetails[0]['discountFlag'] = 0;
//                            if ($productDetails[0]['discount_value'] > 0) {
//
//                                $disountFlag = TRUE;
//                                if ($productDetails[0]['available_from'] != '' || $productDetails[0]['available_upto'] != '') {
//                                    if ($productDetails[0]['available_from'] != '' && $productDetails[0]['available_from'] > $presentTime) {
//
//                                        $disountFlag = FALSE;
//                                    }
//                                    if ($productDetails[0]['available_upto'] != '' && $productDetails[0]['available_upto'] < $presentTime) {
//
//                                        $disountFlag = FALSE;
//                                    }
//                                }
//                                if ($disountFlag) {
//                                    $discountedValue = 0;
//                                    $productPrice = (int)$productDetails[0]['price'];
//                                    if ($productDetails[0]['discount_type'] == 1) {
//                                        $discountedValue = $productPrice - (int)$productDetails[0]['discount_value'];
//                                    }
//                                    if ($productDetails[0]['discount_type'] == 2) {
//                                        $discountedValue = $productPrice - (int)($productPrice * ((int)$productDetails[0]['discount_value'] / 100));
//                                    }
//
//                                    $data['productDetails']['discountedprice'] = $discountedValue;
//                                    $data['productDetails']['discountFlag'] = 1;
//                                }
//                            }

//                            $response->code = 200;
//                            $response->message = "Success";
//                            $response->data = $data;


//                        } else {
//                            $response->code = 100;
//                            $response->message = "Something went Wrong. No Product Details found.";
//                            $response->data = null;
//                        }
//                    } else {
//                        $response->code = 100;
//                        $response->message = "No such Product Available.";
//                        $response->data = null;
//                    }
//                } else {
//                    $response->code = 100;
//                    $response->message = "You missed Something.";
//                    $response->data = null;
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
     * @param Request $request
     */
    public function productAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        $response = new stdClass();
        if ($method != "") {
            switch ($method) {
                case 'productsizingdetails':
                    $postData = $request->all();
                    if ($postData) {
                        $objProductmetaModel = new Productmeta();
                        $objUserModel = new User();
                        $userId = '';
                        if (isset($postData['id'])) {
                            $userId = $postData['id'];
                        }
                        $whereForloginToken = $userId;

                        $productmetaId = '';
                        if (isset($postData['productmeta_id'])) {
                            $productmetaId = $postData['productmeta_id'];
                        }

                        $mytoken = 0;
                        $authflag = false;
                        if (isset($postData['mytoken'])) {
                            $mytoken = $postData['mytoken'];
                            if ($mytoken == env("API_TOKEN")) {
                                $authflag = true;
                            } else {
                                if ($userId != '') {
                                    DB::setFetchMode(PDO::FETCH_ASSOC);
                                    $Userscredentials = $objUserModel->getUsercredsWhere($whereForloginToken);
                                    if ($mytoken == $Userscredentials['login_token']) {
                                        $authflag = true;
                                    }
                                }
                            }
                        }
                        if ($authflag) {
                            if ($productmetaId != '') {
                                DB::setFetchMode(PDO::FETCH_ASSOC);
                                $productsizeDetails = $objProductmetaModel->getProductsizeDetails($productmetaId);
                                $data = array();
                                foreach ($productsizeDetails as $sizekey => $sizeval) {

                                    $presentTime = time();
                                    $sizeval['discountFlag'] = 0;
                                    if ($sizeval['discount_value'] > 0) {


                                        $disountFlag = TRUE;
                                        if ($sizeval['available_from'] != '' || $sizeval['available_upto'] != '') {
                                            if ($sizeval['available_from'] != '' && $sizeval['available_from'] > $presentTime) {

                                                $disountFlag = FALSE;
                                            }
                                            if ($sizeval['available_upto'] != '' && $sizeval['available_upto'] < $presentTime) {

                                                $disountFlag = FALSE;
                                            }
                                        }
                                        if ($disountFlag) {
                                            $discountedValue = 0;
                                            $productPrice = (int)$sizeval['price'];
                                            if ($sizeval['discount_type'] == 1) {
                                                $discountedValue = $productPrice - (int)$sizeval['discount_value'];
                                            }
                                            if ($sizeval['discount_type'] == 2) {
                                                $discountedValue = $productPrice - (int)($productPrice * ((int)$sizeval['discount_value'] / 100));
                                            }

                                            $data[$sizekey] = $sizeval;//['productsizeDetails']
                                            $data[$sizekey]['discountedprice'] = $discountedValue;
                                            $data[$sizekey]['discountFlag'] = 1;

                                        }
                                    }
                                }
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
                        $response->code = 100;
                        $response->message = "Something went Wrong. No Details for Post.";
                        $response->data = null;
                    }
                    echo json_encode($response, true);
                    break;
                case 'getCategoryForMenu':
                    $ObjProductCategoryModel = new ProductCategories();
                    $objuser = new User();
                    $API_TOKEN = env('API_TOKEN');
                    if ($request->isMethod("POST")) {

                        $postData = $request->all();

                        if (isset($postData['api_token'])) {
                            $apitoken = $postData['api_token'];

                        }
                        if ($apitoken == $API_TOKEN) {
                            $ObjProductCategoryModel = ProductCategories::getInstance();
                            $where = ['rawQuery' => 'category_status = ? AND is_visible = ?', 'bindParams' => [1, 'Y']];
                            $selectColumn = ['product_categories.*',
                                DB::raw('GROUP_CONCAT(product_categories.category_id)AS category_ids'),
                                DB::raw('GROUP_CONCAT(product_categories.category_name)AS category_names'),
                            ];
//                            $cacheKey = "product_categories::" . implode('-', array_flatten($where));
//                            if (cacheGet($cacheKey)) {
//                                $categoryInfo = cacheGet($cacheKey);
//                            } else {
                            $categoryInfo = $ObjProductCategoryModel->getAllCategories($where, $selectColumn);


//echo'                        <pre>';print_r($categoryInfo);die("sdfv");
//                            $com = array();
//                            foreach($categoryInfo as $key => $val){
//                                 if($val->parent_category_id != 0 && $val->category_id) {
//                                     $com[$key] = $val->category_name;
//                                 }
//                            }
                            //    echo'<pre>';print_r($com);die("dxg");

//                                cacheForever($cacheKey, $categoryInfo);
//                            }
                            if ($categoryInfo) {
                                $response->code = 200;
                                $response->message = "Success";
                                $response->data = $categoryInfo;
                            } else {
                                $response->code = 400;
                                $response->message = "No user Details found.";
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
                    break;
                default:
                    break;
            }
        }
    }

    public function productFilter(Request $request)
    {

        $postData = $request->all();
        $response = new stdClass();
        echo "<pre>";
        print_r($postData);
        die("dsgvmk");

    }


}