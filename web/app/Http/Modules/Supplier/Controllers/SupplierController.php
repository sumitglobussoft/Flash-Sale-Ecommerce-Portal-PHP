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

    private $allowedResolution = '2500x2500';

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

        return view("Supplier/Views/supplier/dashboard");

    }

    public function login(Request $request)
    {
        if (Session::get('fs_supplier')) {
            return redirect('/supplier/dashboard');
        }

        if ($request->isMethod('post')) {
            $remember = $request['remember'] == 'on' ? true : false;

            $email = $request->input('email');
            $password = $request->input('password');

            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required',
            ], ['email.required' => 'Please enter email address or username',
                    'password.required' => 'Please enter a password']
            );
            if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
                if (Auth::user()->role == 3) {
                    Session::put('fs_supplier', Auth::user());
                    return redirect()->intended('supplier/dashboard');
                } else {
                    Auth::logout();
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
        if (Session::get('fs_supplier')) {
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
                        'username' => $request['email'],
                        'profilepic' => '/assets/images/avatar-placeholder.jpg'
                    ]);

                    if ($supplier) {
                        Auth::login($supplier);
                        Session::put('fs_supplier', Auth::user());
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
        Session::flush();
        Auth::logout();
        return redirect('/supplier/login');
    }

    public function profile(Request $request)
    {
        $objModelUser = new User();
        $uesrId = Auth::id();

        $where['users.id'] = $uesrId;
        $uesrDetails = $objModelUser->getUserDetailsWhere($where);

//        echo '<pre>';
//        print_r($uesrDetails);
//        die;
        return view('Supplier/Views/supplier/profile', ['uesrDetails' => $uesrDetails]);
    }

    public function supplierDetails(Request $request)
    {
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
                            'user_id' => Auth::id(),
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
        $objModelUser = new User();
        $objModelUsersmeta = new Usersmeta();

        $uesrId = Auth::id();

        $where['user_id'] = $uesrId;
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
                    $whereForUpdate['id'] = $uesrId;
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
                if (Input::hasFile('image')) {
                    Validator::extend('resolution', function ($attribute, $value, $parameters) {
                        $resX = explode("x", $parameters[0])[0];
                        $resY = explode("x", $parameters[0])[1];
                        $img = Image::make($value);
                        return $img->height() <= $resY && $img->width() <= $resX;
                    }, 'File resolution too large. Allowed resolution ' . $this->allowedResolution);

                    $validator = Validator::make($request->all(), ['image' => 'resolution:' . $this->allowedResolution]);

                    if ($validator->fails()) {
                        echo json_encode(array('status' => 2, 'message' => $validator->messages()->all()));
                    } else {
                        $destinationPath = 'assets/uploads/useravatar/';
                        $filename = $uesrId . '_' . time() . ".jpg";
                        File::makeDirectory($destinationPath, 0777, true, true);
                        $filePath = '/' . $destinationPath . $filename;

                        $quality = $this->imageQuality(Input::file('image'));
                        Image::make(Input::file('image'))->save($destinationPath . $filename, $quality);

                        $whereForUpdate['id'] = $uesrId;
                        $updateData['profilepic'] = $filePath;
                        $updatedResult = $objModelUser->updateUserWhere($updateData, $whereForUpdate);
                        if ($updatedResult) {
                            File::delete(public_path() . Session::get('fs_supplier')['profilepic']);
                            Session::get('fs_supplier')['profilepic'] = $filePath;
                            echo json_encode(array('status' => 1, 'message' => 'Successfully updated profile image.'));
                        } else {
                            echo json_encode(array('status' => 0, 'message' => 'Something went wrong, please reload the page and try again.'));
                        }
                    }
                } else {
                    echo json_encode(array('status' => 2, 'message' => 'Please select file first.'));
                }

                break;

            case 'updatePassword':

                Validator::extend('passwordCheck', function ($attribute, $value, $parameters) {
                    return Hash::check($value, Auth::user()->getAuthPassword());
                }, 'Your current password is incorrect.');

                $passwordRules = array(
                    'current_password' => 'required|passwordCheck',
                    'new_password' => 'required',
                    'confirm_password' => 'required|same:new_password'
                );

                $passwordValidator = Validator::make($request->all(), $passwordRules);
                if ($passwordValidator->fails()) {
                    echo json_encode(array('status' => 2, 'message' => $passwordValidator->messages()->all()));
                } else {
                    $user = Auth::user();
                    $user->password = Hash::make($request->input('new_password'));
                    $user->save();
                    echo json_encode(array('status' => 1, 'message' => 'Your password has been successfully updated.'));
                }
                break;
            default:
                break;
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
