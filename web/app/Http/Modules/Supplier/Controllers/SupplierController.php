<?php

namespace FlashSale\Http\Modules\Supplier\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;

use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Session;


class SupplierController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dashboard()
    {
//        $userModel = new User();
//        $users = User::all();
//        echo "<pre>";
//        foreach ($users as $user => $userval) {
//            echo $userval;
//        }
//        die;
//        echo "<pre>";
//        print_r($users);
//        die;
//        $userDetails = $userModel->getUserWhere();
//        echo "<pre>";
//        $userDetails;
//        die("asd");
//        die("Modular structure Admin dashboard");
        return view("Supplier/Views/supplier/dashboard");

    }

    public function login(Request $data)
    {
        if ($data->isMethod('post')) {
            $email = $data->input('email');
            $password = $data->input('password');
            $this->validate($data, [
                'email' => 'required|email',
                'password' => 'required',
            ], ['email.required' => 'Please enter email address or username',
                    'password.required' => 'Please enter a password']
            );
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                if (Auth::user()->role == 3) {
                    Session::put('flashsalesupplier', Auth::user());
                    return redirect()->intended('supplier/dashboard');
                } else {
                    Auth::logout();
                    return view("Supplier/Views/supplier/login")->withErrors([
                        'errMsg' => 'Invalid credentials.',
                    ]);
                }
            } else {
                return view("Supplier/Views/supplier/login")->withErrors([
                    'email' => 'Invalid credentials.',
                ]);
            }
        }
        return view("Supplier/Views/supplier/login");

//        die("Modular structure Admin login");
    }

    public function register(Request $request)
    {
//        if ($request->isMethod('post')) {
//
//            $validator = Validator::make($request->all(), [
//                'username' => 'required',
//                'email' => 'required',
//            ]);
//
//            if ($validator->fails()) {
//                return redirect('supplier/register')
//                    ->withErrors($validator)
//                    ->withInput();
//            }
//        }
//        die("register");
        return view("Supplier/Views/supplier/register");
    }
}
