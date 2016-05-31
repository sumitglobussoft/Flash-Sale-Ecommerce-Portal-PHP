<?php
namespace FlashSale\Http\Modules\Admin\Controllers;


use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use FlashSale\Http\Modules\Admin\Models\Products;
use FlashSale\Http\Modules\Admin\Models\Campaigns;
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
use Yajra\Datatables\Datatables;

class CampaignController extends Controller
{

    public function addFlashsale(Request $request)
    {

        return view('Admin/Views/flashsale/addFlashsale');
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function campaignAjaxHandler(Request $request)
    {
        $inputData = $request->input();
        $method = $inputData['method'];
        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $adminId = Session::get('fs_admin')['id'];

        switch ($method) {
            case 'getActiveCategories':
                $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?', 'bindParams' => [1, 0]];
                $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
                $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where, $selectedColumn);
                if (!empty($allactivecategories)) {
                    echo json_encode($allactivecategories);
                } else {
                    echo 0;
                }
                break;
            case 'updateExtendedDaysForCamapign':
                $extenddays = $request->input('extenddays');
                $campaignId = $request->input('campaignId');
                $availableUpto = $request->input('availableUpto');
                $status['extended_end_time'] = strtotime("+$extenddays days", $availableUpto);
                $status['extended_end_type'] = 0;
                $where = ['rawQuery' => 'campaign_id', 'bindParams' => [$campaignId]];
                $updateExtendDate = $objCampaignModel->updateFlashsaleStatus($status, $where);
                if ($updateExtendDate == 1) {
                    echo json_encode(['status' => 'success', 'msg' => 'Date Extended For Campaign.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }

                break;
            case 'getActiveProductsOfSuppliers':
                $where = ['rawQuery' => 'product_status = ? AND product_type = ? AND added_by = ?', 'bindParams' => [1, 0, $request->input('products')]];
                $selectedColumn = ['product_id', 'product_name', 'product_status'];
                $allactiveProducts = $objProductModel->getProductNameById($where, $selectedColumn);
                if (!empty($allactiveProducts)) {
                    echo json_encode($allactiveProducts);
                } else {
                    echo 0;
                }
                break;
            default:
                break;
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageCampaign(Request $request)
    {
        return view('Admin/Views/campaign/manageCampaign');
    }

    /**
     * @param Request $request
     * @param $campaignId
     * @param $added_by
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @author Vini Dubey
     */
    public function editCampaign(Request $request, $campaignId, $added_by)
    {

        $objProductCategory = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $adminId = Session::get('fs_admin')['id'];

        if ($request->isMethod('post')) {
            $rules = array(
                'campaign_name' => 'unique:campaigns,campaign_name,' . $campaignId . ',campaign_id',
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
            if (!isset($postData['product'])) {
                return Redirect::back()
                    ->with(['status' => 'error', 'msg' => 'Please choose atleast 1 product for the campaign'])
                    ->withInput();
            }
            if (sizeof($postData['product']) >= 10) {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'flashsale', 'flashsale_' . $added_by . '_' . time() . ".jpg");
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
                $data['by_user_id'] = $adminId;
                $data['for_product_ids'] = implode(",", $postData['product']);
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaignId]];
                $campaigns = 'Flashsale';
            } else {
                if (Input::hasFile('dailyspecial_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('dailyspecial_image'), 'dailyspecial', 'dailyspecial_' . $added_by . '_' . time() . ".jpg");
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
                $tmp = [];
                foreach ($categ as $index => $item) {
                    $tmp[$item] = array_values(array_filter(array_map(function ($cat) use ($item) {
                        if (explode('_', $cat)[0] == $item) {
                            return explode('_', $cat)[1];
                        }
                    }, $subcat)));
                }
                $data['for_category_ids'] = json_encode($tmp);
                $data['by_user_id'] = $adminId;
                $data['for_product_ids'] = implode(",", $postData['product']);
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaignId]];
                $campaigns = 'Dailyspecial';
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

        $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaignId]];
        $selectedColumn = ['campaigns.*', 'users.username'];
        $dailyspecialInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);

        if ((isset($dailyspecialInfo) && (!empty($dailyspecialInfo)))) {
            foreach ($dailyspecialInfo as $flashkey => $flashval) {
                $categoryIds = json_decode($flashval->for_category_ids, true);
                $categoryMerg = array_merge(array_keys($categoryIds));
                $categoryMergee = array_merge(array_flatten($categoryIds));
                $categoryMerge = array_merge(array_keys($categoryIds), array_flatten($categoryIds));
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
            $allactivecategories = $objProductCategory->getAllCategoriesWhere($where, $selectedColumn);
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
            $where = ['rawQuery' => 'added_by = ? AND product_type = ?', 'bindParams' => [$added_by, 0]];
            $selectedColumn = ['product_id', 'product_name'];
            $allproducts = $objProductModel->getAllSupplierProducts($where, $selectedColumn);

            return view('Admin/Views/campaign/editCampaign', ['dailyspecialInfo' => $dailyspecialInfo[0], 'activeCategory' => $allactivecategories, 'allProducts' => $allproducts, 'allcategories' => $finalCatData]);

        } else {
            return view('Admin/Views/campaign/editCampaign');
        }
    }


    /**
     * @param Request $request
     * @param $method
     * @throws \Exception
     */
    public function campaignListAjaxHandler(Request $request, $method)
    {
        $inputData = $request->input();
        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        $adminId = Session::get('fs_admin')['id'];

        switch ($method) {
            case 'campaignLog':
                //   Modify code for filter //
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);
                $columns = array('campaigns.campaign_id', 'campaigns.campaign_name', 'campaigns.campaign_type', 'users.username', 'campaigns.discount_value', 'campaigns.available_from', 'available_upto', 'category', 'product', 'campaigns.campaign_status');
                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                }
                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {

                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData['campaign_status'] = $_REQUEST['customActionValue'];
                        $whereForStatusUpdate = ['rawQuery' => 'campaign_id IN (' . implode(',', $_REQUEST['orderId']) . ')'];
                        $updateResult = $objCampaignModel->updateFlashsaleStatus($statusData, $whereForStatusUpdate);
                        print_a($updateResult);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }
                // End Modify code for filter//
                $where = ['rawQuery' => 'campaign_type IN(1) AND campaign_status IN(0,1,2,3,4,5) AND extended_end_type = 0'];
                $selectedColumn = ['campaigns.*', 'users.username'];
                $dailyspecialInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
                foreach ($dailyspecialInfo as $flashkey => $flashval) {
//                    $categoryIds = $flashval->for_category_ids;
                    $productIds = $flashval->for_product_ids;

//                    $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
//
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
                        'campaign_type' => ($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : (($mainflashval['campaign_type'] == 2) ? 'Flashsale' : 'Wholesale'),
                        'username' => $mainflashval['username'],
//                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                        'discount_value' => $mainflashval['discount_value'] . '%',
                        'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                        'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
                        'extended_end_time' => (isset($mainflashval['extended_end_time']) && $mainflashval['extended_end_time'] != 0) ? date('d F Y - h:i A', $mainflashval['extended_end_time']) : "No extended date.",
//                        'category' => $mainflashval['category'],
                        'campaign_status' => $mainflashval['campaign_status'],
                        'product' => count(explode(",", $mainflashval['product'])),
                        'by_user_id' => $mainflashval['by_user_id'],

                    ]);
                }
//                FILTERING START FROM HERE //
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                    if ($_REQUEST['campaign_id'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_id` = " . $_REQUEST['campaign_id'] . " )";
                    }
                    if ($_REQUEST['campaign_name'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_name` LIKE '%" . $_REQUEST['campaign_name'] . "%' )";
                    }
//                    if ($_REQUEST['campaign_type'] != '') {
//                        $filteringRules[] = "(`campaigns`.`campaign_type` = " . $_REQUEST['campaign_type'] . " )";
//                    }
                    if ($_REQUEST['username'] != '') {
                        $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['username'] . "%' )";
                    }
                    if ($_REQUEST['discount_value_from'] != '' && $_REQUEST['discount_value_to'] != '') {
                        $filteringRules[] = "(`campaigns`.`discount_value` BETWEEN " . intval($_REQUEST['discount_value_from']) . " AND " . intval($_REQUEST['discount_value_to']) . "  )";
                    }
                    if ($_REQUEST['available_from_date'] != '' && $_REQUEST['available_upto_date'] != '') {
                        $filteringRules[] = "( `campaigns`.`available_from` < " . strtotime(str_replace('-', ' ', $_REQUEST['available_upto_date'])) . " AND `campaigns`.`available_upto` > " . strtotime(str_replace('-', ' ', $_REQUEST['available_from_date'])) . " )";
                    }
//                    if ($_REQUEST['category_id'] != '') {
//                        $filteringRules[] = "(`campaigns`.`for_category_ids`  LIKE '%" . implode(",", $_REQUEST['category_id']) . "%' )";
//                    }
                    if ($_REQUEST['campaign_status'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_status` = " . $_REQUEST['campaign_status'] . " )";
                    }


                    // FOR CAMPAIGN FILTER //
                    $implodedWhere = '1';
                    if (!empty($filteringRules)) {
                        $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                            return $filterValues;
                        }, $filteringRules));
                    }

                    $where = ['rawQuery' => 'campaign_type IN(1) AND campaign_status IN(0,1,2,3,4,5) AND extended_end_type = 0'];
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
                            'campaign_type' => ($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : (($mainflashval['campaign_type'] == 2) ? 'Flashsale' : 'Wholesale'),
                            'username' => $mainflashval['username'],
//                          'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                            'discount_value' => $mainflashval['discount_value'] . '%',
                            'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                            'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
                            'extended_end_time' => (isset($mainflashval['extended_end_time']) && $mainflashval['extended_end_time'] != 0) ? date('d F Y - h:i A', $mainflashval['extended_end_time']) : "No extended date.",
//                            'category' => $mainflashval['category'],
                            'campaign_status' => $mainflashval['campaign_status'],
                            'product' => count(explode(",", $mainflashval['product'])),
                            'action' => '',
                            'by_user_id' => $mainflashval['by_user_id'],
                        ]);
                    }
                }
                //FILTERING ENDS HERE //
                $status_list = array(
                    0 => array("primary" => "Pending"),
                    1 => array("success" => "Success"),
                    2 => array("primary" => "InActive"),
                    3 => array("warning" => "Rejected"),
                    4 => array("danger" => "Deleted"),
                    5 => array("danger" => "Finished"),
                );
                //  FOR SHOWING STATUS AND EDIT HTML //
                return Datatables::of($flashDetail, $status_list)
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
            case 'manageWholesale':
                //   Modify code for filter //
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);
                $columns = array('campaigns.campaign_id', 'campaigns.campaign_name', 'campaigns.campaign_type', 'users.username', 'campaigns.discount_value', 'campaigns.available_from', 'available_upto', 'category', 'product', 'campaigns.campaign_status');
                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {

                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['orderId'])) {
                        $statusData['campaign_status'] = $_REQUEST['customActionValue'];
                        $whereForStatusUpdate = ['rawQuery' => 'campaign_id IN (' . implode(',', $_REQUEST['orderId']) . ')'];
                        $updateResult = $objCampaignModel->updateFlashsaleStatus($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }
                // End Modify code for filter//


                $where = ['rawQuery' => 'campaign_type = 3 AND campaign_status IN(0,1,2,3,4,5)'];
                $selectedColumn = ['campaigns.*', 'users.username'];
                $dailyspecialInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
                foreach ($dailyspecialInfo as $flashkey => $flashval) {
                    $categoryIds = $flashval->for_category_ids;
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
                        'campaign_type' => 'Wholesale',
                        'username' => $mainflashval['username'],
//                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                        'discount_value' => $mainflashval['discount_value'] . '%',
                        'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                        'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                        'category' => $mainflashval['category'],
                        'product' => count(explode(",", $mainflashval['product'])),
                        'campaign_status' => $mainflashval['campaign_status'],
                        'action' => '',
                        'extended' => '',
                        'by_user_id' => $mainflashval['by_user_id'],

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
//                    if ($_REQUEST['campaign_type'] != '') {
//                        $filteringRules[] = "(`campaigns`.`campaign_type` = " . $_REQUEST['campaign_type'] . " )";
//                    }
                    if ($_REQUEST['username'] != '') {
                        $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['username'] . "%' )";
                    }
                    if ($_REQUEST['discount_value_from'] != '' && $_REQUEST['discount_value_to'] != '') {
                        $filteringRules[] = "(`campaigns`.`discount_value` BETWEEN " . intval($_REQUEST['discount_value_from']) . " AND " . intval($_REQUEST['discount_value_to']) . "  )";
                    }
                    if ($_REQUEST['available_from_date'] != '' && $_REQUEST['available_upto_date'] != '') {
                        $filteringRules[] = "( `campaigns`.`available_from` < " . strtotime(str_replace('-', ' ', $_REQUEST['available_upto_date'])) . " AND `campaigns`.`available_upto` > " . strtotime(str_replace('-', ' ', $_REQUEST['available_from_date'])) . " )";
                    }
//                    if ($_REQUEST['category_id'] != '') {
//                        $filteringRules[] = "(`campaigns`.`for_category_ids`  LIKE '%" . implode(",", $_REQUEST['category_id']) . "%' )";
//                    }
                    if ($_REQUEST['campaign_status'] != '') {
                        $filteringRules[] = "(`campaigns`.`campaign_status` = " . $_REQUEST['campaign_status'] . " )";
                    }


                    // FOR CAMPAIGN FILTER //
                    $implodedWhere = '1';
                    if (!empty($filteringRules)) {
                        $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                            return $filterValues;
                        }, $filteringRules));
                    }

                    $where = ['rawQuery' => 'campaign_type = 3 AND campaign_status IN(0,1,2,3,4,5)'];
                    $selectedColumn = ['campaigns.*', 'users.username'];
                    $MainFlashInfo = $objCampaignModel->getAllFlashDetail($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);

                    foreach ($MainFlashInfo as $flashkey => $flashval) {
                        $categoryIds = $flashval->for_category_ids;
                        $productIds = $flashval->for_product_ids;
                        $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
//                        $getcategory = $objCategoryModel->getCategoryNameById($where);
//                        $whereProd = ['rawQuery' => 'product_id IN(' . $productIds . ')'];
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
                            'campaign_type' => 'Wholesale',
                            'username' => $mainflashval['username'],
//                          'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                            'discount_value' => $mainflashval['discount_value'] . '%',
                            'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                            'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                            'category' => $mainflashval['category'],
                            'product' => count(explode(",", $mainflashval['product'])),
                            'campaign_status' => $mainflashval['campaign_status'],
                            'action' => '',
                            'extended' => '',
                            'by_user_id' => $mainflashval['by_user_id'],


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
                    0 => array("primary" => "Pending"),
                    1 => array("success" => "Success"),
                    2 => array("primary" => "InActive"),
                    3 => array("warning" => "Rejected"),
                    4 => array("danger" => "Deleted"),
                    5 => array("danger" => "Finished"),
                );
                return Datatables::of($flashDetail, $status_list)
                    ->addColumn('action', function ($flashDetail) {
                        return '<span class="tooltips" title="Edit Campaign Details." data-placement="top"> <a href="/admin/edit-wholesale/' . $flashDetail['campaign_id'] . '/' . $flashDetail['by_user_id'] . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </span>';
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
            case 'manageCampaign':
                //   Modify code for filter //
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);
                $columns = array('campaigns.campaign_id', 'campaigns.campaign_name', 'campaigns.campaign_type', 'users.username', 'campaigns.discount_value', 'campaigns.available_from', 'available_upto', 'category', 'product', 'campaigns.campaign_status');
                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {

                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['campaignId'])) {

                        $statusData['campaign_status'] = $_REQUEST['customActionValue'];
                        $whereForStatusUpdate = ['rawQuery' => 'campaign_id IN (' . implode(',', $_REQUEST['campaignId']) . ')'];
                        $updateResult = $objCampaignModel->updateFlashsaleStatus($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }
                // End Modify code for filter//
                $where = ['rawQuery' => 'campaign_type IN(1,2) AND campaign_status IN(0,1,2,3,4,5)'];
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
                        'campaign_type' => ($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : (($mainflashval['campaign_type'] == 2) ? 'Flashsale' : 'Wholesale'),
                        'username' => $mainflashval['username'],
//                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                        'discount_value' => $mainflashval['discount_value'] . '%',
                        'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                        'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                        'category' => $mainflashval['category'],
                        'product' => count(explode(",", $mainflashval['product'])),
                        'campaign_status' => $mainflashval['campaign_status'],
                        'action' => '',
                        'extended' => '',
                        'by_user_id' => $mainflashval['by_user_id'],

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

                    $where = ['rawQuery' => 'campaign_type IN(1) AND campaign_status IN(0,1,2,3,4,5)'];
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
                            'campaign_type' => (($mainflashval['campaign_type'] == 1) ? 'Dailyspecial' : 'Flashsale'),
                            'username' => $mainflashval['username'],
//                          'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'Percentagediscount',
                            'discount_value' => $mainflashval['discount_value'] . '%',
                            'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                            'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
//                            'category' => $mainflashval['category'],
                            'product' => count(explode(",", $mainflashval['product'])),
                            'campaign_status' => $mainflashval['campaign_status'],
                            'action' => '',
                            'extended' => '',
                            'by_user_id' => $mainflashval['by_user_id'],
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
                    0 => array("primary" => "Pending"),
                    1 => array("success" => "Success"),
                    2 => array("primary" => "InActive"),
                    3 => array("warning" => "Rejected"),
                    4 => array("danger" => "Deleted"),
                    5 => array("danger" => "Finished"),
                );
                return Datatables::of($flashDetail, $status_list)
                    ->addColumn('action', function ($flashDetail) {
                        return '<span class="tooltips" title="Edit Campaign Details." data-placement="top"> <a href="/admin/edit-campaign/' . $flashDetail['campaign_id'] . '/' . $flashDetail['by_user_id'] . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </span>';
                    })
                    ->addColumn('campaign_status', function ($flashDetail) use ($status_list) {
//                        print_a(key($status_list[$flashDetail['campaign_status']]));
                        return '<span class="label label-sm label-' . (key($status_list[$flashDetail['campaign_status']])) . '">' . (current($status_list[$flashDetail['campaign_status']])) . '</span>';
                    })
                    ->addColumn('extended', function ($flashDetail) {
                        if ($flashDetail['campaign_type'] == "Dailyspecial") {
                            return '<input min="0" max="5" type="number" id="extendDays' . $flashDetail['campaign_id'] . '" value="" name="extended" class="bgtrans pull-left edittype "><button type="submit"  class="btn btn-primary extend-type" data-campaignId="' . $flashDetail['campaign_id'] . '" data-availableUpto="' . strtotime(str_replace('-', ' ', $flashDetail['available_upto'])) . '"></i>Extend</button>';
                        } else {
                            return ' ';
                        }
                    })
                    ->removeColumn('for_shop_id')
//                    ->removeColumn('for_product_ids')
//                    ->removeColumn('for_product_ids')
//                    ->removeColumn('campaign_id')
                    ->removeColumn('campaign_banner')
                    ->make();
                break;
            case 'getSubCategoriesForMainCategory':
                $where = ['rawQuery' => 'category_status = ?', 'bindParams' => [1]];
//                $selectedColumn = [DB::raw('SELECT product_categories.*
//                CASE WHEN (parent_category_id == 0)
//                 THEN DB::raw("GROUP_CONCAT(category_name)AS main_category_name")
//                 END ')];
                $selectedColumn = ['product_categories.*', DB::raw('GROUP_CONCAT(category_id)AS main_category_id'),
                    DB::raw('GROUP_CONCAT(category_name)AS main_category_name')];
                $allActiveSubcategories = $objCategoryModel->getSubCategoriesForMaincategory($where, $selectedColumn);

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

                if (!empty($finalCatData)) {
                    echo json_encode($finalCatData);
                } else {
                    echo 0;
                }
                break;
            default:
                break;
        }

    }

    /**
     * Extended Campaigns Log For Suppliers
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function extendedCampaignLog(Request $request)
    {

        return view('Admin/Views/campaign/campaignLog');
    }


    /**
     * Manage Wholesale
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageWholesale(Request $request)
    {
        return view('Admin/Views/campaign/manageWholesale');
    }

    /**
     * Edit Wholesale Campaign
     * @param Request $request
     * @param $campaign_id
     * @param $added_by
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @author Vini Dubey
     */
    public function editWholesale(Request $request, $campaign_id, $added_by)
    {

        $objProductCategory = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $objProductModel = Products::getInstance();
        if ($request->isMethod('post')) {
            $rules = array(
                'campaign_name' => 'unique:campaigns,campaign_name,' . $campaign_id . ',campaign_id',
//                'discounttype' => 'required',
//                'flatdiscount' => 'required|min:1|numeric',
//                'percentagediscount' => 'required|min:1|numeric',
//                'availablefromdate' => 'required',
//                'availableuptodate' => 'required',
                'wholesale_image' => 'image',
//                'productcategories' => 'required',
//                'product' => 'required'

            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
            if (Input::hasFile('wholesale_image')) {
                $filePath = uploadImageToStoragePath(Input::file('wholesale_image'), 'wholesale', 'wholesale_' . $added_by . '_' . time() . ".jpg");
                $data['campaign_banner'] = $filePath;
            }
            $postData = $request->all();
            $data['campaign_name'] = $postData['campaign_name'];
            $data['discount_type'] = '2';
            $data['discount_value'] = $postData['percentagediscount'];
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
            $data['by_user_id'] = $added_by;
            $data['for_product_ids'] = implode(",", $postData['product']);
            $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaign_id]];
            $campaigns = 'Wholesale';
            $campaignUpdate = $objCampaignModel->updateFlashsaleStatus($data, $where);
            if ($campaignUpdate) {
                if (isset($filePath))
                    deleteImageFromStoragePath($postData['oldImage']);
                return Redirect::back()->with(['status' => 'success', 'msg' => $campaigns . ' ' . 'Updated Successfully.']);
            } else {
                return Redirect::back()->with(['status' => 'error', 'msg' => $campaigns . ' ' . 'Some Error try again.']);
            }
        }

        $where = ['rawQuery' => 'campaign_id = ?  AND by_user_id = ?', 'bindParams' => [$campaign_id, $added_by]];
        $selectedColumn = ['campaigns.*', 'users.username'];
        $wholesaleInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
        if ((isset($wholesaleInfo) && (!empty($wholesaleInfo)))) {
            foreach ($wholesaleInfo as $flashkey => $flashval) {
                $categoryIds = json_decode($flashval->for_category_ids, true);
                $categoryMerg = array_merge(array_keys($categoryIds));
                $categoryMergee = array_merge(array_flatten($categoryIds));
                $categoryMerge = array_merge(array_keys($categoryIds), array_flatten($categoryIds));
                $where = ['rawQuery' => 'category_id IN(' . implode(",", $categoryMerge) . ')'];
                $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name'), DB::raw('GROUP_CONCAT(DISTINCT category_id) AS category_id')];
                $getcategory = $objProductCategory->getCategoryNameById($where, $selectedColumn);

                foreach ($getcategory as $catkey => $catval) {
                    $wholesaleInfo[$flashkey]->category = $catval->category_name;
                    $wholesaleInfo[$flashkey]->category_ids = $catval->category_id;
                }

                $whereProduct = ['rawQuery' => 'product_id IN(' . $flashval->for_product_ids . ')'];
                $selectedColumn = [DB::raw('GROUP_CONCAT(DISTINCT product_name) AS product_name'), DB::raw('GROUP_CONCAT(DISTINCT product_id) AS product_id')];

                $getproduct = $objProductModel->getProductNameById($whereProduct, $selectedColumn);

                foreach ($getproduct as $prodkey => $prodval) {
                    $wholesaleInfo[$flashkey]->product_name = $prodval->product_name;
                    $wholesaleInfo[$flashkey]->product_id = $prodval->product_id;
                }
            }

            $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?', 'bindParams' => [1, 0]];
            $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
            $allactivecategories = $objProductCategory->getAllCategoriesWhere($where, $selectedColumn);
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
            $where = ['rawQuery' => 'added_by = ? AND product_type = ?', 'bindParams' => [$added_by, 1]];
            $selectedColumn = ['product_id', 'product_name'];

            $allproducts = $objProductModel->getAllSupplierProducts($where, $selectedColumn);
            return view('Admin/Views/campaign/editWholesale', ['wholesaleDetails' => $wholesaleInfo[0], 'activeCategory' => $allactivecategories, 'allProducts' => $allproducts, 'allcategories' => $finalCatData]);
        } else {
            return view('Admin/Views/campaign/editWholesale');
        }

    }

}