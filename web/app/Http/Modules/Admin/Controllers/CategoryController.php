<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductCategories;
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


class CategoryController extends Controller
{

    public function manageCategories()
    {
        $objCategoryModel = ProductCategories::getInstance();
        $where = array('column' => 'category_status', 'condition' => '=', 'value' => '1');
        $allCategories = $objCategoryModel->getAllCategoriesWhere($where);

        foreach ($allCategories as $key => $value) {
            $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
        }


//        echo '<pre>';
//        print_r($allCategories);
//        die;
        return view('Admin/Views/category/manageCategories', ['allCategories' => $allCategories]);
    }


    public function addCategory(Request $request)
    {
        $objCategoryModel = ProductCategories::getInstance();
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
//                'category_image' => 'array',
                'seo_name' => 'max:100',
                'page_title' => 'max:70',
                'meta_desc' => 'max:160',
                'meta_keywords' => 'word_count'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $categoryData = array();

//                if ($request->has('category_image')) {
//                    $destinationPath = 'assets/uploads/category/';
//                    $filename = 'category_' . time() . ".jpg";
//                    File::makeDirectory($destinationPath, 0777, true, true);
//                    $filePath = '/' . $destinationPath . $filename;
//
//                    $imageResult = Image::make(Input::file('category_image'))->resize(1024, 1024, function ($constraint) {
//                        $constraint->aspectRatio();
//                    })->save($destinationPath . $filename, 80);
//                    if ($imageResult) {
//                        $categoryData['category_banner_url'] = $filePath;
//                    }
//                }
                $categoryData['category_name'] = $request->input('category_name');
                $categoryData['category_desc'] = $request->input('category_desc');
                $categoryData['created_by'] = $userId;
                $categoryData['status_set_by'] = $userId;
                $categoryData['category_status'] = $request->input('status');
                $categoryData['parent_category_id'] = $request->input('parent_category');
                $categoryData['page_title'] = $request->input('page_title');
                $categoryData['meta_description'] = $request->input('meta_desc');
                $categoryData['meta_keywords'] = $request->input('meta_keywords');

                $insertedId = $objCategoryModel->addCategory($categoryData);

                if ($insertedId) {
                    $whereForUpdate['column'] = 'category_id';
                    $whereForUpdate['condition'] = '=';
                    $whereForUpdate['value'] = $insertedId;
                    $dataToUpdate['id_path'] = $this->getParentCategoryIds($insertedId);
                    $dataToUpdate['level'] = count(explode('/', $dataToUpdate['id_path']));
                    $objCategoryModel->updateCategoryWhere($dataToUpdate, $whereForUpdate);

                    return Redirect::back()->with(['status' => '1', 'msg' => 'New category' . $request->input('category_name') . ' has been added.']);
                } else {
                    return Redirect::back()->with(['status' => '0', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
            }
        }


        $where = array('column' => 'category_status', 'condition' => '=', 'value' => '1');
        $allCategories = $objCategoryModel->getAllCategoriesWhere($where);

        foreach ($allCategories as $key => $value) {
            $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
        }


//        echo '<pre>';
//        print_r($allCategories);
//        die;
        return view('Admin/Views/category/addCategory', ['allCategories' => $allCategories]);
    }

    /**
     * To get string of parent ids (Ex.- 1/4/10)
     * Used for category id_path
     * @param $id Category id, for which we want to get parent ids
     * @return string
     * @throws Exception
     * @since 21-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function getParentCategoryIds($id)
    {
        if ($id == 0) {
            return $id;
        } else {
            $objCategoryModel = ProductCategories::getInstance();
            $where['column'] = 'category_id';
            $where['condition'] = '=';
            $where['value'] = $id;
            $parentCategory = $objCategoryModel->getCategoryDeltailsWhere($where);
            if ($parentCategory->parent_category_id != 0) {
                return $this->getParentCategoryIds($parentCategory->parent_category_id) . '/' . $id;
            } else {
                return $id;
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
            $objCategoryModel = ProductCategories::getInstance();
            $where['column'] = 'category_id';
            $where['condition'] = '=';
            $where['value'] = $id;
            $parentCategory = $objCategoryModel->getCategoryDeltailsWhere($where);
            if ($parentCategory->parent_category_id != 0) {
                return $this->getCategoryDisplayName($parentCategory->parent_category_id) . '&brvbar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                return '';
            }
        }
    }

}
