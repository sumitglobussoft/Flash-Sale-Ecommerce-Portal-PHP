<?php

namespace FlashSale\Http\Modules\Supplier\Controllers;

use FlashSale\Http\Modules\Supplier\Models\ProductCategory;
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


use FlashSale\Http\Modules\Supplier\Models\User;
use Illuminate\Support\Facades\Session;

/**
 * Class CategoryController
 * @package FlashSale\Http\Modules\Supplier\Controllers
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class CategoryController extends Controller
{
    private $imageWidth = 1024;//TO BE USED FOR IMAGE RESIZING
    private $imageHeight = 1024;//TO BE USED FOR IMAGE RESIZING

    /**
     * Manage categories action
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function manageCategories()
    {
        $objCategoryModel = ProductCategory::getInstance();
        return view('Supplier/Views/category/manageCategories', ['allCategories' => $objCategoryModel->getAllCategoriesWhere(
            ['rawQuery' => 'created_by IN (' . DB::raw("SELECT `id` FROM `users` WHERE `role` IN(4,5)") . ') OR created_by=? AND  category_status IN(0,1,2)',
                'bindParams' => [Session::get('fs_supplier')['id']]]
        )]);
    }


    /**
     * Add new category action
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Supplier\Models\Exception
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addCategory(Request $request)
    {
        $objCategoryModel = ProductCategory::getInstance();
        $userId = Session::get('fs_supplier')['id'];
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
                $categoryData['category_name'] = $request->input('category_name');
                $categoryData['category_desc'] = $request->input('category_desc');
                $categoryData['created_by'] = $userId;
                $categoryData['status_set_by'] = $userId;
                $categoryData['category_status'] = $request->input('status');
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
        return view('Supplier/Views/category/addCategory', ['allCategories' => $objCategoryModel->getAllCategoriesWhere(
            ['rawQuery' => 'created_by IN (' . DB::raw("SELECT `id` FROM `users` WHERE `role` IN(4,5)") . ') OR created_by=? AND  category_status IN(0,1,2)',
                'bindParams' => [$userId]]
        )]);
    }

    /**
     * Edit category action
     * @param Request $request
     * @param $id Category id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \FlashSale\Http\Modules\Supplier\Models\Exception
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function editCategory(Request $request, $id)
    {
        $objCategoryModel = ProductCategory::getInstance();
        $userId = Session::get('fs_supplier')['id'];
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

        $where = ['rawQuery' => 'category_id =? AND category_status IN(0,1,2) AND created_by=?', 'bindParams' => [$id, $userId]];
        $categoryDetails = $objCategoryModel->getCategoryDetailsWhere($where);
        $allCategories = '';
        if ($categoryDetails) {
            $allCategories = $objCategoryModel->getAllCategoriesWhere(
                ['rawQuery' => 'created_by IN (' . DB::raw("SELECT `id` FROM `users` WHERE `role` IN(4,5)") . ') OR created_by=? AND  category_status IN(0,1,2)',
                    'bindParams' => [$userId]]
            );
        }
        return view('Supplier/Views/category/editCategory', ['categoryDetails' => $categoryDetails, 'allCategories' => $allCategories]);

    }

}
