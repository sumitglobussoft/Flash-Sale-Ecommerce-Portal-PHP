<?php

namespace FlashSaleApi\Http\Controllers\User;

use DB;
use FlashSaleApi\Http\Models\Usersmeta;
use Illuminate\Http\Request;
use FlashSaleApi\Http\Requests;
use FlashSaleApi\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use stdClass;
use Validator;
use Mandrill;
use FlashSaleApi\Http\Models\User;
use FlashSaleApi\Http\Models\MailTemplate;
use Illuminate\Support\Facades\Hash;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";

class AuthenticationController extends Controller
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
     * @param api_token , first_name, last_name, username, email
     */
    public function signup(Request $request)
    {
        $response = new stdClass();
        if ($request->isMethod("POST")) {
            $API_TOKEN = env('API_TOKEN');
            $postData = $request->all();
            $apitoken = "";
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];
            }
            if ($apitoken == $API_TOKEN) {
                $rules = array(
                    'first_name' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                    'last_name' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                    'username' => 'required|regex:/^[A-Za-z0-9._\s]+$/|max:255|unique:users',
                    'email' => 'required|email|max:255|unique:users'
                );
                $messages = [
                    'first_name.regex' => 'The :attribute cannot contain special characters.',
                    'last_name.regex' => 'The :attribute cannot contain special characters.',
                    'username.regex' => 'The :attribute cannot contain special characters.',
                ];
                $validator = Validator::make($request->all(), $rules, $messages);

                if ($validator->fails()) {
                    $response->code = 100;
                    $response->message = $validator->messages();
                    echo json_encode($response);
                } else {

                    $password = "";
                    $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
                    $max = count($characters) - 1;
                    for ($i = 0; $i < 8; $i++) {
                        $rand = mt_rand(0, $max);
                        $password .= $characters[$rand];
                    }
                    $supplier = User::create([
                        'name' => $postData['first_name'],
                        'last_name' => $postData['last_name'],
                        'email' => $postData['email'],
                        'password' => Hash::make($password),
                        'role' => '1',
                        'status' => '1',
                        'username' => $postData['username']
                    ]);
                    $objUsersMetaModel = new Usersmeta();
                    if ($postData['optradio'] != '' && $postData['contact_no'] != '' && $postData['date_of_birth'] != '') {
                        $whereForUpdate = [
                            'rawQuery' => 'gender = ? and phone = ? and date_of_birth = ?',
                            'bindParams' => [$postData['optradio'], $postData['contact_no'],$postData['date_of_birth']]
                        ];
                        $exists = $objUsersMetaModel->UpdateUsermetawhere($whereForUpdate);
                    }
                    if ($supplier) {

                        $objMailTemplate = new MailTemplate();
                        $temp_name = "signup_success_mail";
                        $mailTempContent = $objMailTemplate->getTemplateByName($temp_name);
                        $key = env('MANDRILL_KEY');
                        $mandrill = new Mandrill($key);
                        $async = false;
                        $ip_pool = 'Main Pool';
                        $message = array(
                            'html' => $mailTempContent->temp_content,
                            'subject' => "Registration Successful",
                            'from_email' => "support@flashsale.com",
                            'to' => array(
                                array(
                                    'email' => $postData['email'],
                                    'type' => 'to'
                                )
                            ),
                            'merge_vars' => array(
                                array(
                                    "rcpt" => $postData['email'],
                                    'vars' => array(
                                        array(
                                            "name" => "firstname",
                                            "content" => $postData['first_name']
                                        ),
                                        array(
                                            "name" => "password",
                                            "content" => $password
                                        )
                                    )
                                )
                            ),
                        );

                        $mailrespons = $mandrill->messages->send($message, $async, $ip_pool);

                        if ($mailrespons[0]['status'] == "sent") {
                            $response->code = 200;
                            $response->message = "Signup successful. Please check your email for Password";
                            $response->data = null;
                            echo json_encode($response);
                        } else {
                            $objuser = new User();
                            $whereForUpdate = [
                                'rawQuery' => 'id =?',
                                'bindParams' => [$supplier->id]
                            ];
                            $deleteUser = $objuser->deleteUserDetails($whereForUpdate);//If mail sending fails then delete user details
                            $response->code = 400;
                            $response->message = "some Error occured try again";
                            echo json_encode($response);
                        }
                    } else {
                        $response->code = 400;
                        $response->message = "some Error occured try again";
                        @$response->data = null;
                        echo json_encode($response);
                    }
                }
            } else {
                $response->code = 401;
                $response->message = "Request Not allowed";
                $response->data = null;
                echo json_encode($response);
            }
        }
    }

    /**
     * @param api_token , username, password, device_id
     */
    public function login(Request $request)
    {
        $response = new stdClass();
        if ($request->isMethod("POST")) {
            $API_TOKEN = env('API_TOKEN');
            $postData = $request->all();
            $apitoken = "";
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];
            }
            if ($apitoken == $API_TOKEN) {
                $rules = array(
                    'username' => 'required',
                    'password' => 'required'
                );
                $validator = Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $response->code = 100;
                    $response->message = $validator->messages();
                    echo json_encode($response);
                } else {
                    $objuser = new User();
                    $username = $postData['username'];
                    $password = $postData['password'];
                    $field = 'username';
                    if (strpos($username, '@') !== false) {
                        $field = 'email';
                    }
                    if (Auth::attempt([$field => $username, 'password' => $password])) {
                        $whereForUpdate = [
                            'rawQuery' => 'id =?',
                            'bindParams' => [Auth::id()]
                        ];
                        $userDetails = $objuser->getUsercredsWhere($whereForUpdate);
                        if ($userDetails->status == 1) { //ROLE IS NOT CHECKED HERE IF NEEDED ROLE CHECK IS NECESSARY
                            if (isset($postData['device_id']) && $postData['device_id'] != "") {
                                $data['device_id'] = $postData['device_id'];
                                $string = $userDetails->id . $postData['device_id'] . $API_TOKEN;
                                $token = hash('sha256', $string);
                                $data['login_token'] = $token;
                                $id = $userDetails->id;
                                $whereForUpdate = [
                                    'rawQuery' => 'id =?',
                                    'bindParams' => [$id]
                                ];
                                $objuser->UpdateUserDetailsbyId($whereForUpdate, $data);
                                $userDetails->login_token = $token;
                                $userDetails->device_id = $postData['device_id'];
                            }
                            $response->code = 200;
                            $response->message = "Login successful.";
                            $response->data = $userDetails;
                            echo json_encode($response);
                        } else if ($userDetails->status == 2) {
                            @$response->message = 'This account has been restricted from logging in.';
                            @$response->code = 400;
                            @$response->data = null;
                            echo json_encode($response);
                        } else if ($userDetails->status == 4) {
                            @$response->message = 'This account has been deleted.';
                            @$response->code = 400;
                            @$response->data = null;
                            echo json_encode($response);
                        }
                    } else {
                        $response->code = 400;
                        $response->message = "Invalid login Credentials";
                        @$response->data = null;
                        echo json_encode($response);
                    }
                }
            } else {
                $response->code = 401;
                $response->message = "Request Not allowed";
                $response->data = null;
                echo json_encode($response);
            }
        }
    }

    /**
     *  This service is use for Forgot Password has 3 methods EnterEmailId, verifyResetCode and resetPassword
     * @param api_token, fpwemail, resetcode, method, password, re_password
     * @return int
     */
    public function forgotPassword(Request $request) {
        $response = new stdClass();
        if ($request->isMethod("POST")) {
            $postData = $request->all();
            $API_TOKEN = env('API_TOKEN');
            $apitoken = "";
            if (isset($postData['api_token'])) {
                $apitoken = $postData['api_token'];
            }
            $method = "";
            if (isset($postData['method'])) {
                $method = $postData['method'];
            }
            $objUsersModel = new User();
            switch ($method) {
                case "EnterEmailId":
                    if ($request->isMethod("POST")) {
                        $fpwemail = '';
                        if (isset($postData['fpwemail'])) {
                            $fpwemail = $postData['fpwemail'];
                        }

                        if ($apitoken == $API_TOKEN) {
                            if ($fpwemail != '') {
                                $resetcode = mt_rand(100000, 999999);
                                $exists = $objUsersModel->checkMail($fpwemail, $resetcode);
                                if ($exists) {
                                    $objMailTemplate = new MailTemplate();
                                    $temp_name = "Enter_mail_fp";
                                    $mailTempContent = $objMailTemplate->getTemplateByName($temp_name);
                                    $key = env('MANDRILL_KEY');
                                    $mandrill = new Mandrill($key);
                                    $async = false;
                                    $ip_pool = 'Main Pool';
                                    $message = array(
                                        'html' => $mailTempContent->temp_content,
                                        'subject' => "Reset Code",
                                        'from_email' => "support@flashsale.com",
                                        'to' => array(
                                            array(
                                                'email' => $postData['fpwemail'],
                                                'type' => 'to'
                                            )
                                        ),
                                        'merge_vars' => array(
                                            array(
                                                "rcpt" => $postData['fpwemail'],
                                                'vars' => array(
                                                    array(
                                                        "name" => "usermail",
                                                        "content" => $postData['fpwemail']
                                                    ),
                                                    array(
                                                        'name' => 'resetcode',
                                                        'content' => $resetcode
                                                    )
                                                )
                                            )
                                        ),
                                    );

                                    $mailrespons = $mandrill->messages->send($message, $async, $ip_pool);
                                    if ($mailrespons[0]['status'] == "sent") {
                                        $response->code = 200;
                                        $response->message = "Mail Sent with Reset code";
                                        $response->data = 1;
                                    }
                                } else {
                                    $response->code = 400;
                                    $response->message = "Email Doesnt Exist. Enter correct Email.";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 400;
                                $response->message = "You missed something";
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
                    break;
                case "verifyResetCode":
                    if ($request->isMethod("POST")) {
                        $fpwemail = '';
                        if (isset($postData['fpwemail'])) {
                            $fpwemail = $postData['fpwemail'];
                        }
                        $resetcode = '';
                        if (isset($postData['resetcode'])) {
                            $resetcode = $postData['resetcode'];
                        }
                        if ($apitoken == $API_TOKEN) {
                            if ($fpwemail != '' && $resetcode != '') {
                                $whereForUpdate = [
                                    'rawQuery' => 'email = ? and reset_code = ?',
                                    'bindParams' => [$fpwemail, $resetcode]
                                ];
                                $exists = $objUsersModel->verifyResetCode($whereForUpdate);
                                if ($exists) {
                                    $response->code = 200;
                                    $response->message = "Reset Code Verified Successfully.";
                                    $response->data = $exists;
                                } else {
                                    $response->code = 400;
                                    $response->message = "Reset Code Didnt Matched, Enter Correct Reset Code.";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 400;
                                $response->message = "You missed something";
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
                    break;
                case "resetPassword":
                    if ($request->isMethod("POST")) {
                        $fpwemail = '';
                        if (isset($postData['fpwemail'])) {
                            $fpwemail = $postData['fpwemail'];
                        }
                        $resetcode = '';
                        if (isset($postData['resetcode'])) {
                            $resetcode = $postData['resetcode'];
                        }
                        $password = '';
                        if (isset($postData['password'])) {
                            $password = $postData['password'];
                        }
                        $re_password = '';
                        if (isset($postData['re_password'])) {
                            $re_password = $postData['re_password'];
                        }
                        if ($apitoken == $API_TOKEN) {
                            if ($fpwemail != '' && $resetcode != '' && $password != '' && $re_password != '') {
                                if ($password == $re_password) {
                                    $exists = $objUsersModel->resetPassword($fpwemail, $resetcode, Hash::make($password));
                                    if ($exists) {
                                        $response->code = 200;
                                        $response->message = "Password Changed Successfully.";
                                        $response->data = $exists;
                                    } else {
                                        $response->code = 400;
                                        $response->message = "Something went Wrong. Provide Correct Input.";
                                        $response->data = null;
                                    }
                                } else {
                                    $response->code = 400;
                                    $response->message = "Password Didnt match";
                                    $response->data = null;
                                }
                            } else {
                                $response->code = 400;
                                $response->message = "You missed something";
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
                    break;
                default:
                    break;
            }
        }
    }

}