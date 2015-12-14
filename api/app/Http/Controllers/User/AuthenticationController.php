<?php

namespace FlashSaleApi\Http\Controllers\User;

use DB;
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
//            echo $apitoken;die("j");
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
                    $supplier = 1;
//                    $supplier = User::create([
//                        'name' => $postData['first_name'],
//                        'last_name' => $postData['last_name'],
//                        'email' => $postData['email'],
//                        'password' => Hash::make($password),
//                        'role' => '1',
//                        'status' => '1',
//                        'username' => $postData['username']
//                    ]);
//                    echo $supplier;die('a');
                    if ($supplier) {
                        $objMailTemplate = new MailTemplate();
                        $temp_name = "signup_success_mail";
                        $mailTempContent = $objMailTemplate->getTemplateByName($temp_name);

                        $key = env('MANDRILL_KEY');

                        $mandrill = new Mandrill($key);
                        $async = false;
                        $ip_pool = 'Main Pool';
//                        echo "<pre>";print_r($mailTempContent->temp_content);die();
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


                        $response->code = 200;
                        $response->message = "Signup sucessful.Check your email for Password";
                        $response->data = $mailrespons;
                        echo json_encode($response);
                    } else {
                        $response->code = 197;
                        $response->message = "some Error occured try again";
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

}