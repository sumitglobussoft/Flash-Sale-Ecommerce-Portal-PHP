<?php
namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use PDO;
use Input;
use Datatables;
use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use stdClass;
use Mandrill;
use Illuminate\Support\Facades\Hash;
use FlashSale\Http\Modules\Admin\Models\MailTemplate;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";


class CustomerController extends Controller
{


    public function availableCustomer(Request $request)
    {

//        $objuser = User::getInstance();
//        $available_customers = $objuser->getAvailableUserDetails();
//        echo "<pre>"; print_r($available_customers);die;
        return view("Admin/Views/customer/availableCustomer");
    }

    public function customerAjaxHandler(Request $request)
    {
        $inputData = $request->input();
        $method = $request->input('method');
        $ObjUser = User::getInstance();
        if ($method) {
            switch ($method) {
                case "availableCustomer":
                    $objuser = User::getInstance();
                    $available_customers = $objuser->getAvailableUserDetails();
                    foreach ($available_customers as $key => $val) {
                        $available[$key] = $val->status;
                    }
                    if ($available == 1) {
                        //  echo"<pre>";print_r("bhk");die("kgkj");
                        $avail = 'Active';
                    } elseif ($available == 2) {
                        $inactavail = 'Inactive';
                    }
                    // echo"<pre>";print_r($available);die("kgkj");
                    return Datatables::of($available_customers)
                        ->addColumn('action', function ($available_customers) {
                            return '<span class="tooltips" title="Edit User Details." data-placement="top"> <a href="/admin/edit-customer/' . $available_customers->id . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </span> &nbsp;&nbsp;
                                            <span class="tooltips" title="Delete User Details." data-placement="top"> <a href="#" data-cid="' . $available_customers->id . '" class="btn btn-danger delete-user" style="margin-left: 10%;">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </span>';
                        })
                        ->addColumn('status', function ($available_customers) {

                            $button = '<td style="text-align: center">';
                            $button .= '<button class="btn ' . (($available_customers->status == 1) ? "btn-success" : "btn-danger") . ' customer-status" data-id="' . $available_customers->id . '">' . (($available_customers->status == 1) ? "Active" : "Inactve") . ' </button>';
                            $button .= '</td>';
                            return $button;
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();
                    break;
                case 'changeCustomerStatus':
                    $userId = $inputData['UserId'];
                    $whereForUpdate = ['rawQuery' => 'id =?', 'bindParams' => [$userId]];
                    $dataToUpdate['status'] = $inputData['status'];
                    $updateResult = $ObjUser->updateUserWhere($dataToUpdate, $whereForUpdate);

                    if ($updateResult == 1) {
                        echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                    }
                    break;
                case 'deleteUserStatus':
                    $userId = $inputData['UserId'];
                    $where = ['rawQuery' => 'id = ?', 'bindParams' => [$userId]];
                    $deleteStatus = $ObjUser->deleteUserDetails($where);
                    if ($deleteStatus) {
                        echo json_encode(['status' => 'success', 'msg' => 'User Deleted']);

                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);

                    }
                    break;
                case 'pendingCustomer':
                    $objuser = User::getInstance();
                    $where = array('rawQuery' => 'role = ? and status = ?', 'bindParams' => [1, 0]);
//                    $status = array('rawQuery' => 'status = ?', 'bindParams' => [0]);
                    $pending_customers = $objuser->getPendingUserDetails($where);

                    return Datatables::of($pending_customers)
                        ->addColumn('status', function ($pending_customers) {
                            return '<td style="text-align: center">
                                            <button class="btn btn-primary customer-status"
                                                    data-id=' . $pending_customers->id . '>Pending
                                            </button>

                                    </td>';
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();
                    break;

                case 'deletedCustomer':
                    $objuser = User::getInstance();
                    $where = array('rawQuery' => 'role = ?', 'bindParams' => [1]);
                    $status = array('rawQuery' => 'status = ?', 'bindParams' => [4]);
                    $deleted_customers = $objuser->getDeletedUserDetails($where, $status);

                    return Datatables::of($deleted_customers)
                        ->addColumn('status', function ($deleted_customers) {
                            return '<td style="text-align: center">
                                            <button class="btn btn-primary customer-status"
                                                    data-id=' . $deleted_customers->id . '>Deleted
                                            </button>

                                    </td>';
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();
                    break;
                default :
                    break;
            }
        }
    }


    public function addNewCustomer(Request $request)
    {

        $response = new stdClass();
        if ($request->isMethod("POST")) {

            $postData = $request->all();


            $rules = array(
                'firstname' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                'lastname' => 'required|regex:/^[A-Za-z\s]+$/|max:255',
                'username' => 'required|regex:/^[A-Za-z0-9._\s]+$/|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users'
            );
            $messages = [
                'firstname.regex' => 'The :attribute cannot contain special characters.',
                'lastname.regex' => 'The :attribute cannot contain special characters.',
                'username.regex' => 'The :attribute cannot contain special characters.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect('/admin/add-new-customer')
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $password = "";
                $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
                $max = count($characters) - 1;
                for ($i = 0; $i < 8; $i++) {
                    $rand = mt_rand(0, $max);
                    $password .= $characters[$rand];
                }
                $supplier = User::create([
                    'name' => $postData['firstname'],
                    'last_name' => $postData['lastname'],
                    'email' => $postData['email'],
                    'password' => Hash::make($password),
                    'role' => '1',
                    'status' => '1',
                    'username' => $postData['username']
                ]);


                if ($supplier) {

                    $objMailTemplate = MailTemplate::getInstance();
                    $temp_name = "signup_success_mail";
                    //  $where = ['rawQuery' => 'temp_name = ?', 'bindParam' => $temp_name];

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
                                        "content" => $postData['firstname']
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
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Mail sent successfully to  ' . $postData['firstname']]);

                    } else {
                        $objuser = new User();
                        $whereForUpdate = [
                            'rawQuery' => 'id =?',
                            'bindParams' => [$supplier->id]
                        ];
                        $deleteUser = $objuser->deleteUserDetails($whereForUpdate);
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Failed To Send Mail.']);

                    }
                }
            }
        }
        return view('Admin/Views/customer/addNewCustomer');
    }

    public function editCustomer(Request $request, $uid)
    {
        $postdata = $request->all();

        $ObjUser = User::getInstance();
        if ($request->isMethod("GET")) {
            // $where = ['rawQuery' => 'id = ?', 'bindParams' => $uid];
            $customerDetails = $ObjUser->getUserById($uid);
            return view('Admin/Views/customer/editCustomer', ['userdetail' => $customerDetails]);
        } else if ($request->isMethod("POST")) {


            $data['name'] = $postdata['firstname'];
            $data['last_name'] = $postdata['lastname'];
            $data['email'] = $postdata['email'];
            $data['username'] = $postdata['username'];

            $result = $ObjUser->updateUserInfo($data, $uid);
            if ($result) {
                return Redirect::back()->with(['status' => 'success', 'msg' => 'Details Suuccesfully Edited.']);
            } else {
                return Redirect::back()->with(['status' => 'success', 'msg' => 'Some Error Occured.']);
            }

        }


    }

    public function pendingCustomer(Request $request)
    {

        return view('Admin/Views/customer/pendingCustomer');

    }

    public function deletedCustomer(Request $request){

        return view('Admin/Views/customer/deletedCustomer');

    }

}