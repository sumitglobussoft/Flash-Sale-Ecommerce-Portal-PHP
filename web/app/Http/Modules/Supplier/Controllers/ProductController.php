<?php

namespace FlashSale\Http\Modules\Supplier\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use Validator;
use Input;
use Redirect;
use File;

use FlashSale\Http\Modules\Supplier\Models\User;
use FlashSale\Http\Modules\Supplier\Models\Usersmeta;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{

    public function addProduct()
    {

        return view("Supplier/Views/product/addProduct");
    }


}
