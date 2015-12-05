<?php

namespace FlashSaleApi\Http\Controllers\Campaign;

use Illuminate\Http\Request;

use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use stdClass;
use FlashSaleApi\Http\Models\Products;
use FlashSaleApi\Http\Models\Productmeta;
use FlashSaleApi\Http\Models\ProductImages;
use Illuminate\Support\Facades\Session;
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

    /** Developer: Vini Dubey
     *  Date: 04 Dec 2015
     *  Desc: For fetching product details
     **/
    public function productDetails(Request $request)
    {
       // echo "<pre>";print_r("bhkg");die("drg");
        $response = new stdClass();
        $objProductModel = new Products();
      //  dd($objProductModel);die;
        $objProductmetaModel = new Productmeta();
        $objProductImagesModel = new ProductImages();
        if ($request->isMethod("POST")) {
            $postData = $request->all();
          //  echo"<pre>";print_r($postData);die;
            $productId = '';
            if (isset($postData['product_id'])) {
                $productId = $postData['product_id'];
            }
            if ($productId != '') {
                $whereProductName = "p.product_id = '" . $productId . "'";
                $productDetails = $objProductModel->getProductDetailsWhere($whereProductName);
                if ($productDetails) {
                    if ($productDetails['product_id'] != '') {
                        $productsizeDetails = $objProductmetaModel->getProductsizeDetails($productDetails['product_id']);
                        $whereProductId = "product_id = '" . $productDetails['product_id'] . "'";
                        $productimages = $objProductImagesModel->getProductimagesWhere($whereProductId);

                        $data['productDetails'] = $productDetails;
                        $data['productsizes'] = $productsizeDetails;
                        $data['productimages'] = $productimages;

                        $response->code = 200;
                        $response->message = "Success";
                        $response->data = $data;

                    } else {
                        $response->code = 100;
                        $response->message = "Something went Wrong. No Product Details found.";
                        $response->data = null;
                    }
                } else {
                    $response->code = 100;
                    $response->message = "No such Product Available.";
                    $response->data = null;
                }
            } else {
                $response->code = 100;
                $response->message = "You missed Something.";
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