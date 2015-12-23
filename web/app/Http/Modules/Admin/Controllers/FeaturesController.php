<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;

use Illuminate\Support\Facades\Session;


class FeaturesController extends Controller
{

    public function pendingProducts()
    {
        $objProductModel = Product::getInstance();
        $pendingProducts = $objProductModel->getAllProductsWhereStatus('0');
        return view('Admin/Views/product/pending-produtcs', ['pendingProducts' => $pendingProducts]);


    }

}
