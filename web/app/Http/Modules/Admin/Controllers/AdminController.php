<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\SettingsSection;
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
//        echo "<pre>";
//        print_r(Session::all());
//        die;
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
        return view("Admin/Views/admin/dashboard");

    }

    public function adminlogin(Request $data)
    {
//        dd($data); die;
        if (Session::has('fs_admin') || $data->session()->has('fs_admin')) {//|| Session::has('fs_manager')
            return redirect('/admin/dashboard');
        }
        if ($data->isMethod('post')) {
            $email = $data->input('email');
            $password = $data->input('password');

            /* BELOW BLOCK TO INSERT ADMIN USER FIRST TIME
            $objUser = new User();
            $data = array(
                'name' => 'FlashSale Admin',
                'username' => 'admin',
                'email' => 'admin@flashsale.com',
                'password' => Hash::make('admin'),
//                'added_date' => time(),
                'role' => "5",
                'status' => '1'
            );
            $result = DB::table('users')->insert($data);
//            $result = $objUser->addNewUser($data);
            echo "<pre>"; print_r($result);
            die; */

            $this->validate($data, [
                'email' => 'required|email',
                'password' => 'required',
            ], ['email.required' => 'Please enter email address or username',
                    'password.required' => 'Please enter a password']
            );
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $objModelUsers = User::getInstance();
//                User::getInstance();
                $userDetails = $objModelUsers->getUserById(Auth::id()); //THIS IS TO GET THE MODEL OBJECT
//                $userDetails = DB::table('users')->select()->where('id', 1)->first(); //USED TO GET ROW OBJECT
//                echo "<pre>"; print_r($userDetails); die;

                if ($userDetails->role == 5) {
                    $sessionName = 'fs_admin';
                    Session::put($sessionName, $userDetails['original']);
                    return redirect('/admin/dashboard');
                } else {
                    return redirect('/admin/login')->withErrors([
                        'errMsg' => 'Invalid credentials.'
                    ]);
                }

//                if ($userDetails['role'] == 4) {
//                    $sessionName = 'fs_manager';
//                }

            } else {
                return redirect('/admin/login')->withErrors([
                    'errMsg' => 'Invalid credentials.'
                ]);
            }
        }
        return view("Admin/Layouts/adminlogin");
    }


    public function adminLogout()
    {
        Session::forget('fs_admin');
        return redirect('/admin/login');
    }

    public function managerLogout()
    {
        Session::forget('fs_manager');
        return redirect()->guest('/manager/login');
    }


    public static function getSettingsSection()
    {
        $objSettingsSection = SettingsSection::getInstance();
        $whereForSetting = ['rawQuery' => 'parent_id =? AND type =? AND status =?', 'bindParams' => [0, 'CORE', 1]];
        $allSections = $objSettingsSection->getAllSectionWhere($whereForSetting);
        return $allSections;
    }

}
