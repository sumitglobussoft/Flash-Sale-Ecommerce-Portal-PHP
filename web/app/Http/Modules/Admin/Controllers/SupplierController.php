<?php
namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use PDO;
use Input;
use getPdo;
use Datatables;
use FlashSale\Http\Modules\Admin\Models\User;
use FlashSale\Http\Modules\Admin\Models\Location;
use FlashSale\Http\Modules\Admin\Models\Usersmeta;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use stdClass;
use Mandrill;
use Illuminate\Support\Facades\Hash;
use FlashSale\Http\Modules\Admin\Models\MailTemplate;

include public_path() . "/../vendor/mandrill/src/Mandrill.php";


class SupplierController extends Controller
{


    public function addNewSupplier(Request $request)
    {


        $response = new stdClass();
        if ($request->isMethod('post')) {

            $postData = $request->all();

            $rules = array(
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'username' => 'required|max:255',
                'flashsale' => 'required'
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

                $supplier = User::create([
                    'name' => $postData['firstname'],
                    'last_name' => $postData['lastname'],
                    'email' => $postData['email'],
                    'password' => Hash::make($password),
                    'role' => '3',
                    'username' => $postData['username'],
                    'campaign_mode' => implode(",", $postData['flashsale'])
                ]);


                if ($supplier) {
//                    return redirect()->intended('admin/supplierDetails');
//                } else {
//                    return view("Admin/Views/supplier/addNewSupplier")->withErrors([
//                        'registerErrMsg' => 'Something went wrong, please try again.',
//                    ]);
//                }

                    $objMailTemplate = MailTemplate::getInstance();
                    $temp_name = "supplier_signup_success_mail";
                    //  $where = ['rawQuery' => 'temp_name = ?', 'bindParam' => $temp_name];

                    $mailTempContent = $objMailTemplate->getTemplateByName($temp_name);
                    $key = env('MANDRILL_KEY');
                    $mandrill = new Mandrill($key);
                    $async = false;
                    $ip_pool = 'Main Pool';
                    $message = array(
                        'html' => $mailTempContent->temp_content,
                        'subject' => "Registration Successful As Supplier",
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
                                        "content" => 'http://localhost.flashsale.com/supplier/login'
                                    )
                                )
                            )
                        ),
                    );

                    $mailrespons = $mandrill->messages->send($message, $async, $ip_pool);
                    if ($mailrespons[0]['status'] == "sent") {
                        return Redirect::back()->with(['status' => 'success', 'msg' => 'Mail sent successfully to  ' . $postData['firstname']]);
                        // return redirect()->intended('admin/supplier-detail');
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
        return view('Admin/Views/supplier/addNewSupplier');

    }


    public function supplierDetail(Request $request)
    {

        $objModelUser = User::getInstance();
        $objModelLocation = Location::getInstance();
        $objModelUserMeta = Usersmeta::getInstance();
        if ($request->isMethod('get')) {

            $where = ['rawQuery' => 'location_type = ?', 'bindParams' => [0]];
            $locationdetail = $objModelLocation->getAllCountryDetails($where);

            return view('Admin/Views/supplier/supplierDetail', ['country' => $locationdetail]);
        } else if ($request->isMethod('post')) {
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
                $where = array('rawQuery' => 'role = ?', 'bindParams' => [3]);
                $userinfo = $objModelUser->getUserInfo($where);
                $resultdata = DB::getPdo()->lastInsertId($userinfo);

//                try {

                $supplierDetails = Usersmeta::create([
                        'user_id' => $resultdata,
                        'addressline1' => $request->input('addressline1'),
                        'addressline2' => $request->input('addressline2'),
                        'city' => $request->input('city'),
                        'state' => $request->input('state'),
                        'country' => $request->input('country'),//NEED COUNTRY DETAILS, FROM DATABASE
                        'zipcode' => $request->input('zipcode'),
                        'phone' => $request->input('phone')
                    ]
                );
//                    echo"<pre>";print_r($supplierDetails);die("xdfh");

                if ($supplierDetails) {
                    return redirect()->back()->with('succmsg', 'Added Successfully.');
                } else {
                    return redirect()->back()->with('error', 'Something went wrong, please try again.')->withInput();
                }
//                } catch (\Exception $ex) {
//                    return redirect()->back()->with('error', 'An exception occurred, please reload the page and try again.')->withInput();
//                }

            }
        }

    }


    public function supplierAjaxHandler(Request $request)
    {


                    $inputData = $request->input();
                    $method = $request->input('method');
                    $ObjUser = User::getInstance();
                    $objModelLocation = Location::getInstance();
                    $ObjUsermeta = Usersmeta::getInstance();
                    $mainId = Session::get('fs_admin')['id'];
                    if ($method) {
                        switch ($method) {
                            case 'availableSupplier':
                                $objuser = User::getInstance();
                                $where = array('rawQuery' => 'role = ?', 'bindParams' => [3]);
                                $available_supplier = $objuser->getAvailableSupplierDetails($where);
//                    echo"<pre>";print_r($available_supplier);die("gvj");
//                    foreach ($available_supplier as $key => $val) {
//                        $vail[$key] = $val->id;
//                        $available_supplier[$key] = $val;
//                        $available_supplier[$key]->usermeta = array();
//                        $available_supplier[$key] = $val;
//                        $available_supplier[$key]->filter = array();
//                    }
//                    $supplier = implode(",",$vail);
//                    echo"<pre>";print_r($supplier);die("cvjh");
                    //  $whereuser = ['rawQuery' => 'user_id = ?', 'bindParams' => $vail];
//                    $usermetaInfo = $ObjUsermeta->getAvaiableUserMetaDetails();
//                    foreach($usermetaInfo as $keymeta => $valmeta){
//                        $usermetaInfo[$keymeta] = $valmeta;
////                        $usermetaInfo[$keymeta]->filter = array();
//                    }
//
//                    if(!empty($usermetaInfo)){
//
//                        $available_supplier[$key]->usermeta =  $usermetaInfo;
//
//                    }
//                    echo"<pre>";print_r($available_supplier);die("cvjh");


                    //  echo"<pre>";print_r($usermetaInfo);die("cvjh");
//
//                    $whereuser = array('rawQuery' => 'user_id IN('.$supplier.')');

//                    $available_supplier[$key] = $usermetadescription;

////                    echo"<pre>";print_r($available_customers);die("cvjh");
//
                    //  $usermetaInfo = $ObjUsermeta->getAvaiableUserMetaDetails($whereuser);
                    //  foreach ($usermetaInfo as $filtergroupkey => $filtergroupvalue) {
                    //    $usermetaInfo[$filtergroupkey]->filtergroup = array();
//                        if ($filtergroupvalue->permission_ids != '') {
//                            $catfilterName = array_values(array_unique(explode(',', $filtergroupvalue->permission_ids)));
//                            $per = implode(",", $catfilterName);
//                            $where = ['rawQuery' => 'permission_id IN(' . $per . ')'];
//                            $getcategory = $objPermissionModel->getPermissionNameByIds($where);
//
//                            foreach ($getcategory as $catkey => $catval) {
//                                $availPermissionRelation[$filtergroupkey]->filter = $catval;
//                                $available_customers[$key]->filter = $availPermissionRelation[$filtergroupkey]->filter;
//                            }
                    //    $available_supplier[$key]->filter = $usermetaInfo[$filtergroupkey]->filtergroup;

//
                    //   }

//                    }


//                    echo"<pre>";print_r($available_supplier);die("gvj");
                    return Datatables::of($available_supplier)
                        ->addColumn('action', function ($available_supplier) {
                            $action = '<span class="tooltips" title="Edit Supplier Details." data-placement="top"> <a href="/admin/edit-supplier/' . $available_supplier->id . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">';
                            $action .= '<i class="fa fa-pencil-square-o"></i></a>';
                            $action .= '</span> &nbsp;&nbsp;';
                            $action .= '<span class="tooltips" title="Delete Supplier Details." data-placement="top"> <a href="#" data-cid="' . $available_supplier->id . '" class="btn btn-danger delete-supplier" style="margin-left: 10%;">';
                            $action .= '<i class="fa fa-trash-o"></i>';
                            $action .= '</a></span>';
                            return $action;

                        })
                        ->addColumn('status', function ($available_supplier) use ($mainId) {

                            $button = '<td style="text-align: center">';
                            $button .= '<button class="btn ' . (($available_supplier->status == 1) ? "btn-success" : "btn-danger") . ' supplier-status" data-id="' . $available_supplier->id . '"  data-set-by="' . $mainId . '">' . (($available_supplier->status == 1) ? "Active" : "Inactve") . ' </button>';
                            $button .= '<td>';
                            return $button;

                        })
                        ->addColumn('supplierdetail', function ($available_supplier) {
                            return '<td style = "text-align: center" ><div class="container" style = "width: 50px " >
                             <span class="tooltips" title = "Review Description." data-placement = "top" ><button data-id = "' . $available_supplier->id . '" type = "button" class="btn btn-sm btn-default modaldescription" data-toggle = "modal" data-target = "#mymodel" ><i class="fa fa-expand" ></i ></button ></span >
                               </div >
                            </td >';
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();

                    break;
                case 'pendingSupplier':
                    $objuser = User::getInstance();
                    $where = array('rawQuery' => 'role = ? and status = ?', 'bindParams' => [3, 0]);
//                    $status = array('rawQuery' => 'status = ?', 'bindParams' => [0]);
                    $pending_supplier = $objuser->getPendingUserDetails($where);

                    return Datatables::of($pending_supplier)
                        ->addColumn('status', function ($pending_supplier) {
                            return ' <td style = "text-align: center" >
                                            <button class="btn btn-primary customer-status"
                                                    data-id = ' . $pending_supplier->id . ' >Pending
                                            </button >

                                    </td > ';
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();

                    break;
                case 'deletedSupplier':
                    $objuser = User::getInstance();
                    $where = array('rawQuery' => 'role = ?', 'bindParams' => [3]);
                    $status = array('rawQuery' => 'status = ?', 'bindParams' => [4]);
                    $deleted_supplier = $objuser->getDeletedUserDetails($where, $status);

                    return Datatables::of($deleted_supplier)
                        ->addColumn('status', function ($deleted_supplier) {
                            return ' < td style = "text-align: center" >
                                            <button class="btn btn-primary customer-status"
                                                    data - id = ' . $deleted_supplier->id . ' > Deleted
                                            </button >

                                    </td > ';
                        })
                        ->removeColumn('name')
                        ->removeColumn('updated_at')
                        ->make();
                    break;
                case 'changeSupplierStatus':
                    $userId = $inputData['UserId'];
                    $whereForUpdate = ['rawQuery' => 'id =?', 'bindParams' => [$userId]];
                    $dataToUpdate['status'] = $inputData['status'];
                    $dataToUpdate['status_set_by'] = $inputData['statussetBy'];
                    $updateResult = $ObjUser->updateUserWhere($dataToUpdate, $whereForUpdate);

                    if ($updateResult == 1) {
                        echo json_encode(['status' => 'success', 'msg' => 'Status has been changed . ']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again . ']);
                    }
                    break;
                case 'deleteSupplierStatus':
                    $userId = $inputData['UserId'];
                    $where = ['rawQuery' => 'id = ?', 'bindParams' => [$userId]];
                    $deleteStatus = $ObjUser->deleteUserDetails($where);
                    if ($deleteStatus) {
                        $where = ['rawQuery' => 'user_id = ?', 'bindParams' => [$userId]];
                        $deleteSupplier = $ObjUsermeta->deleteSupplierDetails($where);
                        if ($deleteSupplier) {
                            echo json_encode(['status' => 'success', 'msg' => 'User Deleted']);
                        }
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again . ']);

                    }
                    break;
                case "locationinfo":
                    $where = ['rawQuery' => 'location_type = ?', 'bindParams' => [0]];
                    $locationdetail = $objModelLocation->getAllCountryDetails($where);
                    echo json_encode($locationdetail);
                    break;
                case 'stateInfoByLocation':
                    $countryId = $request->input('countryId');
                    $where = array('rawQuery' => 'parent_id = ? and location_type = ?', 'bindParams' => [$countryId, 1]);
                    $stateInfo = $objModelLocation->getStateByCountryId($where);
                    echo json_encode($stateInfo);
                    break;

                case 'cityInfoByLocation':
                    $countryId = $request->input('countryId');
                    $where = array('rawQuery' => 'parent_id = ? and location_type = ?', 'bindParams' => [$countryId, 1]);
                    $cityInfo = $objModelLocation->getCityByCountryId($where);
                    echo json_encode($cityInfo);
                    break;

                case 'getUsermetaInfoByUserId':
                    $UserId = $request->input('UserId');
                    $where = array('rawQuery' => 'user_id = ?', 'bindParams' => [$UserId]);
                    $selectedColumns = ['location.*', 'usersmeta.addressline1', 'usersmeta.addressline2', 'usersmeta.city', 'usersmeta.state', 'usersmeta.zipcode', 'usersmeta.phone', 'usersmeta.user_id'];
                    $userMetaInfo = $ObjUsermeta->getUserMetaInfoByUserId($where, $selectedColumns);
//                    echo"<pre>";print_r($userMetaInfo);die("Cfh");
                    echo json_encode($userMetaInfo);
                    break;
                default:
                    break;
            }
        }
    }


    public
    function availableSupplier(Request $request)
    {


        return view('Admin/Views/supplier/availableSupplier');

    }


    public
    function editSupplier(Request $request, $sid)
    {

        $postdata = $request->all();

        $ObjUser = User::getInstance();
        if ($request->isMethod("GET")) {
//             $where = ['rawQuery' => 'id = ?', 'bindParams' => [$sid]];
            $customerDetails = $ObjUser->getUserById($sid);

            return view('Admin/Views/supplier/editSupplier', ['userinfo' => $customerDetails]);
        } else if ($request->isMethod("POST")) {

            $data['name'] = $postdata['firstname'];
            $data['last_name'] = $postdata['lastname'];
            $data['email'] = $postdata['email'];
            $data['username'] = $postdata['username'];
            $data['campaign_mode'] = implode(",", $postdata['flashsale']);
            $result = $ObjUser->updateUserInfo($data, $sid);
            if ($result) {
                return Redirect::back()->with(['status' => 'success', 'msg' => 'Details Suuccesfully Edited . ']);
            } else {
                return Redirect::back()->with(['status' => 'success', 'msg' => 'Some Error Occured . ']);
            }

        }

    }


    public
    function pendingSupplier(Request $request)
    {


        return view('Admin/Views/supplier/pendingSupplier');
    }


    public
    function deletedSupplier(Request $request)
    {


        return view('Admin/Views/supplier/deletedSupplier');
    }

}
