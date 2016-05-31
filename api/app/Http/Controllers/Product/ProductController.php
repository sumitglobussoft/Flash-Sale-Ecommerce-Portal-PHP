<?php

namespace FlashSaleApi\Http\Controllers\Product;

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
use FlashSaleApi\Http\Models\ProductMaterials;
use FlashSaleApi\Http\Models\ProductPatterns;
use FlashSaleApi\Http\Models\ProductFilterOption;
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
     * Get all the products based on filtering and category selection.
     * Gets product listing
     * Category,Subcategory,Filters & Feature Variant name,Sort By.
     * @param Request $request
     * @author: Vini Dubey<vinidubey@globussoft.in>
     * @since: 05/05/2016
     */
    public function productList(Request $request)
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
//                if (isset($postData['option']) && isset($postData['limit']) && isset($postData['page_number'])) {
                if (isset($postData['option']) && isset($postData['limit']) && isset($postData['page_number'])) {
                    $objProductModel = Products::getInstance();
                    $objProductCategoryModel = ProductCategories::getInstance();

                    $wherePriceRange = ['rawQuery' => 1];
                    if (isset($postData['price_range_from']) && !empty($postData['price_range_from']) && isset($postData['price_range_upto']) && !empty($postData['price_range_upto'])) {
                        $priceFrom = $postData['price_range_from'];
                        $priceTo = $postData['price_range_upto'];
                        $wherePriceRange = ['rawQuery' => 'price_total >= ' . $priceFrom . ' AND price_total <= ' . $priceTo . ''];
                    }
//                    $sortClause = "products.product_id DESC";
//                    $sortClause = ('products.product_id desc');
                    $sortClause = ['products.product_id' => 'desc'];
                    if (isset($postData['sort_by']) && !empty($postData['sort_by'])) {
                        $sortBy = $postData['sort_by'];
                        switch ($sortBy) {
                            case "null-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "timestamp-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "position-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "position-desc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "price-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.price_total' => 'asc'];
                                break;
                            case "price-desc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.price_total' => 'desc'];
                                break;
                            case "popularity-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.price_total' => 'asc'];
                                break;
                            case "bestsellers-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "bestsellers-desc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'desc'];
                                break;
                            case "on_sale-asc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'asc'];
                                break;
                            case "on_sale-desc":
//                                $sortClause = ('products.product_id desc');
                                $sortClause = ['products.product_id' => 'desc'];
                                break;
                            case "pricelowtohigh":
//                                $sortClause = ('products.price_total asc');
                                $sortClause = ['products.price_total' => 'asc'];
                                break;
                            case "pricehightolow":
//                                $sortClause = ('products.price_total desc');
                                $sortClause = ['products.price_total' => 'desc'];
                                break;

                            default:
                                break;
                        }
                    }

                    $limit = $postData['limit'];
                    $pagenumber = $postData['page_number'];
                    if (empty($postData['page_number'])) {
                        $pagenumber = 1;
                    }

                    $categoryName = '';
                    $subcategoryName = '';
                    $whereForCategoryFilter = ['rawQuery' => 1];
                    $objProductModel = Products::getInstance();
                    if (isset($postData['category_name']) && !empty($postData['category_name'])) {
                        $categoryName = $postData['category_name'];

                        if (isset($postData['subcategory_name']) && !empty($postData['subcategory_name'])) {
                            $subcategoryName = $postData['subcategory_name'];

                        }
                        $objCategoryModel = ProductCategories::getInstance();
                        $whereCategoryName = ['rawQuery' => 'category_name = ? AND parent_category_id = ? AND category_status = ?', 'bindParams' => [$categoryName, 0, 1]];
                        $selectedColumn = ['product_categories.*'];

                        $categoryDetails = $objCategoryModel->getCategoryWhere($whereCategoryName, $selectedColumn);

                        if ($categoryDetails) {
                            $categoryTreeIds = $categoryDetails[0]->category_id;
                            $whereForCategoryFilter = ['rawQuery' => 'category_id IN(' . $categoryTreeIds . ')'];
                            $whereForSubcat = ['rawQuery' => 'parent_category_id = ? AND category_status = ?', 'bindParams' => [$categoryDetails[0]->category_id, 1]];
                            $selectedColumn = ['product_categories.*', DB::raw('GROUP_CONCAT(DISTINCT category_id)AS subcatIds')];
                            $allSubcatsInCat = $objCategoryModel->getAllCategoryWhereByGrouping($whereForSubcat, $selectedColumn);

                            if (!empty($allSubcatsInCat)) {
                                $allSubcatsInCatIds = '';
                                $count = 1;
                                foreach ($allSubcatsInCat as $valueAllSubcatsInCat) {
                                    if ($count == 1) {
                                        $allSubcatsInCatIds = $valueAllSubcatsInCat->subcatIds;
                                    } else {
                                        $allSubcatsInCatIds .= "," . $valueAllSubcatsInCat->subcatIds;
                                    }
                                    $count++;
                                }
                                $categoryTreeIds .= "," . $allSubcatsInCatIds;

                                if ($subcategoryName != '') {
                                    $whereForSelectedSubcat = ['rawQuery' => 'category_name = ? AND parent_category_id = ?', 'bindParams' => [$subcategoryName, $categoryDetails[0]->category_id]];

                                    $selectedColumn = ['product_categories.*'];
                                    $selectedSubcatDetails = $objCategoryModel->getCategoryWhere($whereForSelectedSubcat, $selectedColumn);

                                    if ($selectedSubcatDetails) {
                                        $allSubcatsInCatIds = $selectedSubcatDetails[0]->category_id;
                                        $categoryTreeIds = $allSubcatsInCatIds;
                                    }
                                }
                                $whereForCategoryFilter = ['rawQuery' => 'category_id IN(' . $categoryTreeIds . ')'];

                                $selectedColumn = ['product_categories.*', DB::raw('GROUP_CONCAT(DISTINCT category_id)AS subcatIds')];
                                $allSubsubcatsInCat = $objCategoryModel->getAllCategoryWhereByGrouping($whereForCategoryFilter, $selectedColumn);

                                if (!empty($allSubsubcatsInCat)) {
                                    foreach ($allSubsubcatsInCat as $valueAllSubsubcatsInCat) {
                                        $categoryTreeIds .= "," . $valueAllSubsubcatsInCat->subcatIds;
                                    }
                                }
                            }
                        }


                        // For Filter Option and features //
                        $ObjProductFilterOptionModel = ProductFilterOption::getInstance();
//                        $where = ['rawQuery' => 'product_filter_option_status = ? AND product_filter_categories REGEXP "^[[:<:]]' . implode("|", array_unique(explode(",", $categoryTreeIds))) . '[[:<:]]"', 'bindParams' => [1]];
                        $where = ['rawQuery' => 'product_filter_option.product_filter_option_status = ? AND product_filter_option.product_filter_category_id REGEXP  "^' . implode("|", array_unique(explode(",", $categoryTreeIds))) . '"', 'bindParams' => [1]];
                        $selectColumn = ['product_filter_option.*',
                            DB::raw('GROUP_CONCAT(DISTINCT pg.product_filter_option_name)AS variant_name'),
                            DB::raw('GROUP_CONCAT(DISTINCT pg.product_filter_option_id)AS variant_ids')];
                        $filterOptionInfo = $ObjProductFilterOptionModel->getAllFilterOption($where, $selectColumn);
                        // End for filter option and feature//
                    }

                    $offset = ((int)$pagenumber - 1) * ((int)$limit);
                    $whereOption = ['rawQuery' => 1];
                    if ($postData['option'] != '') {
                        $whereOption = ['rawQuery' => 'product_option_variants.variant_id IN (' . $postData["option"] . ')'];
//                                $whereForFilter.= " and pcr.color_id in (" . $postData['selectedcolors'] . ")";
                    }
                    $whereForFilter = $whereOption;
                    $where = ['rawQuery' => 'product_status = ?', 'bindParams' => [1]];
                    $selectedColumn = ['products.*',
                        'product_images.image_url',
                        'productmeta.*',
                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.option_id)AS option_ids'),
                        DB::raw('GROUP_CONCAT(DISTINCT product_options.option_name)AS option_names'),
                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variant_relation.variant_data  SEPARATOR "____")AS variant_datas'),
                        DB::raw('GROUP_CONCAT(DISTINCT product_option_variants_combination.variant_ids) AS variant_ids_combination')];
                    $productsFiltered = $objProductModel->getProducts($where, $whereForCategoryFilter, $whereForFilter, $limit, $offset, $sortClause, $wherePriceRange, $selectedColumn);
                    $FilterDatas['filterDetails'] = $filterOptionInfo;
                    $FilterDatas['productList'] = $productsFiltered;
//                    echo'<pre>';print_r($FilterDatas);die("dv");

                    if ($FilterDatas) {
                        $data = $filterOptionInfo;
                        $response->code = 200;
                        $response->message = "Success";
                        $response->data = $data;

                    } else {
                        $response->code = 100;
                        $response->message = "Something went Wrong. No Product Details found.";
                        $response->data = null;
                    }
                } else {
                    $errorMsg = "No parameters were found.";
                    $response->code = 100;
                    $response->message = $errorMsg;
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

    public function productAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $response = new stdClass();
        if ($method != "") {
            switch ($method) {
                case 'product-filter-option':
                    $API_TOKEN = env('API_TOKEN');
                    if ($request->isMethod("POST")) {
                        $postData = $request->all();

                        if (isset($postData['api_token'])) {
                            $apitoken = $postData['api_token'];

                        }
                        if ($apitoken == $API_TOKEN) {
                            $ObjProductFilterOptionModel = ProductFilterOption::getInstance();
                            $where = ['rawQuery' => 'product_filter_option_status = ?', 'bindParams' => [1]];
                            $selectColumn = ['product_filter_option.*', 'product_features.*', 'product_feature_variants.*',
                                DB::raw('GROUP_CONCAT(DISTINCT product_filter_category_id)AS product_filter_categories'),
                                DB::raw('GROUP_CONCAT(DISTINCT product_feature_variants.variant_name)AS feature_variant_names'),
                                DB::raw('GROUP_CONCAT(DISTINCT product_feature_variants.description)AS feature_description')];
                            $filterOptionInfo = $ObjProductFilterOptionModel->getAllFilterOption($where, $selectColumn);
//                            echo'<pre>';print_r($filterOptionInfo);die;
                            if ($filterOptionInfo) {
                                $response->code = 200;
                                $response->message = "Success";
                                $response->data = $filterOptionInfo;
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
}