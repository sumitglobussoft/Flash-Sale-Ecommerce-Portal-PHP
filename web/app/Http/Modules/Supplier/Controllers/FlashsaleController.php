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

class FlashsaleController extends Controller
{


    public function addFlashsale(Request $request)
    {

        $objProductCategory = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];

        if ($request->isMethod('post')) {
            $rules = array(
                'campaign_name' => 'required|unique:campaigns',
                'discounttype' => 'required',
                'flatdiscount' => 'required|min:1|numeric',
                'percentagediscount' => 'required|min:1|numeric',
                'availablefromdate' => 'required',
//                'availableuptodate' => 'required',
                'availableuptodate' => 'required|after:availablefromdate',
                'flashsale_image' => 'image|required',
                'productcategories' => 'required'

            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }


            if (Input::hasFile('flashsale_image')) {
                $filePath = uploadImageToStoragePath(Input::file('flashsale_image'), 'flashsale', 'flashsale_' . $supplierId . '_' . time() . ".jpg");
                $data['campaign_banner'] = $filePath;
            }

            $postData = $request->all();
            $cfh = $request->input('campaign_name');
            $data['campaign_name'] = $postData['campaign_name'];
            $data['for_shop_id'] = $postData['suppliershop'];
            $data['campaign_type'] = '2';
            $data['discount_type'] = $postData['discounttype'];
            if ($data['discount_type'] == '1') {
                $data['discount_value'] = $postData['flatdiscount'];
            } else {
                $data['discount_value'] = $postData['percentagediscount'];
            }

            $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
            $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
            $data['available_from'] = $validFrom;
            $data['available_upto'] = $validTo;
            $categ = $postData['productcategories'];
            $data['for_category_ids'] = implode(",", $categ);
            $data['by_user_id'] = $supplierId;

            $campaign = $objCampaignModel->addFlashsale($data);
            if ($campaign) {
                return Redirect::back()->with(['status' => 'success', 'msg' => 'FlashSale Added Successfully.']);
            } else {
                return Redirect::back()->with(['status' => 'error', 'msg' => 'Some Error try again.']);
            }
        }
        return view("Supplier/Views/flashsale/addFlashsale");
        // TO DO //
        //  Add notification to admin/manager for flashsale approval from supplier end.//

    }


    public function flashsaleAjaxHandler(Request $request)
    {

        $inputData = $request->input();
        $method = $inputData['method'];
        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        switch ($method) {
            case 'getActiveCategories':
                $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?', 'bindParams' => [1, 0]];
                $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
                $allactivecategories = $objCategoryModel->getAllMainCategories($where, $selectedColumn);
                if (!empty($allactivecategories)) {
                    echo json_encode($allactivecategories);
                } else {
                    echo 0;
                }
                break;
            case 'manageFlashsale':
                $where = ['rawQuery' => 'campaign_type = ?', 'bindParams' => [2]];
                $selectedColumn = ['campaigns.*','users.username'];
                $flashsaleInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
                foreach ($flashsaleInfo as $flashkey => $flashval) {
                    $categoryIds = $flashval->for_category_ids;
                    $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
                    $getcategory = $objCategoryModel->getCategoryNameById($where);
                    foreach ($getcategory as $catkey => $catval) {
                        $flashsaleInfo[$flashkey]->category = $catval->category_name;
                    }
                }
                $flash = json_decode(json_encode($flashsaleInfo), true);
//                echo'<pre>';print_r($flash);die("df");
                $flashDetail = new Collection();
                foreach ($flash as $mainflashkey => $mainflashval) {
                    $flashDetail->push([
                        'campaign_id' => $mainflashval['campaign_id'],
                        'campaign_name' => $mainflashval['campaign_name'],
                        'username' => $mainflashval['username'],
                        'discount_type' => ($mainflashval['discount_type'] == 1) ? 'Flatdiscount' : 'PercentageDiscount',
                        'discount_value' => $mainflashval['discount_value'],
                        'available_from' => date('d F Y - h:i A', $mainflashval['available_from']),
                        'available_upto' => date('d F Y - h:i A', $mainflashval['available_upto']),
                        'category' => $mainflashval['category'],
                        'campaign_status' => $mainflashval['campaign_status'],
                        'action' => '',
                        'supplierId' => Session::get('fs_supplier')['id']

                    ]);
                }
//                echo'<pre>';print_r($flashDetail);die("xcfgb");
                return Datatables::of($flashDetail)
                    ->addColumn('action', function ($flashDetail) {
                        return '<span class="tooltips" title="Edit Flashsale Details." data-placement="top"> <a href="/supplier/edit-flashsale/' . $flashDetail['campaign_id'] . '" class="btn btn-sm grey-cascade" style="margin-left: 10%;">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </a>
                                            </span>
                                            <span class="tooltips" title="Delete Flashsale Details." data-placement="top"> <a href="#" data-cid="' . $flashDetail['campaign_id'] . '" class="btn btn-danger delete-flashsale" style="margin-left: 10%;">
                                                    <i class="fa fa-trash-o"></i>
                                                </a>
                                            </span>';
                    })
                    ->addColumn('campaign_status', function ($flashDetail) {
                        $button = '<td style="text-align: center">';
                        $button .= '<button class="btn ' . (($flashDetail['campaign_status'] == 1) ? "btn-success" : "btn-danger") . ' flashsale-status" data-id="' . $flashDetail['campaign_id'] . '" data-set-by="' . $flashDetail['supplierId'] . '">' . (($flashDetail['campaign_status'] == 1) ? 'Active' : 'Inactive') . ' </button>';
                        $button .= '</td>';
                        return $button;
                    })
                    ->removeColumn('for_shop_id')
                    ->removeColumn('for_product_ids')
                    ->removeColumn('for_product_ids')
                    ->removeColumn('campaign_banner')
                    ->make();
                break;
            case 'changeFlashsaleStatus':
                $campaignId = $inputData['campaignId'];
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaignId]];
                $dataToUpdate['campaign_status'] = $inputData['status'];
                $dataToUpdate['status_set_by'] = $inputData['userId'];
                $updateResult = $objCampaignModel->updateFlashsaleStatus($dataToUpdate, $where);

                if ($updateResult == 1) {
                    echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
                break;
            case 'deleteFlashsale':
                $campaignId = $inputData['campaignId'];
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$campaignId]];
                $deleteStatus = $objCampaignModel->deleteFlashsale($where);
                if ($deleteStatus) {
                    echo json_encode(['status' => 'success', 'msg' => 'User Deleted']);
                } else {
                    echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
                break;
            default:
                break;
        }
    }

    public function manageFlashsale(Request $request)
    {

        return view('Supplier/Views/flashsale/manageFlashsale');

    }

    public function editFlashsale(Request $request, $fid)
    {

        $objCategoryModel = ProductCategory::getInstance();
        $objCampaignModel = Campaigns::getInstance();
        $postData = $request->all();
        $supplierId = Session::get('fs_supplier')['id'];

        if ($request->isMethod('POST')) {
            $rules = array(
                'campaign_name' => 'unique:campaigns,campaign_name,' . $fid . ',campaign_id',
//                'availablefromdate' => 'after:'.strtotime("-30 minutes"),
//                'availablefromdate' => 'after:tomorrow',
//                'availableuptodate' => 'after:availablefromdate',
                'flashsale_image' => 'image'

            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {

                if (Input::hasFile('flashsale_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('flashsale_image'), 'flashsale', 'flashsale_' . $supplierId . '_' . time() . ".jpg");
                    $data['campaign_banner'] = $filePath;

                }
                $postData = $request->all();
                $data['campaign_name'] = $postData['campaign_name'];

                $data['for_shop_id'] = $postData['suppliershop'];
                $data['discount_type'] = $postData['discounttype'];
                if ($postData['discounttype'] == 1) {
                    $data['discount_value'] = $postData['flatdiscount'];
                } else {
                    $data['discount_value'] = $postData['percentagediscount'];
                }

                $validFrom = strtotime(str_replace("-", "", $postData['availablefromdate']));
                $validTo = strtotime(str_replace("-", "", $postData['availableuptodate']));
                $data['available_from'] = $validFrom;
                $data['available_upto'] = $validTo;
                $categ = $postData['productcategories'];
                $data['for_category_ids'] = implode(",", $categ);
                $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$fid]];
                $campaignUpdate = $objCampaignModel->updateFlashsaleStatus($data, $where);
                if ($campaignUpdate) {
                    if (isset($filePath))
                        deleteImageFromStoragePath($postData['oldImage']);
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'FlashSale Added Successfully.']);
                } else {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Some Error try again.']);
                }
            }
        }
        $where = ['rawQuery' => 'campaign_id = ?', 'bindParams' => [$fid]];
        $selectedColumn = ['campaigns.*', 'users.username'];
        $flashsaleInfo = $objCampaignModel->getAllFlashsaleDetails($where, $selectedColumn);
        if (isset($flashsaleInfo) && (!empty($flashsaleInfo))) {
            foreach ($flashsaleInfo as $flashkey => $flashval) {
                $categoryIds = $flashval->for_category_ids;
                $where = ['rawQuery' => 'category_id IN(' . $categoryIds . ')'];
                $getcategory = $objCategoryModel->getCategoryNameById($where);
                foreach ($getcategory as $catkey => $catval) {
                    $flashsaleInfo[$flashkey]->category = $catval->category_name;
                }
            }
//            echo'<pre>';print_r($flashsaleInfo);die("dxv");

            $where = ['rawQuery' => 'category_status = ? AND parent_category_id = ?', 'bindParams' => [1, 0]];
            $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
            $allactivecategories = $objCategoryModel->getAllMainCategories($where, $selectedColumn);
            return view('Supplier/Views/flashsale/editFlashsale', ['flashsaleDetails' => $flashsaleInfo[0], 'activeflashsale' => $allactivecategories]);

        } else {
            return view('Supplier/Views/flashsale/editFlashsale');
        }
    }


}