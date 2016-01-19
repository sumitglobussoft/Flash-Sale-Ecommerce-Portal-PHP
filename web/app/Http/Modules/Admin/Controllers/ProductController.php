<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{

    public function addProduct()
    {
//        return view('Admin/Views/product/addProduct', ['pendingProducts' => $pendingProducts]);
        return view('Admin/Views/product/addProduct');

    }

    public function manageProducts()
    {
//        return view('Admin/Views/product/addProduct', ['pendingProducts' => $pendingProducts]);
        return view('Admin/Views/product/manageProducts');

    }

}
