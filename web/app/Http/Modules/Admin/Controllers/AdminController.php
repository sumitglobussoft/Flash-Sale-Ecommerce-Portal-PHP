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


class AdminController extends Controller
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

        return view("Admin/Views/dashboard");

    }

    public function adminlogin(Request $data)
    {
//        echo "<pre>";
////        Session::put("Asd", "Asda");
//        print_r(Session::all());

        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }
        if ($data->isMethod('post')) {

            $email = $data->input('email');
            $password = $data->input('password');

//            $objUser = new User();
//            $data = array(
//                'name' => 'FlashSale Admin',
//                'username' => 'admin',
//                'email' => 'admin@flashsale.com',
//                'password' => Hash::make('admin'),
////                'added_date' => time(),
//                'role' => "5",
//                'status' => '1'
//            );
//            $result = DB::table('users')->insert($data);
////            $result = $objUser->addNewUser($data);
//            echo "<pre>"; print_r($result);
//            die;

            $this->validate($data, [
                'email' => 'required|email',
                'password' => 'required',
            ], ['email.required' => 'Please enter email address or username',
                    'password.required' => 'Please enter a password']
            );
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
//                dd(Auth::User()); die;
                Session::put('flashsaleadmin', Auth::User());
//                echo "<pre>"; print_r(Session::all()); die;
                return redirect('/admin/dashboard');
            } else {
                Auth::logout();
                return redirect('/admin/login')->withErrors([
                    'errMsg' => 'Invalid credentials.'
                ]);
            }

        }
        return view("Admin/Layouts/adminlogin");
    }


    public function logout()
    {
//        print_r(Session::all());
        Session::flush();
        Auth::logout();
        return redirect()->guest('/admin/login');
    }


}
