<?php

namespace FlashSale\Http\Modules\Campaign\Controllers;


use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
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

    public function productDetails(Request $request, $productId)
    {

        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "product-details";

        $mytoken = env("API_TOKEN");
        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $data = array('product_id' => $productId, 'mytoken' => $mytoken, 'id' => $user_id);
        //  echo "<pre>";print_r($data);die('ere');
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
//        echo "<pre>";print_r((array)$curlResponse->data);die("xdg");
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.product.product-details', ['productdetails' => (array)$curlResponse->data]);
        }


    }


    public function productAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $objCurl = CurlRequestHandler::getInstance();
        $url = env("API_URL") . '/' . "product-ajax-handler";
        if ($method != "") {
            switch ($method) {
                case 'productsizingdetails':
                    $productmetaId = $request->input('productmetaid');
                    $mytoken = env("API_TOKEN");
                    $user_id = '';
                    if (Session::has('fs_customer')) {
                        $user_id = Session::get('fs_customer')['id'];

                    }
                    $data = array('productmeta_id' => $productmetaId, 'mytoken' => $mytoken, 'id' => $user_id, 'method' => 'productsizingdetails');
                    //  echo "<pre>";print_r($data);die('ere');
                    DB::setFetchMode(PDO::FETCH_ASSOC);
                    $curlResponse = $objCurl->curlUsingPost($url, $data);
                    if ($curlResponse->code == 200) {
                        echo json_encode($curlResponse->data);
                    }

                    break;
                default:
                    break;
            }

        }
    }


    public function productFilter(Request $request)  // Product filter action
    {

        $selectedcolorName = $request->input('selectedcolors');
        $selectedbrandName = $request->input('selectedbrand');
        $selectedsizeName = $request->input('selectedsize');
        $selectedmaterialName = $request->input('selectedmaterial');
        $selectedpatternName = $request->input('selectedpattern');
//        echo"<pre>";print_r($sortbyName);die("xdgv");
        return view('Campaign.Views.product.products');
        die("szaf");
        $objCurl = CurlRequestHandler::getInstance();
//        $subcategoryName = $request->input('');
        $url = env("API_URL") . '/' . "product-filter";

        $mytoken = env("API_TOKEN");
        $user_id = '';
        if (Session::has('fs_customer')) {
            $user_id = Session::get('fs_customer')['id'];

        }
        $data = array('mytoken' => $mytoken, 'id' => $user_id, 'color' => $selectedcolorName, 'brand' => $selectedbrandName, 'size' => $selectedsizeName, 'material' => $selectedmaterialName, 'pattern' => $selectedpatternName);
//          echo "<pre>";print_r($data);die('ere');
        DB::setFetchMode(PDO::FETCH_ASSOC);
        $curlResponse = $objCurl->curlUsingPost($url, $data);
        echo "<pre>";
        print_r((array)$curlResponse->data);
        die("xdg");
        if ($curlResponse->code == 200) {
            return view('Campaign.Views.product.products', ['productfilter' => (array)$curlResponse->data]);
        }


    }
}