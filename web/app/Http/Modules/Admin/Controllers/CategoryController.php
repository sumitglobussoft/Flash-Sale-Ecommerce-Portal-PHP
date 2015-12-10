<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{

    public function manageCategories()
    {
        $objProductModel = Category::getInstance();
        $pendingProducts = $objProductModel->getAllProductsWhereStatus('0');
        return view('Admin/Views/product/pending-produtcs', ['pendingProducts' => $pendingProducts]);


    }

}
