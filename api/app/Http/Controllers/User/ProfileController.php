<?php

namespace FlashSaleApi\Http\Controllers\User;

use DB;
use FlashSaleApi\Http\Models\Languages;
use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;
use Validator;
use Mandrill;
use FlashSaleApi\Http\Models\User;
use FlashSaleApi\Http\Models\Usersmeta;
use FlashSaleApi\Http\Models\MailTemplate;
use Illuminate\Support\Facades\Hash;
use Input;
use Image;
use Redirect;
use File;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     *  This service is use to get User profile Details
     * @param user_id , api_token
     * @return $userdetails
     */
    public function profileSettings(Request $request)
    {
        $response = new stdclass();
        $objuser = new User();
        $API_TOKEN = env('API_TOKEN');
        if ($request->isMethod("POST")) {
            $postData = $request->all();
            $userId = "";
            if (isset($postData['user_id'])) {
                $userId = $postData['user_id'];
            }
            $apitoken = 0;
            $authFlag = false;
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];
                if ($apitoken == $API_TOKEN) {
                    $authFlag = true;
                } else {
                    if ($userId != '') {
                        $where = [
                            'rawQuery' => 'id =?',
                            'bindParams' => [$userId]
                        ];
                        $Userscredentials = $objuser->getUsercredsWhere($where);
                        if ($apitoken == $Userscredentials->login_token) {
                            $authFlag = true;
                        }
                    }
                }
            }
            if ($authFlag) {
                if ($userId != '') {
                    $where = [
                        'rawQuery' => 'users.id =?',
                        'bindParams' => [$userId]
                    ];
                    $userdetails = $objuser->getUsercreds($where);
                    if ($userdetails) {
                        $response->code = 200;
                        $response->message = "Success";
                        $response->data = $userdetails;
                    } else {
                        $response->code = 400;
                        $response->message = "No user Details found.";
                        $response->data = null;
                    }
                } else {
                    $response->code = 400;
                    $response->message = "You need to login to view profile setting.";
                    $response->data = null;
                }
            } else {
                $response->code = 401;
                $response->message = "Access Denied";
                $response->data = null;
            }
        } else {
            $response->code = 401;
            $response->message = "Invalid request";
            $response->data = null;
        }
        echo json_encode($response, true);
        die;
    }


    public function languageTranslate(Request $request){
        $response = new stdclass();
        $objLanguage = new Languages();
        $objuser = new User();
        $API_TOKEN = env('API_TOKEN');

        if ($request->isMethod("POST")) {
            $postData = $request->all();
            $userId = "";
//            $apitoken = 0;
//            $authFlag = false;
            if (isset($postData['user_id'])) {
                $userId = $postData['user_id'];
            }
//            $apitoken = "";
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];

            }

            if ($apitoken == $API_TOKEN) {
//            if ($apitoken == $API_TOKEN) {

//            if (isset($postData['api_token'])) {
//                $apitoken = $postData['api_token'];
//                if ($apitoken == $API_TOKEN) {
//                    $authFlag = true;
//                } else {
//                    if ($userId != '') {
//                        $where = [
//                            'rawQuery' => 'id =?',
//                            'bindParams' => [$userId]
//                        ];
//                        $Userscredentials = $objuser->getUsercredsWhere($where);
//                        if ($apitoken == $Userscredentials->login_token) {
//                            $authFlag = true;
//                        }
//                    }
//                }
//            }
//            if ($apitoken == $API_TOKEN) {
//                    $where = [
//                        'rawQuery' => 'users.id =?',
//                        'bindParams' => [$userId]
//                    ];
//                    $userdetails = $objuser->getUsercreds($where);
                    $ObjLanguageModel = Languages::getInstance();
                    $selectColumn = ['languages.lang_code','languages.name'];
                    $langInfo = $ObjLanguageModel->getAllLanguages($selectColumn);

                    if ($langInfo) {
                        $response->code = 200;
                        $response->message = "Success";
                        $response->data = $langInfo;
                    } else {
                        $response->code = 400;
                        $response->message = "No user Details found.";
                        $response->data = null;
                    }
//                } else {
//                    $response->code = 400;
//                    $response->message = "You need to login to view profile setting.";
//                    $response->data = null;
//                }
            } else {
                $response->code = 401;
                $response->message = "Access Denied";
                $response->data = null;
            }
        } else {
            $response->code = 401;
            $response->message = "Invalid request";
            $response->data = null;
        }
        echo json_encode($response, true);
        die;

    }

    /**
     *  This service is use to handle profile it has 4 methods changegeneralinfo, changeshippinginfo, changepassword and changeavtar
     * @param changegeneralinfo : method, user_id, firstname, lastname, contact_no, api_token, secondary_email
     * @return $updategeneralinfo
     * @param changeshippinginfo : method, user_id,  mytoken, city, state, zipcode, api_token, address_line_1, address_line_2
     * @return $updateshippinginfo
     * @param changepassword : method, user_id, oldPassword, newPassword, reNewPassword, api_token
     * @return $Updatepassword
     * @param changeavtar : method, user_id, api_token, input_file_preview
     * @return $url
     */
    public function profileAjaxHandler(Request $request)
    {

        $response = new stdClass();
        if ($request->isMethod("POST")) {
            $postData = $request->all();
            $API_TOKEN = env('API_TOKEN');
            $method = "";
            if (isset($postData['method'])) {
                $method = $postData['method'];
            }
            $objuser = new User();
            $objusermetamodel = new Usersmeta();
            switch ($method) {
                case "changegeneralinfo":

                    $userId = "";
                    if (isset($postData['user_id'])) {
                        $userId = $postData['user_id'];
                    }
                    $firstname = "";
                    if (isset($postData['firstname'])) {
                        $firstname = $postData['firstname'];
                    }
                    $lastname = "";
                    if (isset($postData['lastname'])) {
                        $lastname = $postData['lastname'];
                    }
                    $contact_no = "";
                    if (isset($postData['contact_no'])) {
                        $contact_no = $postData['contact_no'];
                    }
                    $email = "";
                    if (isset($postData['email'])) {
                        $email = $postData['email'];
                    }
                    $username = "";
                    if (isset($postData['username'])) {
                        $username = $postData['username'];
                    }
                    $authFlag = false;
                    if (isset($postData['api_token'])) {
                        $apitoken = $postData['api_token'];
                        if ($apitoken == $API_TOKEN) {
                            $authFlag = true;
                        } else {
                            if ($userId != '') {
                                $whereForUpdate = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$userId]
                                ];
                                $Userscredentials = $objuser->getUsercredsWhere($whereForUpdate);
                                if ($apitoken == $Userscredentials->login_token) {
                                    $authFlag = true;
                                }
                            }
                        }
                    }
                    if ($authFlag) {
                        $rules = array(
                            'firstname' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                            'lastname' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                            'username' => 'required|regex:/^[A-Za-z0-9._\s]+$/|max:255',
                            'email' => 'required|email|max:255',
                            'user_id' => 'required'
                        );
                        $messages = [
                            'firstname.regex' => 'The :attribute cannot contain special characters.',
                            'lastname.regex' => 'The :attribute cannot contain special characters.',
                            'username.regex' => 'The :attribute cannot contain special characters.',
                        ];
                        $validator = Validator::make($request->all(), $rules, $messages);

                        if ($validator->fails()) {
                            $response->code = 100;
                            $response->message = $validator->messages();
                            $response->data = null;
                            echo json_encode($response, true);
                        } else {
                            $whereForUpdate = [
                                'rawQuery' => 'id =?',
                                'bindParams' => [$userId]
                            ];
                            $currentUserDetails = $objuser->getUsercredsWhere($whereForUpdate);
                            $uniqueflag = false;
                            if ($currentUserDetails->username == $username && $currentUserDetails->username == $email) {
                                $uniqueflag = true;
                            } else if ($currentUserDetails->username != $username && $currentUserDetails->username == $email) {
                                $uniqueflag = true;
                            } else if ($currentUserDetails->username == $username && $currentUserDetails->username != $email) {
                                $uniqueflag = true;
                            } else {
                                $rules = array(
                                    'username' => 'unique:users',
                                    'email' => 'unique:users'
                                );
                                $validator = Validator::make($request->all(), $rules);
                                if ($validator->fails()) {
                                    $response->code = 100;
                                    $response->message = $validator->messages();
                                    $response->data = null;
                                    echo json_encode($response, true);
                                } else {
                                    $uniqueflag = true;
                                }
                            }
                            if ($uniqueflag) {
                                $whereForId = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$userId]
                                ];
                                $data = array('name' => $firstname, 'last_name' => $lastname, 'username' => $username, 'email' => $email);
                                $updategeneralinfo = $objuser->UpdateUserDetailsbyId($whereForId, $data);
                                $whereForUserId = [
                                    'rawQuery' => 'user_id =?',
                                    'bindParams' => [$userId]
                                ];
                                $Isuseravailable = $objusermetamodel->getUsermetaWhere($whereForUserId);
                                if ($Isuseravailable) {
                                    $dataupdate = array('phone' => "$contact_no");
                                    $UpdateUsermeta = $objusermetamodel->UpdateUsermetawhere($whereForUserId, $dataupdate);
                                } else {
                                    $dataadd = array('user_id' => $userId, 'phone' => $contact_no);
                                    $Addusermeta = $objusermetamodel->addUsermeta($dataadd);
                                }
                                if ($updategeneralinfo) {
                                    $response->code = 200;
                                    $response->message = "Update Successful";
                                    $response->data = $updategeneralinfo;
                                    echo json_encode($response, true);
                                } else {
                                    $response->code = 400;
                                    $response->message = "Something went wrong";
                                    $response->data = 1;
                                    echo json_encode($response, true);
                                }
                            }
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Access Denied";
                        $response->data = null;
                        echo json_encode($response, true);
                    }

                    break;
                case "changeshippinginfo":

                    $userId = "";
                    if (isset($postData['user_id'])) {
                        $userId = $postData['user_id'];
                    }
                    $City = "";
                    if (isset($postData['city'])) {
                        $City = $postData['city'];
                    }
                    $State = "";
                    if (isset($postData['state'])) {
                        $State = $postData['state'];
                    }
                    $Zip_code = "";
                    if (isset($postData['zipcode'])) {
                        $Zip_code = $postData['zipcode'];
                    }
//                    $country = "";
//                    if (isset($postData['country'])) {
//                        $country = $postData['country'];
//                    }
                    $Address1 = "";
                    if (isset($postData['address_line_1'])) {
                        $Address1 = $postData['address_line_1'];
                    }
                    $Address2 = "";
                    if (isset($postData['address_line_2'])) {
                        $Address2 = $postData['address_line_2'];
                    }
                    $authFlag = false;
                    if (isset($postData['api_token'])) {
                        $apitoken = $postData['api_token'];
                        if ($apitoken == $API_TOKEN) {
                            $authFlag = true;
                        } else {
                            if ($userId != '') {
                                $whereForUpdate = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$userId]
                                ];
                                $Userscredentials = $objuser->getUsercredsWhere($whereForUpdate);
                                if ($apitoken == $Userscredentials->login_token) {
                                    $authFlag = true;
                                }
                            }
                        }
                    }
                    if ($authFlag) {
                        $rules = array(
                            'city' => 'required',
                            'state' => 'required',
                            'zipcode' => 'required',
                            'address_line_1' => 'required'
                        );
                        $validator = Validator::make($request->all(), $rules);

                        if ($validator->fails()) {
                            $response->code = 100;
                            $response->message = $validator->messages();
                            $response->data = null;
                            echo json_encode($response);
                        } else {
                            $whereForUserId = [
                                'rawQuery' => 'user_id =?',
                                'bindParams' => [$userId]
                            ];
                            $Isuseravailable = $objusermetamodel->getUsermetaWhere($whereForUserId);
                            if ($Isuseravailable) {
                                $data = array('city' => $City, 'state' => $State, 'zipcode' => $Zip_code, 'addressline1' => $Address1, 'addressline2' => $Address2);
                                $updateshippinginfo = $objusermetamodel->UpdateUsermetawhere($whereForUserId, $data);
                            } else {
                                $dataadd = array('user_id' => $userId, 'city' => $City, 'state' => $State, 'zipcode' => $Zip_code, 'addressline1' => $Address1, 'addressline2' => $Address2);
                                $Addusermeta = $objusermetamodel->addUsermeta($dataadd);
                            }
                            if ($updateshippinginfo || $Addusermeta) {
                                $response->code = 200;
                                $response->message = "Update Successful";
                                $response->data = 1;
                                echo json_encode($response, true);
                            } else {
                                $response->code = 400;
                                $response->message = "Something went Wrong";
                                $response->data = null;
                                echo json_encode($response, true);
                            }
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Access Denied";
                        $response->data = null;
                        echo json_encode($response, true);
                    }

                    break;
                case "changepassword":
                    $userId = "";
                    if (isset($postData['user_id'])) {
                        $userId = $postData['user_id'];
                    }
                    $oldpassword = "";
                    if (isset($postData['oldPassword'])) {
                        $oldpassword = $postData['oldPassword'];
                    }
                    $newpassword = "";
                    if (isset($postData['newPassword'])) {
                        $newpassword = $postData['newPassword'];
                    }
                    $renewpassword = "";
                    if (isset($postData['reNewPassword'])) {
                        $renewpassword = $postData['reNewPassword'];
                    }
                    $authFlag = false;
                    if (isset($postData['api_token'])) {
                        $apitoken = $postData['api_token'];
                        if ($apitoken == $API_TOKEN) {
                            $authFlag = true;
                        } else {
                            if ($userId != '') {
                                $whereForUpdate = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$userId]
                                ];
                                $Userscredentials = $objuser->getUsercredsWhere($whereForUpdate);
                                if ($apitoken == $Userscredentials->login_token) {
                                    $authFlag = true;
                                }
                            }
                        }
                    }
                    if ($authFlag) {
                        $rules = array(
                            'oldPassword' => 'required',
                            'newPassword' => 'required',
                            'reNewPassword' => 'required',
                            'user_id' => 'required'
                        );
                        $validator = Validator::make($request->all(), $rules);

                        if ($validator->fails()) {
                            $response->code = 100;
                            $response->message = $validator->messages();
                            $response->data = null;
                            echo json_encode($response);
                        } else {

                            if ($newpassword != $oldpassword) {
                                if ($newpassword == $renewpassword) {
                                    $where = [
                                        'rawQuery' => 'id =?',
                                        'bindParams' => [$userId]
                                    ];
                                    $currentUserDetails = $objuser->getUsercredsWhere($where);
                                    if (Hash::check($oldpassword, $currentUserDetails->password)) {
                                        $newpassword = Hash::make($newpassword);
                                        $data = array('password' => $newpassword);
                                        $Updatepassword = $objuser->UpdateUserDetailsbyId($where, $data);
                                        $response->code = 200;
                                        $response->message = "Password Changed Successfully";
                                        $response->data = 1;
                                        echo json_encode($response, true);
                                    } else {
                                        $response->code = 400;
                                        $response->message = "Invalid Password";
                                        $response->data = null;
                                        echo json_encode($response, true);
                                    }
                                } else {
                                    $response->code = 400;
                                    $response->message = "Both New password should be same";
                                    $response->data = null;
                                    echo json_encode($response, true);
                                }
                            } else {
                                $response->code = 400;
                                $response->message = "New and old password should not be same";
                                $response->data = null;
                                echo json_encode($response, true);
                            }

                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Access Denied";
                        $response->data = null;
                        echo json_encode($response, true);
                    }
                    break;
                case "changeavtar"://This method is directly called from Ajax call of profile-setting.blade.php page

                    $userId = "";
                    if (isset($postData['user_id'])) {
                        $userId = $postData['user_id'];
                    }
                    $authFlag = false;
                    if (isset($postData['api_token'])) {
                        $apitoken = $postData['api_token'];
                        if ($apitoken == $API_TOKEN) {
                            $authFlag = true;
                        } else {
                            if ($userId != '') {
                                $whereForUpdate = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$userId]
                                ];
                                $Userscredentials = $objuser->getUsercredsWhere($whereForUpdate);
                                if ($apitoken == $Userscredentials->login_token) {
                                    $authFlag = true;
                                }
                            }
                        }
                    }

                    if ($authFlag) {
                        if ($userId != '') {
                            if (Input::hasFile('file')) {
                                $validator = Validator::make($request->all(), ['file' => 'image']);
                                if ($validator->fails()) {
                                    $response->code = 100;
                                    $response->message = $validator->messages();
                                    $response->data = null;
                                    echo json_encode($response);
                                } else {
                                    $filePath = uploadImageToStoragePath(Input::file('file'), 'profileavatar', 'profileavatar_' . $userId . '_' . time() . ".jpg");
                                    if ($filePath) {
                                        $updateData['profilepic'] = $filePath;
                                        $where = [
                                            'rawQuery' => 'id =?',
                                            'bindParams' => [$userId]
                                        ];
                                        $UserData = $objuser->getUsercredsWhere($where);
                                        $updatedResult = $objuser->UpdateUserDetailsbyId($where, $updateData);
                                        if ($updatedResult) {
                                            if ($UserData->profilepic != '') {
                                                if (!strpos($UserData->profilepic, 'placeholder')) {
                                                    deleteImageFromStoragePath($UserData->profilepic);
                                                }
                                            }
//
                                            $response->code = 200;
                                            $response->message = "Successfully updated profile image.";
                                            $response->data = $filePath;
                                            echo json_encode($response);
                                        } else {
                                            $response->code = 400;
                                            $response->message = "Something went wrong, please try again.";
                                            $response->data = null;
                                            echo json_encode($response);
                                        }
                                    } else {
                                        $response->code = 400;
                                        $response->message = "Something went wrong, please reload the page and try again..";
                                        $response->data = null;
                                        echo json_encode($response);
                                    }
                                }
                            } else {
                                $response->code = 400;
                                $response->message = "Give correct input and Input Image files should be(jpg,gif,png,jpeg)only";
                                $response->data = null;
                                echo json_encode($response, true);
                            }
                        } else {
                            $response->code = 400;
                            $response->message = "You need to login to change Avtar.";
                            $response->data = null;
                            echo json_encode($response, true);
                        }
                    } else {
                        $response->code = 401;
                        $response->message = "Access Denied";
                        $response->data = null;
                        echo json_encode($response, true);
                    }
                    break;
                default:
                    break;
            }
        } else {
            $response->code = 401;
            $response->message = "Invalid request";
            $response->data = null;
            echo json_encode($response, true);
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