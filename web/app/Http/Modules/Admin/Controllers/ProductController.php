<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use FlashSale\Http\Modules\Admin\Models\Products;
use FlashSale\Http\Modules\Admin\Models\Shops;


use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{

    public function pendingProducts()
    {
        $objProductModel = Product::getInstance();
        $pendingProducts = $objProductModel->getAllProductsWhereStatus('0');
        return view('Admin/Views/product/pending-products', ['pendingProducts' => $pendingProducts]);


    }

    public function addProduct(Request $request){

//        $ObjProductModel = new Products();
//        $productname = $request->input('name');
          $ObjStoreModel = new Shops();
          $allstores = $ObjStoreModel->getAllStoreWhere();
          $allstores = (array)$allstores;

//          echo"<pre>";print_r($allstores);die("dxg");

          return view('Admin/Views/product/add-product',['allstores' => $allstores]);
    }

}
