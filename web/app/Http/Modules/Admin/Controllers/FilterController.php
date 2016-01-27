<?php
namespace FlashSale\Http\Modules\Admin\Controllers;

use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use PDO;
use Input;
use FlashSale\Http\Modules\Admin\Models\ProductFilterGroup;
use FlashSale\Http\Modules\Admin\Models\ProductFilterOption;
use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use FlashSale\Http\Modules\Admin\Models\ProductFeatures;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class FilterController extends Controller
{

    public function pendingProducts()
    {
        $objProductModel = Product::getInstance();
        $pendingProducts = $objProductModel->getAllProductsWhereStatus('0');
        return view('Admin/Views/product/pending-produtcs', ['pendingProducts' => $pendingProducts]);


    }


    public function addNewFiltergroup(Request $request)
    {

        $ObjProductFilterOption = ProductFilterOption::getInstance();
        $ObjProductCategories = ProductCategory::getInstance();
        $ObjProjectFilterFeatureGroup = ProductFeatures::getInstance();
        $userId = Session::get('fs_admin')['id'];
        if ($request->isMethod('GET')) {
            $where = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
            $allCategories = $ObjProductCategories->getAllCategoriesWhere($where);

            foreach ($allCategories as $key => $value) {
                $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
            }

            $whereFeature = ['rawQuery' => 'status=?', 'bindParams' => [1], 'rawQuery' => 'parent_id=?', 'bindParams' => [0]];
            $allFeatures = $ObjProjectFilterFeatureGroup->getAllFeatureWhere($whereFeature);

            return view('Admin/Views/filter/add-new-filtergroup', ['categories' => $allCategories, 'features' => $allFeatures]);
        }
        if ($request->isMethod('post')) {

            $rulesAddFilter = [
                'productfiltergroupname' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:255',
                'filterdescription' => 'required|max:255',
                'productfiltergroupfeature' => 'required',
                'productcategories' => 'required',
            ];

            $messagesAddFeature = ['productfiltergroupname.required' => 'Please enter a name',
                'productfiltergroupname.regex' => 'Name can contain alphanumeric characters and spaces only',
                'productfiltergroupname.max' => 'Name is too long to use. 255 characters max.',
                'filterdescription.max' => 'Description should not exceed 255 characters',
                'productfiltergroupfeature.required' => 'Please select a feature type',
                'productcategories.required' => 'Please select atleast one category'
            ];

            $validator = Validator::make($request->all(), $rulesAddFilter, $messagesAddFeature);
            if ($validator->fails()) {
                return redirect('/admin/add-new-filtergroup')
                    ->withErrors($validator)
                    ->withInput();
            }


            $data['product_filter_option_name'] = $request->input('productfiltergroupname');
            $data['product_filter_option_description'] = $request->input('filterdescription');
            $data['product_filter_feature_id'] = $request->input('productfiltergroupfeature');

            $filter = explode("-", $data['product_filter_feature_id']);
            if ($filter >= 3 - 0) {
                $data['product_filter_feature_id'] = $filter[0];
                $data['product_filter_parent_product_id'] = $filter[1];
            } else {
                $data['product_filter_parent_product_id'] = $filter[0];
                $data['product_filter_feature_id'] = $filter[1];
            }
//            $checkforproduct = $request->input('filtercheckproduct');
//            if ($checkforproduct == "on") {
//                $data['display_on_product'] = 1;
//            } else {
//                $data['display_on_product'] = 0;
//            }
//            $checkforcatalog = $request->input('filtercheckcatalog');
//            if ($checkforcatalog == "on") {
//                $data['display_on_catalog'] = 1;
//            } else {
//                $data['display_on_catalog'] = 0;
//            }
//            $cat = $request->input('productcategories');

            $cat = $request->input('productcategories');
            foreach ($cat as $catkey => $catval) {
                $category[$catkey] = $catkey;
            }

            $categoryIds = implode(',', $category);
            $data['product_filter_category_id'] = $categoryIds;
            $data['added_by'] = $userId;
            $wherefiltercategaory = array('rawQuery' => 'product_filter_option_name', 'bindParams' => $data['product_filter_option_name']);
            $result = $ObjProductFilterOption->getProductFilterOptionWhere($wherefiltercategaory);
//            echo"<pre>";print_r($result);die("Xf");

            if ($result == '') {
                $addnew = $ObjProductFilterOption->addProductfilterWhere($data);
                if ($addnew) {
                    $success = "Product Filter Added Successfully..";
                    return Redirect::back()->with('errmsg', $success);
//                    $filterGroupName = $request->input('filter');
//                    $filterGroupDescription = $request->input('productfilterdescription');
//                    $filterGroupStatus = $request->input('productfiltergrouptatus');
//                    $addedData = '';
//                    $notAddedData = '';
//                    foreach ($filterGroupName as $keyfilterGroupName => $valuefilterGroupName) {
//                        if ($valuefilterGroupName != '') {
//                            $duplicateTagFlag = false;
//                            //   $wherefilteroption = "product_filter_option_name = '" . $valuefilterGroupName . "'";
//                            $result1 = '';
//                            $result1 = $ObjProductFilterOption->getProductFilterOptionWhere($valuefilterGroupName);
//                            if (empty($result1) != 1) {
//                                if ($notAddedData != '') {
//                                    $notAddedData .= ", <b>" . $valuefilterGroupName . "</b>";
//                                } else {
//                                    $notAddedData .= "<b>" . $valuefilterGroupName . "</b>";
//                                }
//                                $duplicateTagFlag = true;
//                            } else {
//                                if ($addedData != '') {
//                                    $addedData .= ", <b>" . $valuefilterGroupName . "</b>";
//                                } else {
//                                    $addedData .= "<b>" . $valuefilterGroupName . "</b>";
//                                }
//                            }
//                            if (!$duplicateTagFlag) {
//                                $dataOption = array('product_filter_option_name' => $valuefilterGroupName, 'product_filter_option_description' => $filterGroupDescription[$keyfilterGroupName], 'product_filter_category_id' => $addnew, 'product_filter_group_id' => $addnew, 'added_by' => $userId, 'added_date' => time(), 'product_filter_option_status' => $filterGroupStatus[$keyfilterGroupName]);
//                                $ObjProductFilterOption->addNewFilterOption($dataOption);
//                            }
//                        }
//                    }
//                    $infoMsg = '';
//                    if ($addedData != '') {
//                        $success = "'" . $addedData . "' filter option were added. ";
//                        return Redirect::back()->with('errmsg', $success);
//                    }
//                    if ($notAddedData != '') {
//                        $success = "'" . $notAddedData . "' filter option were already present and not added. ";
//                        return Redirect::back()->with('errmsg', $success);
//                    }

//                    $infoMsg = $infoMsg;
//                    return Redirect::back()->with('infoMsg', $infoMsg);
//                    $success = "New filter group '" . $data['product_filter_option_name'] . "' added successfully.";;
//                    return Redirect::back()->with('errmsg', $success);
                } else {
                    $success = "Something went wrong. Please try again later..";
                    return Redirect::back()->with('errmsg', $success);
                }

            } else {
                $success = "Specific filter group already exists.";
                return Redirect::back()->with('errmsg', $success);

            }
            $data = '';
        }

        return view('Admin/Views/filter/add-new-filtergroup');

    }

    public function manageFilterGroup(Request $request)
    {

        $ObjProductFilterOption = ProductFilterOption::getInstance();
        $ObjProductCategory = ProductCategory::getInstance();

        $getAllFilterGroup = $ObjProductFilterOption->getAllFilterGroup();
        foreach ($getAllFilterGroup as $filtergroupkey => $filtergroupvalue) {
            $getAllFilterGroup[$filtergroupkey]->filtergroup = array();
            if ($filtergroupvalue->product_filter_category_id != '') {
                $catfilterName = array_values(array_unique(explode(',', $filtergroupvalue->product_filter_category_id)));
                $getcategory = $ObjProductCategory->getCategoryInfoById($catfilterName);

                foreach ($getcategory as $catkey => $catval) {
                    $getAllFilterGroup[$filtergroupkey]->filtergroup = $catval;
                }
            }
        }
        return view('Admin/Views/filter/manage-filtergroup', ['filtergroupdetail' => $getAllFilterGroup]);

    }

    public function editFilterGroup(Request $request, $id)
    {
        $postdata = $request->all();
        $ObjProductFeatures = ProductFeatures::getInstance();
        $ObjProductCategory = ProductCategory::getInstance();
        $ObjProductFilterOption = ProductFilterOption::getInstance();
        if ($request->isMethod('GET')) {
            $where = array('rawQuery' => 'category_status = ?', 'bindParams' => [1]);
            $allCategories = $ObjProductCategory->getAllCategoriesWhere($where);
            foreach ($allCategories as $key => $value) {
                $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
            }
            $whereId = array('rawQuery' => 'product_filter_option_id=?', 'bindParams' => [$id]);
            $FilterGroup = $ObjProductFilterOption->getFilterDetailsById($whereId);

            $catfilterName = array_values(array_unique(explode(',', $FilterGroup[0]->product_filter_category_id)));
            $category = $ObjProductCategory->getCategoryById($catfilterName);

            foreach ($category as $key => $val) {
                $filtecat[$key] = $val->category_id;
            }
            $whereFeature = array('rawQuery' => 'status = ?', 'bindParams' => [1], 'rawQuery' => 'parent_id=?', 'bindParams' => [0]);
            $allFeatures = $ObjProductFeatures->getAllFeaturesWhere($whereFeature);
            return view('Admin/Views/filter/edit-filtergroup', ['editfiltergroup' => $FilterGroup[0], 'selectedcategory' => $filtecat, 'categories' => $allCategories, 'features' => $allFeatures]);
        } elseif ($request->isMethod('POST')) {
            $data['product_filter_option_name'] = $postdata['productfiltergroupname'];
            $data['product_filter_option_description'] = $postdata['filterdescription'];
            $data['product_filter_category_id'] = $postdata['productcategories'];

            // $data['status'] = $postdata['productfiltergroupnamestatus'];
            // need to work //
//            $checkforproduct = $postdata['filtercheckproduct'];
//
//            if ($checkforproduct == "on") {
//                $data['display_on_product'] = 1;
//            } else {
//                $data['display_on_product'] = 0;
//            }
//            $checkforproduct = '';
//            $checkforcatalog = $postdata['filtercheckcatalog'];
//            if ($checkforcatalog == "on") {
//                $data['display_on_catalog'] = 1;
//            } else {
//                $data['display_on_catalog'] = 0;
//            }
//            $checkforcatalog = '';
            // end //
            $temp = array();
            $cat = $postdata['productcategories'];
            foreach ($cat as $catkey => $catval) {
                $category[$catkey] = $catkey;
            }


//            $FilterGroup = $ObjProductCategory->getCategoryInfoById($category);
            $where = ['rawQuery' => 'product_filter_option_id = ?', 'bindParams' => [$id]];
            $FilterGroup = $ObjProductFilterOption->getFilterDetailsById($where);

            $catdata = $FilterGroup[0]->product_filter_category_id;
            $cata = explode(",", $catdata);
            $categoryIds = implode(',', $category);
            array_push($cata, $categoryIds);
            $catmain = implode(",", $cata);

            $data['product_filter_category_id'] = $catmain;

            $result = $ObjProductFilterOption->updateFilterOption($where, $data);
        }
        if ($result) {
            $success = "Successfully Edited!";
            return Redirect::back()->with('message', $success);
        } else {
            $success = "Error!";
            return Redirect::back()->with('message', $success);
        }

    }

    public function filterAjaxHandler(Request $request)
    {

        $method = $request->input('method');
        $ObjProductFilterOption = ProductFilterOption::getInstance();
        if ($method != "") {
            switch ($method) {
                case 'changefeatureStatus':
                    $featureId = $request->input('featureId');
                    $wherefeatureId = ['rawQuery' => 'product_filter_option_id =?', 'bindParams' => [$featureId]];
                    $featuretatus = $request->input('featuretatus');
                    $data['product_filter_option_status'] = $featuretatus;
                    $featureUpdate = $ObjProductFilterOption->updateFilterOption($wherefeatureId, $data);
                    $featuredata['status'] = $featuretatus;
                    $featuredata['update'] = $featureUpdate;
                    echo json_encode($featuredata);
                    break;
                case 'deletefilteroption':
                    $filterId = $request->input('filterId');
                    $where = array('rawQuery' => 'product_filter_option_id=?', 'bindParams' => [$filterId]);
                    $deletefilter = $ObjProductFilterOption->deletefilteroption($where);
                    echo json_encode($deletefilter);
                    break;
//                case 'manageFilterGroup':
//                    $ObjProductFilterOption = ProductFilterOption::getInstance();
//                    $ObjProductCategory = ProductCategory::getInstance();
//
//                    $getAllFilterGroup = $ObjProductFilterOption->getAllFilterGroup();
//                    foreach ($getAllFilterGroup as $filtergroupkey => $filtergroupvalue) {
//                        $getAllFilterGroup[$filtergroupkey]->filtergroup = array();
//                        if ($filtergroupvalue->product_filter_category_id != '') {
//                            $catfilterName = array_values(array_unique(explode(',', $filtergroupvalue->product_filter_category_id)));
//                            $getcategory = $ObjProductCategory->getCategoryInfoById($catfilterName);
//
//                            foreach ($getcategory as $catkey => $catval) {
//                                $getAllFilterGroup[$filtergroupkey]->filtergroup = $catval;
//                            }
//                        }
//                    }

//                    break;
                default:
                    break;

            }
        }
    }

    /**
     * To get string for tree view of categories (Ex.|--|--)
     * Used for tree view of category
     * @param $id Category id, for which we want to generate string
     * @return string
     * @throws Exception
     * @since 21-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function getCategoryDisplayName($id)
    {
        if ($id == 0) {
            return '';
        } else {
            $objCategoryModel = ProductCategory::getInstance();
            $where = ['rawQuery' => 'category_id = ?', 'bindParams' => [$id]];
            $parentCategory = $objCategoryModel->getCategoryDetailsWhere($where);
            if ($parentCategory->parent_category_id != 0) {
                return $this->getCategoryDisplayName($parentCategory->parent_category_id);// . '&brvbar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                return '';
            }
        }
    }

}
