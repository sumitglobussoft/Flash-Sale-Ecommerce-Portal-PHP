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
use FlashSale\Http\Modules\Admin\Models\Shops;
use FlashSale\Http\Modules\Admin\Models\Location;
use FlashSale\Http\Modules\Admin\Models\ShopMetadata;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use stdClass;
use Mandrill;
use Illuminate\Support\Facades\Hash;
use FlashSale\Http\Modules\Admin\Models\MailTemplate;




class ShopController extends Controller
{


    public function pendingShop(Request $request)
    {

//die("Test");
        return view('Admin/Views/shop/pendingShop');

    }

    public function availableShop(Request $request)
    {

//die("Test");
        return view('Admin/Views/shop/availableShop');

    }
    public function shopAjaxHandler(Request $request)
    {
        $inputData = $request->input();
        $field = $request->input('name');
        if ($field) {
            $formEditableMethod = explode('/', $field);
            $method = $formEditableMethod[0];
        } else {
            $method = $request->input('method');
        }
//        $method = $request->input('method');
        $ObjShop = Shops::getInstance();
        $objshopMetadataModal = ShopMetadata::getInstance();
        $mainId = Session::get('fs_admin')['id'];
        if ($method) {
            switch ($method) {
                case 'pendingShop':
                    $where = array('rawQuery' => 'shop_status = ?', 'bindParams' => [0]);
                    $pending_Shop = $ObjShop->getShopDetails($where);
                    return Datatables::of($pending_Shop)
                        ->addColumn('ownedBy', function ($shop_details) {
                            return ''. $shop_details->name .'&nbsp;'. $shop_details->last_name.'' ;
                        })
                        ->addColumn('status', function ($shop_details) {
                            return ' <td style = "text-align: center" >
                                            <button class="btn btn-primary shop-status"
                                                    data-id = ' . $shop_details->shop_id . ' >Pending
                                            </button >
                                    </td > ';
                        })
                        ->removeColumn('name')
                        ->removeColumn('last_name')
                        ->removeColumn('shop_status')
                        ->make();
                    break;
                case 'AvailableShop':
                    $where = array('rawQuery' => 'shop_status = ? || shop_status = ?', 'bindParams' => [1,2]);
                    $available_Shop = $ObjShop->getShopDetails($where);
//                    echo "<pre>"; print_r($available_Shop);die;
                    return Datatables::of($available_Shop)
                        ->addColumn('ownedBy', function ($shop_details) {
                            return ''. $shop_details->name .'&nbsp;'. $shop_details->last_name.'' ;
                        })
                        ->addColumn('action', function ($shop_details) {
                            $action = '<span class="tooltips" title="Edit Shop Details." data-placement="top"> <a href="/admin/edit-shop/' . $shop_details->shop_id . '" class="btn btn-sm grey-cascade " style="margin-left: 10%;">';
                            $action .= '<i class="fa fa-pencil-square-o"></i></a>';
                            $action .= '</span> &nbsp;&nbsp;';
                            $action .= '<span class="tooltips" title="Delete Shop" data-placement="top"> <a href="#" data-cid="' . $shop_details->shop_id . '" class="btn btn-danger delete-shop" style="margin-left: 10%;">';
                            $action .= '<i class="fa fa-trash-o"></i>';
                            $action .= '</a></span>';
                            return $action;

                        })
                        ->addColumn('status', function ($shop_details) use ($mainId) {

                            $button = '<td style="text-align: center">';
                            $button .= '<button class="btn ' . (($shop_details->shop_status == 1) ? "btn-success" : "btn-danger") . ' supplier-status" data-id="' . $shop_details->shop_id . '"  data-set-by="' . $mainId . '">' . (($shop_details->shop_status == 1) ? "Active" : "Inactive") . ' </button>';
                            $button .= '<td>';
                            return $button;

                        })
                        ->removeColumn('name')
                        ->removeColumn('last_name')
                        ->removeColumn('shop_status')
                        ->make();
                    break;
                case 'updateSellerShop':
                    $field = $request->input('name');
                    $fieldName = explode('/', $field);
                    $fieldName = $fieldName[1];

                    $shop_id = $request->input('pk');
                    $value = $request->input('value');

                    $data = array(
                        $fieldName => $value
                    );
                    $whereforShop = ['rawQuery' => 'shop_id =? ', 'bindParams' => [$shop_id]];
                    $updateResult = $ObjShop->updateShopWhere($data, $whereforShop);
                    if ($updateResult) {
                        echo json_encode($updateResult);
                    }

                    break;
                case 'updateStoreDetails':
                    $field = $request->input('name');

                    $field = explode('/', $field);
                    $fieldName = $field[1];
                    $store_metadata_id = $request->input('pk');
                    $value = $request->input('value');
                    $shopFlag = true;
                    $data = array(
                        $fieldName => $value
                    );
//                echo "<pre>";print_r($store_metadata_id);die;
                    if ($fieldName == 'shop_type' && $value == '0') {//change shop_type to main
                        $merchantId = $field[2];
                        $shopId = $field[3];
                        $whereforShop = ['rawQuery' => 'shop_id =?', 'bindParams' => [$shopId]];
                        $data1 = array(
                            'shop_type' => 1
                        );
                        $updateStoreType = $objshopMetadataModal->updateShopMetadataWhere($data1, $whereforShop);
                    }
                    if ($fieldName == 'shop_type' && $value == '1') {//change shop_type to secondary
                        $merchantId = $field[2];
                        $shopId = $field[3];
                        $whereforShop = ['rawQuery' => 'shop_id =? and shop_metadata_id != ?', 'bindParams' => [$shopId, $store_metadata_id]];
                        $merchantStoreDetails = $objshopMetadataModal->getAllshopsMetadataWhere($whereforShop);
                        if (!empty($merchantStoreDetails)) {
                            $dataforstype = array(//Make other shop main
                                'shop_type' => 0
                            );
                            $whereforShopt = ['rawQuery' => 'shop_id =? and shop_metadata_id = ?', 'bindParams' => [$merchantStoreDetails[0]->shop_id, $merchantStoreDetails[0]->shop_metadata_id]];
                            $merchantStoreDetails = $objshopMetadataModal->updateShopMetadataWhere($dataforstype, $whereforShopt);
                        } else {
                            $shopFlag = false;
                            echo json_encode("You cant change main shop to secondary");
                            break;
                        }

                    }
                    if ($shopFlag) {
                        $whereforShopMeta = ['rawQuery' => 'shop_metadata_id =?', 'bindParams' => [$store_metadata_id]];
                        $updateResult = $objshopMetadataModal->updateShopMetadataWhere($data, $whereforShopMeta);
                        if ($updateResult) {
                            echo json_encode($updateResult);
                        }
                    }
                    break;
                case 'updateShopBanner':
                    $shop_id = $request->input('shop_id');
                    $whereforShop = ['rawQuery' => 'shop_id =? ', 'bindParams' => [$shop_id]];
                    $selectedColumns = array('shop_id', 'shop_banner','user_id');
                    $shopDetails = $ObjShop->getAllshopsWhere($whereforShop, $selectedColumns);
                    if (isset($_FILES["shop_banner"]["name"]) && !empty($_FILES["shop_banner"]["name"])) {
                        $bannerFilePath = uploadImageToStoragePath(Input::file('shop_banner'), 'shopbanner', 'shopbanner_' . $shopDetails[0]['user_id'] . '_' . time() . ".jpg");
                    } else {
                        $bannerFilePath = uploadImageToStoragePath($_SERVER['DOCUMENT_ROOT'] . "/assets/images/no-image.png", 'shopbanner', 'shopbanner_' . $shopDetails[0]['user_id'] . '_' . time() . ".jpg");
                    }
                    $shopdata = array(
                        'shop_banner' => $bannerFilePath
                    );
                    $updateBanner = $ObjShop->updateShopWhere($shopdata, $whereforShop);
                    if ($updateBanner) {
                        deleteImageFromStoragePath($shopDetails[0]->shop_banner);
                        echo json_encode($updateBanner);
                    }
                    break;
                case 'updateShopLogo':
                    $shop_id = $request->input('shop_id');
                    $whereforShop = ['rawQuery' => 'shop_id =? ', 'bindParams' => [$shop_id]];
                    $selectedColumns = array('shop_id', 'shop_logo');
                    $shopDetails = $ObjShop->getAllshopsWhere($whereforShop, $selectedColumns);
                    if (isset($_FILES["shop_logo"]["name"]) && !empty($_FILES["shop_logo"]["name"])) {
                        $logoFilePath = uploadImageToStoragePath(Input::file('shop_logo'), 'shoplogo', 'shoplogo_' . $userId . '_' . time() . ".jpg");
                    } else {
                        $logoFilePath = uploadImageToStoragePath($_SERVER['DOCUMENT_ROOT'] . "/assets/images/no-image.png", 'shoplogo', 'shoplogo_' . $userId . '_' . time() . ".jpg");
                    }
                    $shopdata = array(
                        'shop_logo' => $logoFilePath
                    );
                    $updatelogo = $ObjShop->updateShopWhere($shopdata, $whereforShop);
                    if ($updatelogo) {
                        deleteImageFromStoragePath($shopDetails[0]->shop_logo);
                        echo json_encode($updatelogo);
                    }
                    break;
                case 'updateShopStatus':
                    $shopMetaId = $request->input('shopMetaId');
                    $status = $request->input('value');
                    $supplierId = $request->input('supplierId');
                    $data = array(
                        'sm_status_set_by' => $supplierId,
                        'shop_metadata_status' => $status
                    );
                    $whereforShopMeta = ['rawQuery' => 'shop_metadata_id =? ', 'bindParams' => [$shopMetaId]];
                    $updateResult = $objshopMetadataModal->updateShopMetadataWhere($data, $whereforShopMeta);
                    if ($updateResult) {
                        echo json_encode($updateResult);
                    }

                    break;
                case 'changeShopStatus':
                    $Shop_Id = $request->input('ShopId');
                    $Status = $request->input('status');
                    $data1['shop_status'] = $Status;
                    $where1 = ['rawQuery' => 'shop_id =? ', 'bindParams' => [$Shop_Id]];
                    $updateResult = $ObjShop->updateShopWhere($data1, $where1);
                    if ($updateResult) {
                        echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                    }
                    break;
            }
        }
    }

    public function editShop(Request $request, $shopid)
    {
//        echo $shop_id; die;
//        $supplierId = Session::get('fs_supplier')['id'];

        if (is_numeric($shopid)) {
            $objSupplierStore = Shops::getInstance();
            $objSupplierStoreMetaData = ShopMetadata::getInstance();
            $objLocationModel = Location::getInstance();
            $whereforShop = ['rawQuery' => 'shop_id = ?', 'bindParams' => [$shopid]];
            $SupplierShopDetails = $objSupplierStore->getAllshopsWhere($whereforShop);
//            echo "<pre>";print_r($SupplierShopDetails);die;
            if ($SupplierShopDetails) {

                $shopId = $SupplierShopDetails[0]->shop_id;
                $supplierId = $SupplierShopDetails[0]->user_id;
                $whereforShopMeta = ['rawQuery' => 'shop_id =?', 'bindParams' => [$shopId]];
                $ShopMetaData = $objSupplierStoreMetaData->getAllshopsMetadataWhere($whereforShopMeta);
//                echo "<pre>";print_r($ShopMetaData);die;
                $whereforcountry = ['rawQuery' => 'is_visible =? and location_type =? ', 'bindParams' => [0, 0]];
                $allcountry = $objLocationModel->getAllLocationsWhere($whereforcountry);
//                echo "<pre>";print_r($allcountry);die;
                $whereforstate = ['rawQuery' => 'is_visible =? and location_type =? ', 'bindParams' => [0, 1]];
                $allstates = $objLocationModel->getAllLocationsWhere($whereforstate);

                $whereforcity = ['rawQuery' => 'is_visible =? and location_type =? ', 'bindParams' => [0, 2]];
                $allcities = $objLocationModel->getAllLocationsWhere($whereforcity);
//                $this->view->storeMetaData = $storeMetaData;
                $SupplierData['supplierId'] = $supplierId;
                $SupplierData['SupplierShopDetails'] = $SupplierShopDetails[0];
                $SupplierData['ShopMetaData'] = $ShopMetaData;
                $SupplierData['country'] = $allcountry;
                $SupplierData['state'] = $allstates;
                $SupplierData['city'] = $allcities;
//                echo "<pre>";print_r($SupplierData);die;

//                $reviews = $objReview->getStoreReviews($shopId);
                $reviews = "";
//                $this->view->reviews = $reviews;
                $r1 = $r2 = $r3 = $r4 = $r5 = 0;
                $rating = array($r5, $r4, $r3, $r2, $r1);
                $total = 0;
                $overAllRating = 0;
                if ($reviews != '') {
                    foreach ($reviews as $key => $value) {
                        if ($value['review_rating'] == 1)
                            $r1++;
                        elseif ($value['review_rating'] == 2)
                            $r2++;
                        elseif ($value['review_rating'] == 3)
                            $r3++;
                        elseif ($value['review_rating'] == 4)
                            $r4++;
                        elseif ($value['review_rating'] == 5)
                            $r5++;
                    }

                    $rating = array($r5, $r4, $r3, $r2, $r1);
                    $total = $r1 + $r2 + $r3 + $r4 + $r5;
                    $overAllRating = (1 * $r1 + 2 * $r2 + 3 * $r3 + 4 * $r4 + 5 * $r5) / $total;
                    $overAllRating = round($overAllRating, 1);
                }
                $reviewData['rating'] = $rating;
                $reviewData['total'] = $total;
                $reviewData['overAllRating'] = $overAllRating;

            } else {
//                $this->view->ErrorMsg = "Page you are looking for does not exist";
            }
            return view("Admin/Views/shop/editShop", ['shopData' => $SupplierData], ['reviewData' => $reviewData]);
        } else {
//            $this->view->ErrorMsg = "Page you are looking for does not exist";
        }
        return view("Admin/Views/shop/editShop");
    }

}
?>