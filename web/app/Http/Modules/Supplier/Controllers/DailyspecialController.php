<?php
namespace FlashSale\Http\Modules\Supplier\Controllers;


use FlashSale\Http\Modules\Supplier\Models\Campaigns;
use FlashSale\Http\Modules\Supplier\Models\ProductCategory;
use FlashSale\Http\Modules\Supplier\Models\Products;
use FlashSaleApi\Http\Models\ProductCategories;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PDO;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\curl\CurlRequestHandler;
use stdclass;

use Yajra\Datatables\Datatables;

class DailyspecialController extends Controller
{

    /**
     * Add Flashsale and Daily Special Campaigns.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @since 19-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function addDailyspecial(Request $request)
    {

        $objProductCategory = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];
        $where = ['rawQuery' => 'added_by = ?', 'bindParams' => [$supplierId]];
        $selectedColumn = ['product_name', 'product_id'];
        $getProducts = $objProductModel->getAllSupplierProducts($where, $selectedColumn);

        if ($request->isMethod('post')) {
            $rules = array(
                'campaign_name' => 'required|unique:campaigns',
                'campaign_type' => 'required',
                'percentagediscount' => 'required|min:40|numeric',
                'availablefromdate' => 'required',
//                'availableuptodate' => 'required|after:availablefromdate',
                'availableuptodate' => 'required',
                'dailyspecial_image' => 'image|required',
                'productcategories' => 'required',
                'product' => 'required',

            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $postData = $request->all();
            $data['campaign_name'] = $postData['campaign_name'];
//            $data['for_shop_id'] = $postData['suppliershop'];
            if (sizeof($postData['product']) >= 10) {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'flashsale', 'flashsale_' . $supplierId . '_' . time() . ".jpg");
                    $data['campaign_banner'] = $filePath;
                }
                $data['campaign_type'] = 2;
                $data['discount_type'] = '2';
//            if ($data['discount_type'] == '1') {
//                $data['discount_value'] = $postData['flatdiscount'];
//            } else {
                $data['discount_value'] = $postData['percentagediscount'];
//            }
                $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
                $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
                $data['available_from'] = $validFrom;
                $data['available_upto'] = $validTo;
                $categ = $postData['productcategories'];
                if (isset($postData['productsubcategories'])) {
                    $subcat = $postData['productsubcategories'];
                } else {
                    $subcat = [];
                }
                $tmp = [];
                foreach ($categ as $index => $item) {
                    $tmp[$item] = array_values(array_filter(array_map(function ($cat) use ($item) {
                        if (explode('_', $cat)[0] == $item) {
                            return explode('_', $cat)[1];
                        }
                    }, $subcat)));
                }
                $data['by_user_id'] = $supplierId;
//                $product = $postData['product'];
                $data['for_category_ids'] = json_encode($tmp);
                $data['for_product_ids'] = implode(",", $postData['product']);
                $campaigns = 'Flashsale';

            } else {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'dailyspecial', 'dailyspecial_' . $supplierId . '_' . time() . ".jpg");
                    $data['campaign_banner'] = $filePath;
                }
                $data['campaign_type'] = $postData['campaign_type'];
                $data['discount_type'] = '2';
//            if ($data['discount_type'] == '1') {
//                $data['discount_value'] = $postData['flatdiscount'];
//            } else {
                $data['discount_value'] = $postData['percentagediscount'];
//            }
                $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
                $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
                $data['available_from'] = $validFrom;
                $data['available_upto'] = $validTo;
                $categ = $postData['productcategories'];
                if (isset($postData['productsubcategories'])) {
                    $subcat = $postData['productsubcategories'];
                } else {
                    $subcat = [];
                }
                $tmp = [];
                foreach ($categ as $index => $item) {
                    $tmp[$item] = array_values(array_filter(array_map(function ($cat) use ($item) {
                        if (explode('_', $cat)[0] == $item) {
                            return explode('_', $cat)[1];
                        }
                    }, $subcat)));
                }
                $data['by_user_id'] = $supplierId;
                $product = $postData['product'];
                $data['for_category_ids'] = json_encode($tmp);
                $data['for_product_ids'] = implode(",", $product);
                $campaigns = 'Dailyspecial';
                print_a($data);
            }

            $campaign = $objCampaignModel->addFlashsale($data);
            if ($campaign) {
                return Redirect::back()->with(['status' => 'success', 'msg' => $campaigns . ' ' . 'Campaign Added Successfully.']);
            } else {
                return Redirect::back()->with(['status' => 'error', 'msg' => 'Some Error try again.']);
            }
        }
        return view('Supplier/Views/dailyspecial/addDailyspecial', ['Products' => $getProducts]);

    }

    /**
     *Daily Special Ajax Handler
     * @param Request $request
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
    public function dailyspecialAjaxhandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];
        switch ($method) {
            case 'getSupplierProducts':
//                $where = ['rawQuery' => 'product_categories.parent_category_id IN(' . implode(",", $inputData['catId']) . ') AND product_categories.status_set_by = ? AND products.status_set_by = ? AND products.product_type = ?', 'bindParams' => [$supplierId, $supplierId, 0]];
                $where = ['rawQuery' => 'added_by = ?', 'bindParams' => [$supplierId]];
                $selectedColumn = ['product_name', 'product_id'];
                $allactiveproducts = $objProductModel->getAllSupplierProducts($where, $selectedColumn);
                if (!empty($allactiveproducts)) {
                    echo json_encode($allactiveproducts);
                } else {
                    echo 0;
                }
                break;
            default:
                break;
        }
    }

    /**
     * Campaign Listing AjaxHandler With Filter
     * @param Request $request
     * @param $method
     * @return mixed
     * @throws \Exception
     * @author: Vini Dubey<vinidubey@globussoft.in>
     * @since: xx-xx-xxxx
     */
    public function campaignListAjaxHandler(Request $request, $method)
    {

        $inputData = $request->input();
        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];

        switch ($method) {
            case 'manageDailyspecial':
                //   Modify code for filter //
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);
//                $columns = array('o.order_id', 'o.added_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');
                $columns = array('campaigns.campaign_id', 'campaigns.campaign_name', 'campaigns.campaign_type', 'users.username', 'campaigns.discount_value', 'campaigns.available_from', 'available_upto', 'category', 'product', 'campaigns.campaign_status');
                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {

                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['campaignId'])) {

//                        $statusData = array('campaign_status' => $_REQUEST['customActionValue']);
                        $statusData['campaign_status'] = $_REQUEST['customActionValue'];
                        $whereForStatusUpdate = ['rawQuery' => 'campaign_id IN (' . implode(',', $_REQUEST['campaignId']) . ')'];
//                        $statusData = ['rawQuery' => 'campaign_id= ?', 'bindParams' => [$_REQUEST['customActionValue']]];
                        $updateResult = $objCampaignModel->updateFlashsaleStatus($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }
                // End Modify code for filter//


                $where = ['rawQuery' => 'campaign_type IN(1,2) AND by_user_id = ? AND campaign_status IN(1,2,3,4,5)', 'bindParams' => [$supplierId]];
                $selectedColumn = ['campaigns.*', 'users.username'];

                $dailyspecialInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);

                foreach ($dailyspecialInfo as $flashkey => $flashval) {
//                    $categoryIds = $flashval->for_category_ids;
                    $productIds = $flashval->for_product_ids;

//                    $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
//                    $getcategory = $objCategoryModel->getCategoryNameById($where);
                    $whereProd = ['rawQuery' => 'product_id IN(' . $productIds . ')'];
                    $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT product_name) AS product_name'), DB::raw('GROUP_CONCAT(DISTINCT product_id) AS product_id')];
                    $getproduct = $objProductModel->getProductNameById($whereProd, $selectedColumn);

//                    foreach ($getcategory as $catkey => $catval) {
//                        $dailyspecialInfo[$flashkey]->category = $catval->category_name;
//                    }
                    foreach ($getproduct as $prodkey => $prodval) {
                        $dailyspecialInfo[$flashkey]->product = $prodval->product_name;
                    }

                }
                $flash = json_decode(json_encode($dailyspecialInfo), true);
                $flashDetail = new Collection();
                foreach ($flash as $mainflashkey => $mainflashval) {
                    $flashDetail->push([
                        'checkbox' => '<input type="checkbox" name="id[]" value="' . $mainflashval['campaign_id'] . '">',
                        'campaign_id' => $mainflashval['campaign_id'],
                        'campaign_name' => $mainflashval['campaign_name'],
                        'campaign_type' => ($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : 'Flashsale',
                        'username' => $mainflashval['username'],
//                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                        'discount_value' => $mainflashval['discount_value'] . '%',
                        'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                        'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                        'category' => $mainflashval['category'],
                        'product' => count(explode(",", $mainflashval['product'])),
                        'campaign_status' => $mainflashval['campaign_status'],
                        'action' => '',
                        'supplierId' => Session::get('fs_supplier')['id']

                    ]);
                }


                //FILTERING START FROM HERE //
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                    if ($_REQUEST['campaign_id'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_id` = " . $_REQUEST['campaign_id'] . " )";
                    }
                    if ($_REQUEST['campaign_name'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_name` LIKE '%" . $_REQUEST['campaign_name'] . "%' )";
                    }
                    if ($_REQUEST['campaign_type'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_type` = " . $_REQUEST['campaign_type'] . " )";
                    }
                    if ($_REQUEST['username'] != '') {
                        $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['username'] . "%' )";
                    }
                    if ($_REQUEST['discount_value_from'] != '' && $_REQUEST['discount_value_to'] != '') {
                        $filteringRules[] = "(`campaigns`.`discount_value` BETWEEN " . intval($_REQUEST['discount_value_from']) . " AND " . intval($_REQUEST['discount_value_to']) . "  )";
                    }
                    if ($_REQUEST['available_from_date'] != '' && $_REQUEST['available_upto_date'] != '') {
                        $filteringRules[] = "( `campaigns`.`available_from` < " . strtotime(str_replace('-', ' ', $_REQUEST['available_upto_date'])) . " AND `campaigns`.`available_upto` > " . strtotime(str_replace('-', ' ', $_REQUEST['available_from_date'])) . " )";
                    }
//                    print_a($filteringRules);
//                    elseif ($_REQUEST['available_from_date'] != '') {
////                        $filteringRules[] = "(`campaigns`.`available_from` BETWEEN " . strtotime($_REQUEST['available_from_date']) . " AND  `campaigns`.`available_upto` = " . strtotime($_REQUEST['available_upto_date']) . "  )";
//                        $filteringRules[] = "(`campaigns`.`available_from` = " . $_REQUEST['available_from_date'] . ")";
////                        $filteringRules[] = "(`campaigns`.`available_from` = " . strtotime((str_replace( '-',' ',$_REQUEST['available_from_date']))) . ")";
////                        $filteringRules[] = "(`campaigns`.`available_from` BETWEEN " . strtotime(str_replace( '-',' ',$_REQUEST['available_from_date'])) . " AND " . strtotime(str_replace( '-',' ',$_REQUEST['available_upto_date'])) . "  )";
////                        $filteringRules[] = "(`campaigns`.`available_upto` BETWEEN " . strtotime(str_replace( '-',' ',$_REQUEST['available_from_date'])) . " AND  " . strtotime(str_replace( '-',' ',$_REQUEST['available_upto_date'])) . "  )";
//                    } elseif($_REQUEST['available_upto_date'] != ''){
//                        $filteringRules[] = "(`campaigns`.`available_upto` LIKE '%" . strtotime(str_replace( '-',' ',$_REQUEST['available_upto_date'])) . "%')";
//                    }
//                    if ($_REQUEST['category_id'] != '') {
//                        $filteringRules[] = "(`campaigns`.`for_category_ids`  LIKE '%" . implode(",", $_REQUEST['category_id']) . "%' )";
//                    }
                    if ($_REQUEST['campaign_status'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_status` = " . $_REQUEST['campaign_status'] . " )";
                    }

                    // FOR CAMPAIGN FILTER //
                    $implodedWhere = '';
                    if (!empty($filteringRules)) {
                        $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                            return $filterValues;
                        }, $filteringRules));
                    }
                    $where = ['rawQuery' => 'campaign_type IN(1,2) AND by_user_id = ? AND campaign_status IN(1,2,3,4,5)', 'bindParams' => [$supplierId]];
                    $selectedColumn = ['campaigns.*', 'users.username'];
                    $MainFlashInfo = $objCampaignModel->getAllFlashDetail($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);

                    foreach ($MainFlashInfo as $flashkey => $flashval) {
//                        $categoryIds = $flashval->for_category_ids;
                        $productIds = $flashval->for_product_ids;
//                        $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
//                        $getcategory = $objCategoryModel->getCategoryNameById($where);
                        $whereProd = ['rawQuery' => 'product_id IN(' . $productIds . ')'];
                        $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT product_name) AS product_name'), DB::raw('GROUP_CONCAT(DISTINCT product_id) AS product_id')];
                        $getproduct = $objProductModel->getProductNameById($whereProd, $selectedColumn);

//                        foreach ($getcategory as $catkey => $catval) {
//                            $MainFlashInfo[$flashkey]->category = $catval->category_name;
//                        }
                        foreach ($getproduct as $prodkey => $prodval) {
                            $MainFlashInfo[$flashkey]->product = $prodval->product_name;
                        }
                    }

                    // FOR DISPLAYING DATA TO DATATABLE //
                    $flash = json_decode(json_encode($MainFlashInfo), true);
                    $flashDetail = new Collection();
                    foreach ($flash as $mainflashkey => $mainflashval) {
                        $flashDetail->push([
                            'checkbox' => '<input type="checkbox" name="id[]" value="' . $mainflashval['campaign_id'] . '">',
                            'campaign_id' => $mainflashval['campaign_id'],
                            'campaign_name' => $mainflashval['campaign_name'],
                            'campaign_type' => ($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : 'Flashsale',
                            'username' => $mainflashval['username'],
//                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                            'discount_value' => $mainflashval['discount_value'] . '%',
                            'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                            'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                            'category' => $mainflashval['category'],
                            'product' => count(explode(",", $mainflashval['product'])),
                            'campaign_status' => $mainflashval['campaign_status'],
                            'action' => '',
                            'supplierId' => Session::get('fs_supplier')['id']


                        ]);
                    }
                    // FOR SHOWING STATUS AND EDIT HTML //
//                    foreach ($MainFlashInfo as $ORkey => $ORvalue) {
//                        $paymentType = $ORvalue->campaign_status == 1 ? 'Active' : 'Inactive';
//                        $records["data"][] = array(
//                            '<span class="tooltips" title="Edit Wholesale Details." data-placement="top"> <a href="/supplier/edit-wholesale/' . $ORvalue->campaign_id . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
//                                                    <i class="fa fa-pencil-square-o"></i>
//                                                </a>
//                                            </span>',
//                            '<td style="text-align: center"><button class="btn ' . (($ORvalue->campaign_status == 1) ? "btn-success" : "btn-danger") . ' wholesale-status" data-id="' . $ORvalue->campaign_id . '" data-set-by="' . $supplierId . '">' . (($ORvalue->campaign_status == 1) ? 'Active' : 'Inactive') . ' </button></td>',
//                        );
//                    }
                }
                //FILTERING ENDS HERE //
                $status_list = array(
                    1 => array("success" => "Success"),
                    2 => array("primary" => "InActive"),
                    3 => array("warning" => "Rejected"),
                    4 => array("danger" => "Deleted"),
                    5 => array("danger" => "Finished"),
                );
                return Datatables::of($flashDetail, $status_list)
                    ->addColumn('action', function ($flashDetail) {
                        return '<span class="tooltips" title="Edit Campaign Details." data-placement="top"> <a href="/supplier/edit-campaign/' . $flashDetail['campaign_id'] . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </span>';
//                                            <span class="tooltips" title="Delete campaign Details." data-placement="top"> <a href="#" data-cid="' . $flashDetail['campaign_id'] . '" class="btn btn-danger delete-dailyspecial" style="margin-left: 10%;">
//                                                    <i class="fa fa-trash-o"></i>
//                                                </a>
//                                            </span>

                    })
                    ->addColumn('campaign_status', function ($flashDetail) use ($status_list) {
                        return '<span class="label label-sm label-' . (key($status_list[$flashDetail['campaign_status']])) . '">' . (current($status_list[$flashDetail['campaign_status']])) . '</span>';
                    })
                    ->removeColumn('for_shop_id')
//                    ->removeColumn('for_product_ids')
//                    ->removeColumn('for_product_ids')
//                    ->removeColumn('campaign_id')
                    ->removeColumn('campaign_banner')
                    ->make();
                break;
            default:
                break;

        }
    }

    public function manageDailyspecial(Request $request)
    {

        return view('Supplier/Views/dailyspecial/manageDailyspecial');

    }

    /**
     * Edit Dailyspecail And Campaign Action
     * @param Request $request
     * @param $did
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @author: Vini Dubey<vinidubey@globussoft.in>
     * @since: xx-xx-xxxx
     */
    public function editDailyspecial(Request $request, $did)
    {

        $objProductCategory = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];

        if ($request->isMethod('post')) {
            $rules = array(
                'campaign_name' => 'unique:campaigns,campaign_name,' . $did . ',campaign_id',
//                'discounttype' => 'required',
//                'flatdiscount' => 'required|min:1|numeric',
//                'percentagediscount' => 'required|min:1|numeric',
//                'availablefromdate' => 'required',
//                'availableuptodate' => 'required',
                'dailyspecial_image' => 'image',
//                'productcategories' => 'required',
//                'product' => 'required'

            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $postData = $request->all();
            if (sizeof($postData['product']) >= 10) {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'flashsale', 'flashsale_' . $supplierId . '_' . time() . ".jpg");
                    $data['campaign_banner'] = $filePath;
                }
                $data['campaign_name'] = $postData['campaign_name'];
                $data['campaign_type'] = 2;
                $data['discount_type'] = '2';
//            if ($data['discount_type'] == '1') {
//                $data['discount_value'] = $postData['flatdiscount'];
//            } else {
                $data['discount_value'] = $postData['percentagediscount'];
//            }
                $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
                $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
                $data['available_from'] = $validFrom;
                $data['available_upto'] = $validTo;
                $categ = $postData['productcategories'];
                if (isset($postData['productsubcategories'])) {
                    $subcat = $postData['productsubcategories'];
                } else {
                    $subcat = [];
                }
                $tmp = [];
                foreach ($categ as $index => $item) {
                    $tmp[$item] = array_values(array_filter(array_map(function ($cat) use ($item) {
                        if (explode('_', $cat)[0] == $item) {
                            return explode('_', $cat)[1];
                        }
                    }, $subcat)));
                }
                $data['for_category_ids'] = json_encode($tmp);
                $data['by_user_id'] = $supplierId;
//                $product = $postData['product'];
                $data['for_product_ids'] = implode(",", $postData['product']);
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$did]];
                $campaigns = 'Flashsale';
//                print_a($data);
            } else {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'dailyspecial', 'dailyspecial_' . $supplierId . '_' . time() . ".jpg");
                    $data['campaign_banner'] = $filePath;
                }
                $data['campaign_name'] = $postData['campaign_name'];
                $data['campaign_type'] = $postData['campaign_type'];
                $data['discount_type'] = '2';
                $data['discount_value'] = $postData['percentagediscount'];
                $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
                $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
                $data['available_from'] = $validFrom;
                $data['available_upto'] = $validTo;
                $categ = $postData['productcategories'];

                if (isset($postData['productsubcategories'])) {
                    $subcat = $postData['productsubcategories'];
                } else {
                    $subcat = [];
                }
//                print_r($categ);
//                print_a($subcat);
                $tmp = [];
                foreach ($categ as $index => $item) {
                    $tmp[$item] = array_values(array_filter(array_map(function ($cat) use ($item) {
                        if (explode('_', $cat)[0] == $item) {
                            return explode('_', $cat)[1];
                        }
                    }, $subcat)));
                }
//                print_a(json_encode($tmp));
                $data['for_category_ids'] = json_encode($tmp);
                $data['by_user_id'] = $supplierId;
//                $product = $postData['product'];
                $data['for_product_ids'] = implode(",", $postData['product']);
//                $data['for_product_ids'] = $postData['product'][0];
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$did]];
                $campaigns = 'Dailyspecial';
//                print_a($data);
            }
            $campaignUpdate = $objCampaignModel->updateFlashsaleStatus($data, $where);
            if ($campaignUpdate) {
                if (isset($filePath))
                    deleteImageFromStoragePath($postData['oldImage']);
                return Redirect::back()->with(['status' => 'success', 'msg' => $campaigns . ' ' . 'Updated Successfully.']);
            } else {
                return Redirect::back()->with(['status' => 'error', 'msg' => $campaigns . ' ' . 'Some Error try again.']);
            }
        }

        $where = ['rawQuery' => 'campaign_id = ? AND by_user_id = ?', 'bindParams' => [$did, $supplierId]];
        $selectedColumn = ['campaigns.*', 'users.username'];
        $dailyspecialInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
//        print_a($dailyspecialInfo);
        if ((isset($dailyspecialInfo) && (!empty($dailyspecialInfo)))) {
            foreach ($dailyspecialInfo as $flashkey => $flashval) {
                $categoryIds = json_decode($flashval->for_category_ids, true);
                $categoryMerg = array_merge(array_keys($categoryIds));
                $categoryMergee = array_merge(array_flatten($categoryIds));
                $categoryMerge = array_merge(array_keys($categoryIds), array_flatten($categoryIds));
//                echo'<pre>';print_r($categoryMerg);
//                echo'<pre>';print_r($categoryMergee);
//                print_a($categoryMerge);
                $where = ['rawQuery' => 'category_id IN(' . implode(",", $categoryMerge) . ')'];
                $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name'), DB::raw('GROUP_CONCAT(DISTINCT category_id) AS category_id')];
                $getcategory = $objProductCategory->getCategoryNameById($where, $selectedColumn);
                foreach ($getcategory as $catkey => $catval) {
                    $dailyspecialInfo[$flashkey]->category = $catval->category_name;
                    $dailyspecialInfo[$flashkey]->category_ids = $catval->category_id;
                }
                $whereProduct = ['rawQuery' => 'product_id IN(' . $flashval->for_product_ids . ')'];
                $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT product_name) AS product_name'), DB::raw('GROUP_CONCAT(DISTINCT product_id) AS product_id')];
                $getproduct = $objProductModel->getProductNameById($whereProduct, $selectedColumn);

                foreach ($getproduct as $prodkey => $prodval) {
                    $dailyspecialInfo[$flashkey]->product_name = $prodval->product_name;
                    $dailyspecialInfo[$flashkey]->product_id = $prodval->product_id;
                }
            }
            $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?', 'bindParams' => [1, 0]];
            $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
            $allactivecategories = $objProductCategory->getAllMainCategories($where, $selectedColumn);
            $where = ['rawQuery' => 'category_status = ?', 'bindParams' => [1]];
            $selectedColumn = ['product_categories.*', DB::raw('GROUP_CONCAT(category_id)AS main_category_id'),
                DB::raw('GROUP_CONCAT(category_name)AS main_category_name')];
            $allActiveSubcategories = $objProductCategory->getSubCategoriesForMaincategory($where, $selectedColumn);

            $mainCategory = array_filter(array_map(function ($category) {
                if ($category->parent_category_id == 0)
                    return $category;
            }, $allActiveSubcategories))[0];

            $finalCatData = [];
            foreach (explode(',', $mainCategory->main_category_id) as $index => $mainCatID) {
                foreach ($allActiveSubcategories as $subCatKey => $allActiveSubcategory) {
                    if ($allActiveSubcategory->parent_category_id == $mainCatID) {
                        $allActiveSubcategory->main_cat_name = explode(',', $mainCategory->main_category_name)[$index];
                        $finalCatData[$mainCatID] = $allActiveSubcategory;
                    }
                }
            }
            $where = ['rawQuery' => 'added_by = ? AND product_type = ?', 'bindParams' => [$supplierId, 0]];
            $selectedColumn = ['product_id', 'product_name'];
            $allproducts = $objProductModel->getAllSupplierProducts($where, $selectedColumn);

            return view('Supplier/Views/dailyspecial/editDailySpecial', ['dailyspecialInfo' => $dailyspecialInfo[0], 'activeCategory' => $allactivecategories, 'allProducts' => $allproducts, 'allcategories' => $finalCatData]);

        } else {
            return view('Supplier/Views/dailyspecial/editDailySpecial');
        }


    }


}