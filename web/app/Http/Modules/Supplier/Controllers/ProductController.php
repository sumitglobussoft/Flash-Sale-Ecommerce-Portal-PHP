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

    public function ajaxHandler(Request $request)
    {
        $objModelUser = User::getInstance();
        $objModelUsersmeta = Usersmeta::getInstance();

        $uesrId = Session::get('fs_supplier')['id'];

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

                if (Input::hasFile('file')) {

                    $validator = Validator::make($request->all(), ['file' => 'image']);

                    if ($validator->fails()) {
                        echo json_encode(array('status' => 2, 'message' => $validator->messages()->all()));
                    } else {
                        $destinationPath = 'assets/uploads/useravatar/';
                        $filename = $uesrId . '_' . time() . ".jpg";
                        File::makeDirectory($destinationPath, 0777, true, true);
                        $filePath = '/' . $destinationPath . $filename;
                        $quality = $this->imageQuality(Input::file('file'));

                        Image::make(Input::file('file'))->resize(1024, 1024, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath . $filename, $quality);

                        $whereForUpdate['id'] = $uesrId;
                        $updateData['profilepic'] = $filePath;
                        $updatedResult = $objModelUser->updateUserWhere($updateData, $whereForUpdate);
                        if ($updatedResult) {
                            if (!strpos(Session::get('fs_supplier')['profilepic'], 'placeholder')) {
                                File::delete(public_path() . Session::get('fs_supplier')['profilepic']);
                            }
                            Session::put('fs_supplier.profilepic', $filePath);
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
