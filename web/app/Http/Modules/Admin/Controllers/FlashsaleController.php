<?php
namespace FlashSale\Http\Modules\Admin\Controllers;


use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use FlashSale\Http\Modules\Admin\Models\Products;
use FlashSaleApi\Http\Models\ProductCategories;
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

class FlashsaleController extends Controller
{


    public function addFlashsale(Request $request)
    {


        return view('Admin/Views/flashsale/addFlashsale');
    }

    public function flashsaleAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $objCategoryModel = ProductCategory::getInstance();
        switch ($method) {
            case 'getActiveCategories':
                $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?','bindParams' => [1,0]];
                echo'<pre>';print_r($where);die("dx");
                $allactiveproducts = $objCategoryModel->getAllMainCategories($where);
                if (!empty($allactiveproducts)) {
                    echo json_encode($allactiveproducts);
                } else {
                    echo 0;
                }
                break;
        }
    }

}