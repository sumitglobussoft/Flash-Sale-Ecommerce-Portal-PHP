<?php

namespace FlashSale\Http\Controllers\Auth;

use Illuminate\Http\Request;
//use FlashSale\Http\Requests\Request;
use FlashSale\Http\Models\User;
use Validator;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $redirectPath = '/admin/dashboard';
    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }



    /**
     * Create a new user instance after a valid registration.
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function login(Request $data)
    {
        if ($data->isMethod('post')) {
            $email = $data->input('email');
            $password = $data->input('password');
            $result['message'] = NULL;
            if ($email) {
                $obj = new User();
                $checkIfEmailExists = $obj->getUserWhere($email, $password);
                if ($checkIfEmailExists['status'] !== 200) {
                    $result['message'] = $checkIfEmailExists['message'];
                    return view('Auth.login', ['result' => $result]);
                } else {
                    if (Auth::attempt(['email' => $email, 'password' => $password])) {
                        Session::put('email', $email);
                        return redirect()->intended('view');
                    } else {
                        $result['message'] = 'Password Incorrect';
                        return view('Auth.login', ['result' => $result]);
                    }
                }
            } else {
                return view('auth.login', ['result' => $result]);
            }
        }
    }
}
