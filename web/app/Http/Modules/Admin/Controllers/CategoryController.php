<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

use Image;
use Validator;
use Input;
use Redirect;
use File;


use FlashSale\Http\Modules\Admin\Models\User;
use Illuminate\Support\Facades\Session;

/**
 * Class CategoryController
 * @package FlashSale\Http\Modules\Admin\Controllers
 */
class CategoryController extends Controller
{
    private $imageWidth = 1024;//TO BE USED FOR IMAGE RESIZING
    private $imageHeight = 1024;//TO BE USED FOR IMAGE RESIZING

    /**
     * Manage categories action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 20-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function manageCategories()
    {
        $objCategoryModel = ProductCategory::getInstance();
//        $where = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
        $where = ['rawQuery' => '1'];
        $allCategories = $objCategoryModel->getAllCategoriesWhere($where);
        return view('Admin/Views/category/manageCategories', ['allCategories' => $allCategories]);
    }


    /**
     * Add new category action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 20-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addCategory(Request $request)
    {
        $objCategoryModel = ProductCategory::getInstance();
        $userId = Session::get('fs_admin')['id'];
        if ($request->isMethod('post')) {

            Validator::extend('word_count', function ($field, $value, $parameters) {
                if (count(explode(' ', $value)) > 10)
                    return false;
                return true;
            }, 'Meta keywords should not contain more than 10 words.');
            $rules = array(
                'category_name' => 'required|max:50|unique:product_categories,category_name',
                'category_desc' => 'max:255',
                'parent_category' => 'integer',
                'status' => 'required',
//                'category_image' => 'array', //TODO-me Validation for image
                'seo_name' => 'max:100',
                'page_title' => 'max:70',
                'meta_desc' => 'max:160',
                'meta_keywords' => 'word_count'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $categoryData = array();

                if (Input::hasFile('category_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('category_image'), 'category');
                    if ($filePath) $categoryData['category_banner_url'] = $filePath;
                }
                $categoryData['category_name'] = trim($request->input('category_name'));
                $categoryData['category_desc'] = $request->input('category_desc');
                $categoryData['created_by'] = $userId;
                $categoryData['status_set_by'] = $userId;
                $categoryData['category_status'] = $request->input('status');
                $categoryData['is_visible'] = $request->input('is_visible');
                $categoryData['parent_category_id'] = $request->input('parent_category');
                $categoryData['page_title'] = $request->input('page_title');
                $categoryData['meta_description'] = $request->input('meta_desc');
                $categoryData['meta_keywords'] = $request->input('meta_keywords');
                $categoryData['created_at'] = NULL;

                $insertedId = $objCategoryModel->addCategory($categoryData);
                return Redirect::back()->with(
                    ($insertedId > 0) ?
                        ['status' => 'success', 'msg' => 'New category "' . $request->input('category_name') . '" has been added.'] :
                        ['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']
                );
            }
        }
//        $where = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
        $where = ['rawQuery' => '1'];
        $allCategories = $objCategoryModel->getAllCategoriesWhere($where);
        return view('Admin/Views/category/addCategory', ['allCategories' => $allCategories]);
    }

    /**
     * Edit category action
     * @param Request $request
     * @param $id Category id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Admin\Models\Exception
     * @since 20-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function editCategory(Request $request, $id)
    {

        $objCategoryModel = ProductCategory::getInstance();
        if ($request->isMethod('post')) {
            Validator::extend('word_count', function ($field, $value, $parameters) {
                if (count(explode(' ', $value)) > 10)
                    return false;
                return true;
            }, 'Meta keywords should not contain more than 10 words.');
            $rules = array(
                'category_name' => 'required|max:50|unique:product_categories,category_name,' . $id . ',category_id',
                'category_desc' => 'max:255',
                'status' => 'required',
//                'category_image' => 'array',
                'seo_name' => 'max:100',
                'page_title' => 'max:70',
                'meta_desc' => 'max:160',
                'meta_keywords' => 'word_count'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {
                if (Input::hasFile('category_image')) {
                    $filePath = uploadImageToStoragePath(Input::file('category_image'), 'category');
                    if ($filePath) $dataToUpdate['category_banner_url'] = $filePath;
                }
                $dataToUpdate['category_name'] = $request->input('category_name');
                $dataToUpdate['category_desc'] = $request->input('category_desc');
                $dataToUpdate['category_status'] = $request->input('status');
                $dataToUpdate['is_visible'] = $request->input('is_visible');
                $dataToUpdate['parent_category_id'] = $request->input('parent_category');
                $dataToUpdate['page_title'] = $request->input('page_title');
                $dataToUpdate['meta_description'] = $request->input('meta_desc');
                $dataToUpdate['meta_keywords'] = $request->input('meta_keywords');

                $whereForUpdate = ['rawQuery' => 'category_id =?', 'bindParams' => [$id]];
                $updateResult = $objCategoryModel->updateCategoryWhere($dataToUpdate, $whereForUpdate);

                if ($updateResult > 0) {
                    if (isset($filePath)) deleteImageFromStoragePath($request->input('old_image'));
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'Category details has been updated.']);
                } else {
                    return Redirect::back()->with(['status' => 'info', 'msg' => 'Nothing to update.']);
                }
            }
        }

        $where = ['rawQuery' => 'category_id =?', 'bindParams' => [$id]];
        $categoryDetails = $objCategoryModel->getCategoryDetailsWhere($where);
        $allCategories = '';
        if ($categoryDetails) {
//            $where = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
            $where = ['rawQuery' => '1'];
            $allCategories = $objCategoryModel->getAllCategoriesWhere($where);
//            foreach ($allCategories as $key => $value) {
//                $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
//            }
        }
        return view('Admin/Views/category/editCategory', ['categoryDetails' => $categoryDetails, 'allCategories' => $allCategories]);

    }

}
