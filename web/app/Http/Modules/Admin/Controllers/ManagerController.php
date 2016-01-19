<?php
namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use PDO;
use Input;
use Yajra\Datatables\Datatables;
use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use stdClass;
use Mandrill;
use Illuminate\Support\Facades\Hash;
use FlashSale\Http\Modules\Admin\Models\Permissions;
use FlashSale\Http\Modules\Admin\Models\PermissionUserRelation;
use FlashSale\Http\Modules\Admin\Models\MailTemplate;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";


class ManagerController extends Controller
{


    public function addNewManager(Request $request)
    {

        $ObjPermissions = Permissions::getInstance();
        $ObjPermissionUserRelation = PermissionUserRelation::getInstance();
        if ($request->isMethod('GET')) {
            $where = ['rawQuery' => 'permission_id  NOT IN (1)'];
            //echo"<pre>";print_r($where);die("cfh");
            $permissionDetails = $ObjPermissions->getAllPermissions($where);

            return view('Admin/Views/manager/addNewManager',['permissionlist' => $permissionDetails]);
        }elseif($request->isMethod('POST')){
            $postData = $request->all();

            $rules = array(
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'username' => 'required|max:255',
                'permitcheck' => 'required'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
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
                $manager = User::create([
                    'name' => $postData['firstname'],
                    'last_name' => $postData['lastname'],
                    'email' => $postData['email'],
                    'password' => Hash::make($password),
                    'role' => '4',
                    'username' => $postData['username']
                ]);

                $resultdata = DB::getPdo()->lastInsertId($manager);

                $data['user_id'] = $resultdata;
                $permit = $postData['permitcheck'];
                $mainpermission = implode(",",$permit);
                //$mainpermission = 1;
                $data['permission_ids'] = $mainpermission;

               $userPermission = $ObjPermissionUserRelation->insertmanagerpermission($data);

                if ($manager && $userPermission) {

                    $objMailTemplate = MailTemplate::getInstance();
                    $temp_name = "manager_signup_success_mail";
                    //  $where = ['rawQuery' => 'temp_name = ?', 'bindParam' => $temp_name];

                    $mailTempContent = $objMailTemplate->getTemplateByName($temp_name);
                    $key = env('MANDRILL_KEY');
                    $mandrill = new Mandrill($key);
                    $async = false;
                    $ip_pool = 'Main Pool';
                    $message = array(
                        'html' => $mailTempContent->temp_content,
                        'subject' => "Registration Successful As Manager",
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
                                    ),
                                    array(
                                        "name" => "username",
                                        "content" => $postData['username']
                                    ),
                                    array(
                                        "name" => "email",
                                        "content" => $postData['email']
                                    ),
                                    array(
                                        "name" => "url",
                                        "content" => env('WEB_URL') . '/admin/login',
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
                            'bindParams' => [$manager->id]
                        ];
                        $deleteUser = $objuser->deleteUserDetails($whereForUpdate);
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Failed To Send Mail.']);

                    }
                }
            }
        }

    }

    public function availableManager(Request $request)
    {

        return view('Admin/Views/manager/availableManager');

    }

    public function managerAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $request->input('method');
        $ObjUser = User::getInstance();
        if ($method) {
            switch ($method) {
                case "availableManager":
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
            }
        }


    }

    public function editManager(Request $request)
    {

        return view('Admin/Views/manager/editManager');
    }


    public function pendingManager(Request $request)
    {


        return view('Admin/Views/manager/pendingManager');
    }


}