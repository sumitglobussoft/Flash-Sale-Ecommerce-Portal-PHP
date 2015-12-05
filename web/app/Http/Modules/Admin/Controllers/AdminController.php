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
use Illuminate\Support\Facades\Validator;


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

     //   if(Session::put('flashsaleadmin', Auth::user())) {
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
// Akash code start//
//                       $this->validate($data, [
//                'email' => 'required|email',
//                'password' => 'required',
//            ], ['email.required' => 'Please enter email address or username',
//                    'password.required' => 'Please enter a password']
//            );


// End //


//            $result['message'] = NULL;
//            echo $email; echo bcrypt($password); die;
//            $objModelUser = new User();
//            $userDetails = $objModelUser->getUserWhere($email, $password);
//            echo "<pre>";
//            print_r($userDetails);
//            die;
                if (Auth::attempt(['email' => $email, 'password' => $password])) {

                    if (Auth::user()->role == 5) {
                        Session::put('flashsaleadmin', Auth::user());
                        return redirect()->intended('/admin/dashboard');

                    } else {
                        Auth::logout();
                        return view("Admin/Layouts/adminlogin")->withErrors([
                            'errMsg' => 'Invalid credentials.',
                        ]);
                    }
                } else {
                    return view("Admin/Layouts/adminlogin")->withErrors([
                        'email' => 'Invalid credentials.',
                    ]);
                }

//            if ($userDetails['status'] !== 200) {
//                $result['message'] = $checkIfEmailExists['message'];
//                return view('Auth.login', ['result' => $result]);
//            } else {
//                if (Auth::attempt(['email' => $email, 'password' => $password])) {
//                    Session::put('email', $email);
//                    return redirect()->intended('view');
//                } else {
//                    $result['message'] = 'Password Incorrect';
//                    return view('Auth.login', ['result' => $result]);
//                }
//            }

            }
 //       }
        return view("Admin/Layouts/adminlogin");

//        die("Modular structure Admin login");
    }
}
