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
use Illuminate\Support\Facades\Storage;

use FlashSale\Http\Modules\Supplier\Models\User;
use FlashSale\Http\Modules\Supplier\Models\Usersmeta;
use Illuminate\Support\Facades\Session;


class SupplierController extends Controller
{


    private $imageWidth = 1024;//TO BE USED FOR IMAGE RESIZING
    private $imageHeight = 1024;//TO BE USED FOR IMAGE RESIZING


    public function dashboard()
    {
        if (!Session::has('fs_supplier')) {
            return redirect('/supplier/login');
        }

//        echo "<pre>";
//        print_r(Session::get('fs_supplier')['id']);
//        die;
        return view("Supplier/Views/supplier/dashboard");

    }

    public function login(Request $request)
    {
        if (Session::has('fs_supplier')) {
            return redirect('/supplier/dashboard');
        }

        if ($request->isMethod('post')) {
            $remember = $request['remember'] == 'on' ? true : false;

            $emailOrUsername = $request->input('emailOrUsername');
            $password = $request->input('password');

            $this->validate($request, [
                'emailOrUsername' => 'required',
                'password' => 'required',
            ], ['emailOrUsername.required' => 'Please enter email address or username',
                    'password.required' => 'Please enter a password']
            );
            $field = 'username';
            if (strpos($emailOrUsername, '@')) {
                $field = 'email';
            }
            if (Auth::attempt([$field => $emailOrUsername, 'password' => $password], $remember)) {
                $objModelUsers = User::getInstance();
                $userDetails = $objModelUsers->getUserById(Auth::id());
                if ($userDetails->role == 3) {
                    Session::put('fs_supplier', $userDetails['original']);
                    return redirect()->intended('supplier/dashboard');
                } else {
                    return view("Supplier/Views/supplier/login")->withErrors([
                        'errMsg' => 'Invalid credentials.',
                    ]);
                }
            } else {
                return view("Supplier/Views/supplier/login")->withErrors([
                    'errMsg' => 'Invalid credentials.',
                ]);
            }
        }
        return view("Supplier/Views/supplier/login");

    }

    public function register(Request $request)
    {
        if (Session::has('fs_supplier')) {
            return redirect('/supplier/dashboard');
        }

        if ($request->isMethod('post')) {

            $rules = array(
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required',
                'password_confirm' => 'required|same:password',
                'terms_and_policy' => 'accepted'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $supplier = User::create([
                        'name' => $request['first_name'],
                        'last_name' => $request['last_name'],
                        'email' => $request['email'],
                        'password' => bcrypt($request['password']),
                        'role' => '3',
                        'username' => $request['username'],
                        'profilepic' => '/assets/images/avatar-placeholder.jpg'
                    ]);

                    if ($supplier) {
                        Auth::login($supplier);
                        $objModelUsers = User::getInstance();
                        $userDetails = $objModelUsers->getUserById(Auth::id());
                        Session::put('fs_supplier', $userDetails['original']);
                        return redirect()->intended('supplier/supplierDetails');
                    } else {
                        return view("Supplier/Views/supplier/register")->withErrors([
                            'registerErrMsg' => 'Something went wrong, please try again.',
                        ]);
                    }
                } catch (\Exception $ex) {
                    return redirect()->back()->with('exception', 'An exception occurred, please reload the page and try again.');
                }

            }
        }
        return view("Supplier/Views/supplier/register");
    }


    public function logout()
    {
        Session::forget('fs_supplier');
        return redirect('/supplier/login');
    }

    public function profile(Request $request)
    {
        $objModelUser = User::getInstance();

        $where['users.id'] = Session::get('fs_supplier')['id'];
        $uesrDetails = $objModelUser->getUserDetailsWhere($where);


//        echo '<pre>';
//        print_r($uesrDetails);
//        die;

        if ($uesrDetails) {
            return view('Supplier/Views/supplier/profile', ['uesrDetails' => $uesrDetails]);
        } else {
            return redirect()->intended('supplier/supplierDetails');
        }
    }

    public function supplierDetails(Request $request)
    {
        $objModelUser = User::getInstance();

        $where['users.id'] = Session::get('fs_supplier')['id'];
        $uesrDetails = $objModelUser->getUserDetailsWhere($where);
        if (isset($uesrDetails->user_id)) {
            return redirect()->intended('supplier/dashboard');
        }

        //NOT YET COMPLETE, NEED COUNTRY DETAILS
        if ($request->isMethod('post')) {
            $rules = array(
                'addressline1' => 'required|max:255',
                'addressline2' => 'required|max:255',
                'city' => 'required|max:255',
                'state' => 'required|max:255',
                'country' => 'required|max:255',
                'zipcode' => 'required',
                'phone' => 'required|regex:/^\+?[^a-zA-Z]{5,}$/|unique:usersmeta,phone' //Regex format: +359878XXX, +359 878 XXX, +359 87 8X XX, +(359) 878 XXX, 0878-XX-XX-XX.
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                try {
                    $supplierDetails = Usersmeta::create([
                            'user_id' => Session::get('fs_supplier')['id'],
                            'addressline1' => $request->input('addressline1'),
                            'addressline2' => $request->input('addressline2'),
                            'city' => $request->input('city'),
                            'state' => $request->input('state'),
                            'country' => $request->input('country'),//NEED COUNTRY DETAILS, FROM DATABASE
                            'zipcode' => $request->input('zipcode'),
                            'phone' => $request->input('phone')
                        ]
                    );

                    if ($supplierDetails) {
                        return redirect()->intended('supplier/dashboard');
//                        echo '<pre>';
//                        print_r($supplierDetails);
                    } else {
                        return redirect()->back()->with('error', 'Something went wrong, please try again.')->withInput();
                    }
                } catch (\Exception $ex) {
                    return redirect()->back()->with('error', 'An exception occurred, please reload the page and try again.')->withInput();
                }

            }
        }

        return view("Supplier/Views/supplier/supplierDetails");
    }

    public function ajaxHandler(Request $request)
    {
        $objModelUser = User::getInstance();
        $objModelUsersmeta = Usersmeta::getInstance();

        $userId = Session::get('fs_supplier')['id'];

        $where['user_id'] = $userId;
        $usersMetaDetails = $objModelUsersmeta->getUsersMetaDetailsWhere($where);

        $method = $request->input('method');


        switch ($method) {
            case 'checkContactNumber':
                $validator = Validator::make($request->all(), ['contact_number' => 'required|unique:usersmeta,phone,' . $usersMetaDetails->id]);
                if ($validator->fails()) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                break;


            case 'updateProfileInfo': //NOT YET COMPLETE, NEED COUNTRY DETAILS
                $rules = array(
                    'first_name' => 'required|max:255',
                    'last_name' => 'required|max:255',
                    'city' => 'required',
                    'state' => 'required',
                    'zipcode' => 'required',
                    'country' => 'required',
                    'contact_number' => 'required|unique:usersmeta,phone,' . $usersMetaDetails->id
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    echo json_encode(array('status' => 2, 'message' => $validator->messages()->all()));
                } else {
                    $whereForUpdate['id'] = $userId;
                    $updateData['name'] = $request->input('first_name');
                    $updateData['last_name'] = $request->input('last_name');

                    $updatedResult = $objModelUser->updateUserWhere($updateData, $whereForUpdate);

                    $updateMetaData['addressline1'] = $request->input('address_line_1');
                    $updateMetaData['addressline2'] = $request->input('address_line_2');
                    $updateMetaData['city'] = $request->input('city');
                    $updateMetaData['state'] = $request->input('state');
                    $updateMetaData['country'] = $request->input('country');//COUNTRY DETAILS IN DATABASE
                    $updateMetaData['zipcode'] = $request->input('zipcode');
                    $updateMetaData['phone'] = $request->input('contact_number');
                    $whereForUpdateMetaData['id'] = $usersMetaDetails->id;

                    $updatedMetaDataResult = $objModelUsersmeta->updateUsersMetaDetailsWhere($updateMetaData, $whereForUpdateMetaData);
                    if ($updatedResult || $updatedMetaDataResult) {
                        echo json_encode(array('status' => 1, 'message' => 'Successfully updated profile data.'));
                    } else {
                        echo json_encode(array('status' => 0, 'message' => 'Nothing to update.'));
                    }
                }

                break;
            case 'updateAvatar':

                if (Input::hasFile('file')) {

                    $validator = Validator::make($request->all(), ['file' => 'image']);

                    if ($validator->fails()) {
                        echo json_encode(array('status' => 2, 'message' => $validator->messages()->all()));
                    } else {
                        $destinationPath = 'uploads/useravatar/';
                        $filename = $userId . '_' . time() . ".jpg";
                        File::makeDirectory(storage_path($destinationPath), 0777, true, true);
//                        $filePath = '/' . $destinationPath . $filename;
                        $filePath = "useravatar_" . $filename;
                        $fileval = '/' . $destinationPath . $filePath;
//                         echo"<pre>";print_r($filePath);die("fch");

//                        $filtemp = 'uploads_useravatar_' . $filename;


                        $quality = $this->imageQuality(Input::file('file'));

                        Image::make(Input::file('file'))->resize($this->imageWidth, $this->imageHeight, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save(storage_path($destinationPath . $filePath), $quality);
                        $whereForUpdate['id'] = $userId;
                        $updateData['profilepic'] = $filePath;
                       // echo"<pre>";print_r($updateData);die("xcgf");


                        $updatedResult = $objModelUser->updateUserWhere($updateData, $whereForUpdate);
                        if ($updatedResult) {
                            if (!strpos(Session::get('fs_supplier')['profilepic'], 'placeholder')) {
                                File::delete(storage_path() . Session::get('fs_supplier')['profilepic']);
                            }
//                            $path = storage_path().$filePath ;
//                            echo"<pre>";print_r($path);die("fch");
                            Session::put('fs_supplier . profilepic',$filePath);

                            echo json_encode(array('status' => 1, 'message' => 'Successfully updated profile image . '));
                        } else {
                            echo json_encode(array('status' => 0, 'message' => 'Something went wrong, please reload the page and try again . '));
                        }
                    }
                } else {
                    echo json_encode(array('status' => 2, 'message' => 'Please select file first . '));
                }

                break;

            case 'updatePassword':

                Validator::extend('passwordCheck', function ($attribute, $value, $parameters) {
                    return Hash::check($value, Auth::user()->getAuthPassword());
                }, 'Your current password is incorrect . ');

                $passwordRules = array(
                    'current_password' => 'required | passwordCheck',
                    'new_password' => 'required',
                    'confirm_password' => 'required | same:new_password'
                );

                $passwordValidator = Validator::make($request->all(), $passwordRules);
                if ($passwordValidator->fails()) {
                    echo json_encode(array('status' => 2, 'message' => $passwordValidator->messages()->all()));
                } else {
                    $user = Auth::user();
                    $user->password = Hash::make($request->input('new_password'));
                    $user->save();
                    echo json_encode(array('status' => 1, 'message' => 'Your password has been successfully updated . '));
                }
                break;
            default:
                break;
        }
    }

    public function userAjaxHandler(Request $request)
    {
        $method = $request->input('method');
        switch ($method) {
            case 'checkUserName':
                $validator = Validator::make($request->all(), ['username' => 'required | unique:users,username']);
                if ($validator->fails()) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                break;

            case 'checkEmail':
                $validator = Validator::make($request->all(), ['email' => 'required | unique:users,email']);
                if ($validator->fails()) {
                    echo json_encode(false);
                } else {
                    echo json_encode(true);
                }
                break;

            default:
                break;
        }
    }

    public function getImages(Request $request)
    {
        if (Input::hasFile('file')) {
            $userId = Session::get('fs_supplier')['id'];
            $objModelUser = User::getInstance();
            $destinationPath = 'uploads / useravatar / ';
            $filename = $userId . '_' . time() . ".jpg";
            File::makeDirectory(storage_path($destinationPath), 0777, true, true);
            $filePath = ' / ' . $destinationPath . $filename;
//                        echo"<pre>";print_r($filePath);die("fch");


            $quality = $this->imageQuality(Input::file('file'));

            Image::make(Input::file('file'))->resize($this->imageWidth, $this->imageHeight, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($destinationPath . $filename), $quality);
            $whereForUpdate['id'] = $userId;
            $updateData['profilepic'] = $filePath;

            $updatedResult = $objModelUser->updateUserWhere($updateData, $whereForUpdate);
            if ($updatedResult) {
                if (!strpos(Session::get('fs_supplier')['profilepic'], 'placeholder')) {
                    File::delete(storage_path() . Session::get('fs_supplier')['profilepic']);
                }
//                            $path = storage_path().$filePath ;
//                            echo"<pre>";print_r($path);die("fch");
                Session::put('fs_supplier . profilepic', $filePath);
            }
        }
    }

    public function imageQuality($image)
    {
        $imageSize = filesize($image) / (1024 * 1024);
        if ($imageSize < 0.5) {
            return 70;
        } elseif ($imageSize > 0.5 && $imageSize < 1) {
            return 60;
        } elseif ($imageSize > 1 && $imageSize < 2) {
            return 50;
        } elseif ($imageSize > 2 && $imageSize < 5) {
            return 40;
        } elseif ($imageSize > 5) {
            return 30;
        } else {
            return 50;
        }
    }


}
