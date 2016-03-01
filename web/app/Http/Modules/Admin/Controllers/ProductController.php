<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductImage;
use FlashSale\Http\Modules\Admin\Models\ProductMeta;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariantRelation;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use Yajra\Datatables\Datatables;
use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use FlashSale\Http\Modules\Admin\Models\ProductFeatures;
use FlashSale\Http\Modules\Admin\Models\Products;
use FlashSale\Http\Modules\Admin\Models\ProductFeatureVariants;
use FlashSale\Http\Modules\Admin\Models\ProductOption;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;


use Illuminate\Support\Facades\Session;

/**
 * Class ProductController
 * @package FlashSale\Http\Modules\Admin\Controllers
 */
class ProductController extends Controller
{

    public function addProduct(Request $request) //TODO- NOT COMPLETED
    {
        /*OUTPUT BUFFERING TEST FOR BROWSER CLOSE BY USER START*/
        /* ob_end_clean();
        header("Connection: close\r\n");
        header("Content-Encoding: none\r\n");
        ignore_user_abort(true); // optional
        ob_start();
        echo ('Text user will see');
        $size = ob_get_length();
        header("Content-Length: $size");
        ob_end_flush();     // Strange behaviour, will not work
        flush();            // Unless both are called !
        ob_end_clean();
//do processing here
        sleep(5);
        $objFeatureVariantsModel = ProductFeatureVariants::getInstance();
        $dataAddFV = array('variant_name' => "OB test", 'description' => "OB test description", 'feature_id' => "10000");
        $result = $objFeatureVariantsModel->addFeatureVariant($dataAddFV);
        echo('Text user will never see');
//do some processing
        die; */
        /*OUTPUT BUFFERING TEST FOR BROWSER CLOSE BY USER END*/

        $objModelCategory = ProductCategory::getInstance();
        $objModelFeatures = ProductFeatures::getInstance();
        $objModelProducts = Products::getInstance();
        $objModelProductMeta = ProductMeta::getInstance();
        $objModelProductImage = ProductImage::getInstance();
        $objModelProductOptionVariant = ProductOptionVariant::getInstance();
        $objModelProductOptionVariantRelation = ProductOptionVariantRelation::getInstance();


        $userId = Session::get('fs_admin')['id'];

        $whereForCat = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
        $allCategories = $objModelCategory->getAllCategoriesWhere($whereForCat);

        $whereForFeatureGroup = ['rawQuery' => 'group_flag =? and status = ?', 'bindParams' => [1, 1]];
        $allFeatureGroups = $objModelFeatures->getAllFeaturesWhere($whereForFeatureGroup);

        $objModelProductOption = ProductOption::getInstance();
        $whereForOptions = ['rawQuery' => 'status = 1'];
        $allOptions = $objModelProductOption->getAllOptionsWhere($whereForOptions);
//        print_a($allOptions);
        if ($request->isMethod('post')) {
//            $inputData = $request->input('product_data');//Excludes image
            $inputData = $request->all()['product_data'];//Includes image

//            print_a($inputData['options']);
//            print_a($_FILES);


            $rules = [
                'product_name' => 'required',
                'price' => 'required',
                'in_stock' => 'required',
                'comment' => 'max:100',
                'mainimage' => 'required|image|mimes:jpeg,bmp,png|max:1000'
            ];

            $messages['mainimage.required'] = 'Please select a main image for the product.';
            $validator = Validator::make($inputData, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()
                    ->with(["status" => 'error', 'msg' => 'Please correct the following errors.'])
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $errors = array();
                $productData = array();
                $productData['product_name'] = trim($inputData['product_name']);
                $productData['for_shop_id'] = $inputData['shop_id'];
                if (array_key_exists('product_type', $inputData))
                    $productData['product_type'] = 1;
                $productData['min_qty'] = $inputData['minimum_order_quantity'];
                $productData['max_qty'] = $inputData['maximum_order_quantity'];
                $productData['category_id'] = $inputData['category_id'];
                $productData['for_gender'] = $inputData['for_gender'];
                $productData['price_total'] = $inputData['price'];
                $productData['list_price'] = $inputData['list_price'];
                $productData['in_stock'] = $inputData['in_stock'];
                $productData['added_date'] = time();
                $productData['added_by'] = $userId;
                $productData['status_set_by'] = $userId;

                $insertedProductId = $objModelProducts->addNewProduct($productData);
                if ($insertedProductId > 0) {
                    //--------------------------PRODUCT-METADATA----------------------------//
                    $productMetaData['product_id'] = $insertedProductId;
                    $productMetaData['full_description'] = trim($inputData['full_description']);
                    $productMetaData['short_description'] = trim($inputData['short_description']);

                    if (array_key_exists('options', $inputData)) {
                        $finalOptionVariantRelationData = array();
                        foreach ($inputData['options'] as $key => $optionValue) {
                            $optionVariantRelationData['product_id'] = $insertedProductId;
                            $optionVariantRelationData['option_id'] = $optionValue['option_id'];
                            $optionVariantRelationData['status'] = $optionValue['status'];

                            $tempOptionVariantData = array();
                            $variantIds = array();
                            if (array_key_exists('variantData', $optionValue)) {
                                foreach ($optionValue['variantData'] as $variantKey => $variantValue) {
                                    $temp = array();
                                    if ($variantValue['variant_id'] == 0) {
                                        $variantData['option_id'] = $optionValue['option_id'];
                                        $variantData['variant_name'] = $variantValue['variant_name'];
                                        $variantData['added_by'] = $userId;
                                        $variantData['status'] = $variantValue['status'];
                                        $variantData['created_at'] = NULL;

                                        $insertedVariantId = $objModelProductOptionVariant->addNewVariantAndGetID($variantData);
                                        if ($insertedVariantId > 0) {
                                            array_push($variantIds, $insertedVariantId);
                                            $temp['VID'] = $insertedVariantId;
                                            $temp['VN'] = $variantValue['variant_name'];
                                            $temp['PM'] = $variantValue['price_modifier'];
                                            $temp['PMT'] = $variantValue['price_modifier_type'];
                                            $temp['WM'] = $variantValue['weight_modifier'];
                                            $temp['WMT'] = $variantValue['weight_modifier_type'];
                                            $temp['STTS'] = $variantValue['status'];
                                        }
                                    } else {
                                        array_push($variantIds, $variantValue['variant_id']);
                                        $temp['VID'] = $variantValue['variant_id'];
                                        $temp['VN'] = $variantValue['variant_name'];
                                        $temp['PM'] = $variantValue['price_modifier'];
                                        $temp['PMT'] = $variantValue['price_modifier_type'];
                                        $temp['WM'] = $variantValue['weight_modifier'];
                                        $temp['WMT'] = $variantValue['weight_modifier_type'];
                                        $temp['STTS'] = $variantValue['status'];
                                    }
                                    $tempOptionVariantData[] = $temp;
                                }
                                if (!empty($variantIds) && !empty($tempOptionVariantData)) {
                                    $optionVariantRelationData['variant_ids'] = implode(',', $variantIds);
                                    $optionVariantRelationData['variant_data'] = json_encode($tempOptionVariantData);
                                }
                            }
                            $finalOptionVariantRelationData[] = $optionVariantRelationData;
                        }
                        if (!empty($finalOptionVariantRelationData)) {
                            $objModelProductOptionVariantRelation->addNewOptionVariantRelation($finalOptionVariantRelationData);
                        }
                    }
                    $productMetaData['weight'] = $inputData['shipping_properties']['weight'];
                    $productMetaData['shipping_freight'] = $inputData['shipping_properties']['shipping_freight'];

                    $shippingParams = array();
                    $shippingParams['min_items'] = $inputData['shipping_properties']['min_items'];
                    $shippingParams['max_items'] = $inputData['shipping_properties']['min_items'];

                    if (array_key_exists('box_length', $inputData['shipping_properties']))
                        $shippingParams['box_length'] = $inputData['shipping_properties']['box_length'];
                    if (array_key_exists('box_width', $inputData['shipping_properties']))
                        $shippingParams['box_width'] = $inputData['shipping_properties']['box_width'];
                    if (array_key_exists('box_height', $inputData['shipping_properties']))
                        $shippingParams['box_height'] = $inputData['shipping_properties']['box_height'];

                    $productMetaData['shipping_params'] = json_encode($shippingParams);
                    $productMetaData['quantity_discount'] = json_encode($inputData['quantity_discount']);
                    $productMetaData['product_tabs'] = json_encode($inputData['product_tabs']);

                    $insertedProductMetaId = $objModelProductMeta->addProductMetaData($productMetaData);
                    if (!$insertedProductMetaId)
                        $errors[] = 'Sorry, some of the product data were not added, please update the same on the edit section.';
                    //--------------------------END PRODUCT-METADATA----------------------------//


                    //----------------------------PRODUCT-IMAGES------------------------------//
                    $productImages = $_FILES['product_data'];
                    $imageData = array();
                    if ($productImages['error']['mainimage'] == 0) {
                        $mainImageURL = uploadImageToStoragePath($productImages['tmp_name']['mainimage'], 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_0_' . time() . '.jpg');
                        if ($mainImageURL) {
                            $mainImageData['for_product_id'] = $insertedProductId;
                            $mainImageData['image_type'] = 0;
                            $mainImageData['image_upload_type'] = 0;
                            $mainImageData['image_url'] = $mainImageURL;
                            $imageData[] = $mainImageData;
                        }
                    } else {
                        $errors[] = 'Sorry, something went wrong. Main image could not be uploaded, You can upload it on edit section.';
                    }

                    if (array_key_exists('otherimages', $productImages['name'])) {
                        foreach ($productImages['tmp_name']['otherimages'] as $otherImageKey => $otherImage) {
                            if ($otherImage != '') {
                                $otherImageURL = uploadImageToStoragePath($otherImage, 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_' . ($otherImageKey + 1) . '_' . time() . '.jpg');
                                if ($otherImageURL) {
                                    $otherImageData['for_product_id'] = $insertedProductId;
                                    $otherImageData['image_type'] = 1;
                                    $otherImageData['image_upload_type'] = 0;
                                    $otherImageData['image_url'] = $otherImageURL;
                                    $imageData[] = $otherImageData;
                                }
                            }
                        }
                    }
                    if (!empty($imageData)) {
                        $objModelProductImage->addNewImage($imageData);
                    }
                    //--------------------------END PRODUCT-IMAGES----------------------------//

                }

                if ($insertedProductId || isset($insertedProductMetaId)) {
                    return Redirect::back()->with(['status' => 'success', 'msg' => 'New product "' . $productData['product_name'] . '" has been added.']);
                } else {
                    return Redirect::back()->with(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again.']);
                }
            }
        }
        foreach ($allCategories as $key => $value) {
            $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
        }
        return view('Admin/Views/product/addProduct', ['code' => '', 'allCategories' => $allCategories, 'allOptions' => $allOptions, 'featureGroups' => json_decode($allFeatureGroups, true)]);
    }

    public function getCategoryDisplayName($id)
    {
        if ($id == 0) {
            return '';
        } else {
            $objCategoryModel = ProductCategory::getInstance();
            $whereForCat = ['rawQuery' => 'category_id =?', 'bindParams' => [$id]];
            $parentCategory = $objCategoryModel->getCategoryDetailsWhere($whereForCat);
            if ($parentCategory->parent_category_id != 0) {
                return $this->getCategoryDisplayName($parentCategory->parent_category_id) . '&brvbar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            } else {
                return '';
            }
        }
    }

    public function manageProducts()
    {
//        return view('Admin/Views/product/addProduct', ['pendingProducts' => $pendingProducts]);
        return view('Admin/Views/product/manageProducts');

    }

    public function productAjaxHandler(Request $request)
    {
        $response = array();
        $inputData = $request->input();
        $method = $inputData['method'];
        $response['code'] = 400;
        $response['data'] = array();
        $response['message'] = "Invalid request.";
        if ($method) {
            switch ($method) {
                case 'getOptionVariantsWhere':
                    $response['code'] = 400;
                    $response['data'] = array();
                    $response['message'] = "Please select an option to add";
                    if (isset($inputData['optionId']) && $inputData['optionId'] != '') {
                        $optionId = (int)$inputData['optionId'];
                        $objModelProductOption = ProductOption::getInstance();
                        $whereForOption = ['rawQuery' => 'option_id = ?', 'bindParams' => [$optionId]];
                        $optionDetails = $objModelProductOption->getOptionWhere($whereForOption);
                        $objModelProductOptionVariants = ProductOptionVariant::getInstance();
                        $whereForOptionVariant = ['rawQuery' => 'option_id = ?', 'bindParams' => [$optionId]];
                        $allOptionVariants = $objModelProductOptionVariants->getAllVariantsWhere($whereForOptionVariant);
                        $response['code'] = 200;
                        $response['message'] = 'Option data';
                        $response['data']['optionDetails'] = $optionDetails;
                        $response['data']['optionVariants'] = $allOptionVariants;
                    }
                    break;

                default:
                    break;
            }
        }
        echo json_encode($response, true);
        die;
    }
}
