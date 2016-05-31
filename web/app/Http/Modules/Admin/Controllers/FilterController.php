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


    /**
     * Add New Filter Group Action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
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

            $whereFilters = ['rawQuery' => 'product_filter_type=?', 'bindParams' => ['G']];
            $allGroupFilters = $ObjProductFilterOption->getProductFilterOptionWhere($whereFilters);

            return view('Admin/Views/filter/add-new-filtergroup', ['categories' => $allCategories, 'features' => $allFeatures, 'allGroupFilter' => $allGroupFilters]);
        }
        if ($request->isMethod('post')) {
            $variantFilterInputData = $request->input('filter_variant');
            $filedNames = array_keys($variantFilterInputData[0]);

            $rulesAddFilter = [
                'productfiltertype' => 'required',
                'productfiltergroupname' => 'required_if:productfiltertype,G|regex:/(^[A-Za-z0-9 ]+$)+/|max:255|unique:product_filter_option,product_filter_option_name',
                'filterdescription' => 'required_if:productfiltertype,G|max:255',
                'productfiltergroupfeature' => 'required_if:productfiltertype,G',
                'productcategories' => 'required_if:productfiltertype,G',
                'filter_variant_type' => 'required'
            ];

            $messagesAddFeature = ['productfiltertype' => 'Please select atleast on filter type',
                'productfiltergroupname.required_if' => 'Please enter a name',
                'productfiltergroupname.regex' => 'Name can contain alphanumeric characters and spaces only',
                'productfiltergroupname.max' => 'Name is too long to use. 255 characters max.',
                'filterdescription.max' => 'Description should not exceed 255 characters',
                'filterdescription.required_if' => 'Filter description is required',
                'productfiltergroupfeature.required_if' => 'Please select a feature type',
                'productcategories.required_if' => 'Please select atleast one category',
                'filter_variant_type' => 'Filter variant type is required'
            ];

            $newdata = [];
            foreach ($filedNames as $varinatKey => $fileVal) {
                foreach ($variantFilterInputData as $VKey => $filedName) {
                    $rulesAddFilter['filter_variant' . '.' . $VKey . '.' . $fileVal] = 'required_if:productfiltertype,V|unique:product_filter_option,product_filter_option_name';
                    $rulesAddFilter['filter_variant' . '.' . $VKey . '.' . $fileVal] = 'required_if:productfiltertype,V';
                    $rulesAddFilter['productFilterGroupType'] = 'required_if:productfiltertype,V';
                    $messagesAddFeature['filter_variant' . '.' . $VKey . '.' . $fileVal . '.required_if'] = 'Please select filter variant';
                    $messagesAddFeature['filter_variant' . '.' . $VKey . '.' . $fileVal . '.required_if'] = 'Please select filter variant description';
                    $messagesAddFeature['productFilterGroupType required_if'] = 'Please select filter group';
                }
            }

            $inputData = $request->all();
            $finalDataToInsert = array_map(function ($values) use ($inputData, $userId) {
                $temp['product_filter_option_name'] = $values['name'];
                $temp['product_filter_option_description'] = $values['description'];
                $temp['product_filter_type'] = $inputData['productfiltertype'];
                $temp['product_filter_group_id'] = $inputData['productFilterGroupType'];
                $temp['added_by'] = $userId;

                return $temp;

            }, $variantFilterInputData);

            $newdata = $finalDataToInsert;

            $validator = Validator::make($request->all(), $rulesAddFilter, $messagesAddFeature);
            if ($validator->fails()) {
                return redirect('/admin/add-new-filtergroup')
                    ->withErrors($validator)
                    ->withInput();
            }

            if ($request->input('productfiltertype') == 'G') {
                $data['product_filter_option_name'] = $request->input('productfiltergroupname');
                $data['product_filter_option_description'] = $request->input('filterdescription');
                $data['product_filter_feature_id'] = $request->input('productfiltergroupfeature');
                $data['product_filter_type'] = $request->input('productfiltertype');
                $data['product_filter_variant_type'] = $request->input('filter_variant_type');
                $filter = explode("-", $data['product_filter_feature_id']);
                if ($filter >= 3 - 0) {
                    $data['product_filter_feature_id'] = $filter[0];
                    $data['product_filter_parent_product_id'] = $filter[1];
                } else {
                    $data['product_filter_parent_product_id'] = $filter[0];
                    $data['product_filter_feature_id'] = $filter[1];
                }
                $cat = $request->input('productcategories');
                foreach ($cat as $catkey => $catval) {
                    $category[$catkey] = $catkey;
                }
                $categoryIds = implode(',', $category);
                $data['product_filter_category_id'] = $categoryIds;
                $data['added_by'] = $userId;
                $data['created_at'] = NULL;

            }

            if ($request->input('productfiltertype') == 'G') {
                $finalData = $data;
            } else {
                $finalData = $newdata;
            }
            $addnew = $ObjProductFilterOption->addProductfilterWhere($finalData);

            if ($addnew) {
                $success = "Product Filter Added Successfully..";
                return Redirect::back()->with(['status' => 'success', 'msg' => $success]);
            } else {
                $success = "Something went wrong. Please try again later..";
                return Redirect::back()->with(['status' => 'error', 'msg' => $success]);
            }
            $data = '';
        }

        return view('Admin/Views/filter/add-new-filtergroup');

    }

    /**
     * Manage Filter Group Action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
    public function manageFilterGroup(Request $request)
    {

        $ObjProductFilterOption = ProductFilterOption::getInstance();
        $ObjProductCategory = ProductCategory::getInstance();
        $whereRaw = ['rawQuery' => 'product_filter_type = ?', 'bindParams' => ['G']];
        $getAllFilterGroup = $ObjProductFilterOption->getProductFilterOptionWhere($whereRaw);
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

    /**
     * Edit Filter Group Action
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
    public function editFilterGroup(Request $request, $id)
    {

        $postdata = $request->all();
        $ObjProductFeatures = ProductFeatures::getInstance();
        $ObjProductCategory = ProductCategory::getInstance();
        $ObjProductFilterOption = ProductFilterOption::getInstance();
        $userId = Session::get('fs_admin')['id'];
        if ($request->isMethod('POST')) {
            $inputData = $request->all();
            $variantFilterInputData = $request->input('filter_variant');
            $filedNames = array_diff(array_keys($variantFilterInputData[0]), ['product_filter_option_id']);
            $rulesAddFilter = [
                'productfiltergroupname' => 'required_if:productfiltertype,G|regex:/(^[A-Za-z0-9 ]+$)+/|max:255|unique:product_filter_option,product_filter_option_name,' . $id . ',product_filter_option_id',
                'filterdescription' => 'required_if:productfiltertype,G|max:255',
                'productcategories' => 'required_if:productfiltertype,G',
            ];

            $messagesAddFeature = [
                'productfiltergroupname.required_if' => 'Please enter a name',
                'productfiltergroupname.regex' => 'Name can contain alphanumeric characters and spaces only',
                'productfiltergroupname.max' => 'Name is too long to use. 255 characters max.',
                'filterdescription.max' => 'Description should not exceed 255 characters',
                'filterdescription.required_if' => 'Filter description is required',
                'productcategories.required_if' => 'Please select atleast one category',
            ];

            $newdata = [];
            foreach ($filedNames as $varinatKey => $fileVal) {
                foreach ($variantFilterInputData as $VKey => $filedName) {
                    $rulesAddFilter['filter_variant' . '.' . $VKey . '.' . $fileVal] = 'required_if:productfiltertype,V|unique:product_filter_option,product_filter_option_name';
                    $rulesAddFilter['filter_variant' . '.' . $VKey . '.' . $fileVal] = 'required_if:productfiltertype,V';
                    $messagesAddFeature['filter_variant' . '.' . $VKey . '.' . $fileVal . '.required_if'] = 'Please select filter variant';
                    $messagesAddFeature['filter_variant' . '.' . $VKey . '.' . $fileVal . '.required_if'] = 'Please select filter variant description';

                }
            }
            $validator = Validator::make($request->all(), $rulesAddFilter, $messagesAddFeature);

            if ($validator->fails()) {
                return redirect('/admin/edit-filtergroup/' . $id)
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if ($inputData['productfiltertype'] == 'G') {
                    $data['product_filter_option_name'] = $inputData['productfiltergroupname'];
                    $data['product_filter_option_description'] = $inputData['filterdescription'];
                    $data['product_filter_type'] = $inputData['productfiltertype'];
                    $data['product_filter_variant_type'] = $inputData['filter_variant_type'];
                    $temp = array();
                    $cat = $postdata['productcategories'];
                    foreach ($cat as $catkey => $catval) {
                        $category[$catkey] = $catkey;
                    }
                    $where = ['rawQuery' => 'product_filter_option_id = ?', 'bindParams' => [$id]];
                    $FilterGroup = $ObjProductFilterOption->getFilterDetailsById($where);

                    $catdata = $FilterGroup[0]->product_filter_category_id;
                    $cata = explode(",", $catdata);
                    $categoryIds = implode(',', array_unique($category));
                    array_push($cata, $categoryIds);
                    $catmain = implode(",", array_unique(explode(",", implode(",", $cata))));
                    $data['product_filter_category_id'] = $catmain;
                    $data['added_by'] = $userId;

                    $result = $ObjProductFilterOption->updateFilterOption($where, $data);
                } else {
                    $temp = array();
                    foreach ($variantFilterInputData as $varianKey => $varianVal) {
                        $temp['product_filter_option_name'] = $varianVal['name'];
                        $temp['product_filter_option_description'] = $varianVal['description'];
                        $temp['product_filter_type'] = $inputData['productfiltertype'];
                        $temp['product_filter_group_id'] = $id;
                        $temp['added_by'] = $userId;
                        if (isset($varianVal['product_filter_option_id'])) {
                            $temps['product_filter_option_id'] = $varianVal['product_filter_option_id'];
                            $wheres = ['rawQuery' => 'product_filter_option_id =' . $varianVal['product_filter_option_id']];
                            $result = $ObjProductFilterOption->updateFilterOption($wheres, $temp);
                        } else {
                            $result = $ObjProductFilterOption->addProductfilterWhere($temp);
                        }
                    }
                }
            }

            if ($result) {
                $success = "Successfully Edited!";
                return Redirect::back()->with(['status' => 'success', 'msg' => $success]);
            } else {
                $success = "Nothing to update!";
                return Redirect::back()->with(['status' => 'info', 'msg' => $success]);
            }
        }

        $where = array('rawQuery' => 'category_status = ?', 'bindParams' => [1]);
        $allCategories = $ObjProductCategory->getAllCategoriesWhere($where);
        foreach ($allCategories as $key => $value) {
            $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
        }
        $whereId = ['rawQuery' => 'product_filter_option_id = ? OR product_filter_group_id = ?', 'bindParams' => [$id, $id]];
        $selectColumns = DB::raw(
            'product_filter_option.*,
            GROUP_CONCAT(CASE product_filter_type WHEN "V" THEN product_filter_option_name END ) AS var_names,
            GROUP_CONCAT(CASE product_filter_type WHEN "V" THEN product_filter_option_description END ) AS var_description,
            GROUP_CONCAT(CASE product_filter_type WHEN "V" THEN product_filter_option_id END ) AS var_ids'

        );
        $FilterGroup = $ObjProductFilterOption->getFilterOptionAndGroup($whereId, $selectColumns);

        if ((isset($allCategories)) && (!empty($FilterGroup))) {
            foreach ($FilterGroup as $filterKey => $filterVal) {
                if ($filterVal->product_filter_type == 'G') {
                    $catfilterName = array_filter(array_values(array_unique(explode(',', $filterVal->product_filter_category_id))));
                    if (!empty($catfilterName)) {
                        $where = ['rawQuery' => 'category_id IN (' . implode(',', $catfilterName) . ')'];

                        $selectColumns = ['product_categories.*'];
                        $category = $ObjProductCategory->getCategoryNameById($where, $selectColumns);
                        foreach ($category as $key => $val) {
                            $filtecat[$key] = $val->category_id;
                        }
                        $whereFeature = array('rawQuery' => 'status = ? AND parent_id=? AND feature_id = ?', 'bindParams' => [1, 0, $filterVal->product_filter_feature_id]);
                        $allFeatures = $ObjProductFeatures->getAllFeaturesWhere($whereFeature);
                        $dataForView = json_decode($allFeatures, true);
                        $errMsg = null;
                        if ($dataForView['code'] != 200) {
                            $errMsg = $dataForView['message'];
                        }
                    }
                }
            }

            $FilterGroup[0]->filterCategories = $allCategories;
            $FilterGroup[0]->selectedCategories = $filtecat;
            $FilterGroup[0]->filterFeatures = $dataForView['data'][0];

            return view('Admin/Views/filter/edit-filtergroup', ['editfiltergroup' => $FilterGroup]);
        }
    }

    /**
     * Filter Ajax Handler
     * @param Request $request
     * @author: Vini Dubey<vinidubey@globussoft.in>
     */
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
                    if ($featuredata) {
                        echo json_encode(['status' => 'success', 'msg' => 'Status has been changed.']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                    }
                    break;
                case 'deletefilteroption':
                    $filterId = $request->input('filterId');
                    $where = array('rawQuery' => 'product_filter_option_id=?', 'bindParams' => [$filterId]);
                    $deletefilter = $ObjProductFilterOption->deletefilteroption($where);
                    if ($deletefilter) {
                        echo json_encode(['status' => 'success', 'msg' => 'Selected option has been deleted.']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                    }
                    break;
                default:
                    break;

            }
        }
    }

    public function addFilterVariant(Request $request)
    {


        return view('Admin/Views/filter/add-filter-variant');
    }

    /**
     * To get string for tree view of categories (Ex.|--|--)
     * Used for tree view of category
     * @param $id Category id, for which we want to generate string
     * @return string
     * @throws Exception
     * @since 21-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
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
