<?php
namespace FlashSale\Http\Modules\Product\Controllers;


use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDO;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\curl\CurlRequestHandler;

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
        //
//        return view("Admin\admin")
    }


    /**
     * Get All Products By Filter.
     * For Product list page.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author Vini Dubey
     * @since 29-04-2016
     */
    public function productList(Request $request)
    {
//        $postData = $request->all();
//        echo'<pre>';print_r("hgjkgy");die("Fchg");
//        print_r($_GET['cc']);die("Fchg");

        $objCurl = CurlRequestHandler::getInstance();
        $mytoken = env("API_TOKEN");
//        $url = env("API_URL") .'/'. "product-ajax-handler";
//        $data = array('api_token' => $mytoken,'method' => 'product-filter-option');
//        $curlResponse = $objCurl->curlUsingPost($url, $data);
//        if ($curlResponse) {
//            return view('Product.Views.productList', ['productFilterData' => $curlResponse->data]);
//        }


        $url = env("API_URL") . '/' . "product-list";

        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];
        }
        $subcategoryName = urlencode($request->input('subcatName'));
        $categoryName = urlencode($request->input('catName'));
        $option = $request->input('option');
        $limit = 6;
        $pageNumber = $request->input('pageNumber');
        $priceRangeFrom = $request->input('priceRangeFrom');
        $priceRangeUpto = $request->input('priceRangeUpto');
        $gender = $request->input('gender');
        $sortBy = $request->input('sort_by');

        $data = array('api_token' => $mytoken, 'id' => $user_id, 'subcategory_name' => $subcategoryName, 'category_name' => $categoryName,
            'option' => $option, 'limit' => $limit, 'page_number' => 1, 'price_range_from' => $priceRangeFrom,
            'price_range_upto' => $priceRangeUpto,'sort_by' => $sortBy);
//        $data = array('api_token' => $mytoken, 'id' => 1, 'subcategory_name' => $subcategoryName, 'category_name' => $categoryName,
//            'option' => 1, 'limit' => $limit, 'page_number' => 1);
//       echo'<pre>';print_r($data);die("fch");
//        $data = array('api_token' => $mytoken, 'id' => 1,'subcategory_name' => "Women's Clothing", 'category_name' => "Apparel",
//            'option' => 1, 'limit' => 6, 'page_number' => 1, 'price_range_from' => 500,
//            'price_range_upto'=> 13000, 'sort_by' => "price-desc");
        $curlResponse = $objCurl->curlUsingPost($url, $data);
        print_a($curlResponse);
        if ($curlResponse) {
            return view('Product.Views.productList', ['productList' => $curlResponse->data]);
        }

    }

    public function productAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $api_url = env('API_URL');
        $API_TOKEN = env('API_TOKEN');
        $objCurlHandler = CurlRequestHandler::getInstance();
        if ($method) {
            switch ($method) {

                case 'getProductFilterOption':

                    break;
                default:
                    break;
            }

        }

    }


}
