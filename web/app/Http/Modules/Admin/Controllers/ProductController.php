<?php

namespace FlashSale\Http\Modules\Admin\Controllers;

use FlashSale\Http\Modules\Admin\Models\ProductImage;
use FlashSale\Http\Modules\Admin\Models\ProductMeta;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariantRelation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use FlashSale\Http\Requests;
use FlashSale\Http\Controllers\Controller;
use DB;
use Yajra\Datatables\Datatables;
use FlashSale\Http\Modules\Admin\Models\ProductCategory;
use FlashSale\Http\Modules\Admin\Models\ProductFeatures;
use FlashSale\Http\Modules\Admin\Models\Products;
use FlashSale\Http\Modules\Admin\Models\ProductFeatureVariants;
use FlashSale\Http\Modules\Admin\Models\ProductFeatureVariantRelation;
use FlashSale\Http\Modules\Admin\Models\ProductOption;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariant;
use FlashSale\Http\Modules\Admin\Models\ProductOptionVariantsCombination;
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
        $objModelProductFeatureVariantRelation = ProductFeatureVariantRelation::getInstance();
        $objModelProductOptVarCombination = ProductOptionVariantsCombination::getInstance();

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
                        $varDataForCombinations = array();
                        foreach ($inputData['options'] as $key => $optionValue) {
                            $optionVariantRelationData['product_id'] = $insertedProductId;
                            $optionVariantRelationData['option_id'] = $optionValue['option_id'];
                            $optionVariantRelationData['status'] = $optionValue['status'];

                            $tempOptionVariantData = array();
                            $variantIds = array();
                            //-------------------------OLD OPTION VARIANT START-----------------------//
                            /*
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
                            */
                            //-------------------------OLD OPTION VARIANT END-----------------------//

                            //-------------------------NEW OPTION VARIANT START---------------------//
                            if (array_key_exists('variantData', $optionValue)) {
                                foreach ($optionValue['variantData'] as $variantKey => $variantValue) {
                                    $temp = array();
                                    array_push($variantIds, $variantValue['variant_id']);
                                    $temp['VID'] = $variantValue['variant_id'];
                                    $temp['VN'] = $variantValue['variant_name'];
                                    $temp['PM'] = $variantValue['price_modifier'];
                                    $temp['PMT'] = $variantValue['price_modifier_type'];
                                    $temp['WM'] = $variantValue['weight_modifier'];
                                    $temp['WMT'] = $variantValue['weight_modifier_type'];
                                    $temp['STTS'] = $variantValue['status'];
                                    $tempOptionVariantData[] = $temp;
                                }
                            }
                            if (array_key_exists('variantDataNew', $optionValue)) {
                                foreach ($optionValue['variantDataNew'] as $variantKey => $variantValue) {
                                    $temp = array();
                                    $variantData['option_id'] = $optionValue['option_id'];
                                    $variantData['variant_name'] = $variantValue['variant_name'];
                                    $variantData['added_by'] = $userId;
                                    $variantData['status'] = $variantValue['status'];
                                    $variantData['created_at'] = NULL;
                                    $insertedVariantId = $objModelProductOptionVariant->addNewVariantAndGetID($variantData);
                                    if ($insertedVariantId > 0) {
                                        $varDataForCombinations[$variantValue['variant_id']] = $insertedVariantId;
                                        array_push($variantIds, $insertedVariantId);
                                        $temp['VID'] = $insertedVariantId;
                                        $temp['VN'] = $variantValue['variant_name'];
                                        $temp['PM'] = $variantValue['price_modifier'];
                                        $temp['PMT'] = $variantValue['price_modifier_type'];
                                        $temp['WM'] = $variantValue['weight_modifier'];
                                        $temp['WMT'] = $variantValue['weight_modifier_type'];
                                        $temp['STTS'] = $variantValue['status'];
                                    }
                                    $tempOptionVariantData[] = $temp;
                                }
                            }
                            if (!empty($variantIds) && !empty($tempOptionVariantData)) {
                                $optionVariantRelationData['variant_ids'] = implode(',', $variantIds);
                                $optionVariantRelationData['variant_data'] = json_encode($tempOptionVariantData);
                            }
                            //-------------------------NEW OPTION VARIANT END---------------------//

                            $finalOptionVariantRelationData[] = $optionVariantRelationData;
                        }
                        if (!empty($finalOptionVariantRelationData)) {
                            $objModelProductOptionVariantRelation->addNewOptionVariantRelation($finalOptionVariantRelationData);
                        }

                        //------------------------PRODUCT OPTION COMBINATIONS START HERE---------------------//
                        foreach ($inputData['opt_combination'] as $keyCombination => $valueCombination) {
                            $flags = explode("_", $valueCombination['newflag']);
                            $combinationVarIds = explode("_", $keyCombination);
                            $flagKeys = array_keys($flags, "1");
                            foreach ($flagKeys as $keyFK => $valueFK) {
                                $combinationVarIds[$keyFK] = $varDataForCombinations[$combinationVarIds[[$keyFK]]];
                            }
                            //TODO ADD BARCODE, shippig info and image data for the combination here
                            $dataCombinations['product_id'] = $insertedProductId;
                            $dataCombinations['variant_ids'] = implode("_", $combinationVarIds);
                            $dataCombinations['quantity'] = $valueCombination['quantity'];
                            $dataCombinations['exception_flag'] = 0;
                            if (isset($valueCombination['excludeflag']) && $valueCombination['excludeflag'] == 'on') {
                                $dataCombinations['exception_flag'] = 1;
                            }
                            $objModelProductOptVarCombination->addNewOptionVariantsCombination($dataCombinations);

                        }
                        //------------------------PRODUCT OPTION COMBINATIONS END HERE---------------------//

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
                        $mainImageURL = uploadImageToStoragePath($productImages['tmp_name']['mainimage'], 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_0_' . time() . '.jpg', 724, 1024);
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
                                $otherImageURL = uploadImageToStoragePath($otherImage, 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_' . ($otherImageKey + 1) . '_' . time() . '.jpg', 724, 1024);
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

                    //------------------------PRODUCT FEATURES START HERE---------------------//
                    if (array_key_exists('features', $inputData)) {
                        $productDataFeatures = $inputData['features'];
                        $fvrDataToInsert = array();
                        foreach ($productDataFeatures as $keyPDF => $valuePDF) {
                            if (array_key_exists("single", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => 0, 'display_status' => $productDataFeatures[$keyPDF]['status']];
                                $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => 0, 'display_status' => $productDataFeatures[$keyPDF]['status']]);
                            } else if (array_key_exists("muliple", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => implode(",", array_keys($valuePDF['multiple'])), 'display_status' => $valuePDF['status']];
                                $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => implode(",", array_keys($valuePDF['multiple'])), 'display_status' => $valuePDF['status']]);
                            } else if (array_key_exists("select", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => $valuePDF['select'], 'display_status' => $valuePDF['status']];
                                $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => "" . $valuePDF['select'], 'display_status' => $valuePDF['status']]);
                            }
                        }
//                    $objModelProductFeatureVariantRelation->addFeatureVariantRelation($fvrDataToInsert);
                    }
                    //------------------------PRODUCT FEATURES END HERE---------------------//

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
        $objCategoryModel = ProductCategory::getInstance();

        $where = ['rawQuery' => '1'];
        $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where);
        return view('Admin/Views/product/manageProducts', ['allCategories' => $allactivecategories]);

    }

    public function productAjaxHandler(Request $request)
    {
        $response = array();
        $inputData = $request->input();
        $method = $inputData['method'];
        $response['code'] = 400;
        $response['data'] = array();
        $response['message'] = "Invalid request.";
        $objModelProducts = Products::getInstance();
        $objCategoryModel = ProductCategory::getInstance();
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

                //26-02-2016
                case "getFeaturesWhereCatIdLike":
                    $response['code'] = 400;
                    $response['data'] = array();
                    $response['message'] = "";
                    if (isset($inputData['catid']) && $inputData['catid'] != '') {
                        $objModelProductCategories = ProductCategory::getInstance();
                        $catId = (int)$inputData['catid'];
                        $catFlag = true;
                        $parentCategory = array();
                        $count = 1;
                        $bindParamsForFeature = array();
                        $queryForFeature = "";
                        $queryForFeatureGroup = "";
                        while ($catFlag) {
                            if ($count == 1) {
                                $queryForFeatureGroup = '(product_features.group_flag = 1) and (product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ?';
                                $queryForFeature = '(group_flag = 0 and parent_id = 0) and (for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ?';
                            } else {
                                $count++;
                                $catId = $parentCategory['category_id'];
                                $queryForFeatureGroup .= 'OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ?';
                                $queryForFeature .= 'OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ?';
                            }
                            array_push($bindParamsForFeature, "%,$catId");
                            array_push($bindParamsForFeature, "%,$catId,%");
                            array_push($bindParamsForFeature, "$catId,%");
                            array_push($bindParamsForFeature, "$catId");
                            $parentCategory = array();
                            $whereForCat = ['rawQuery' => 'parent_category_id = ?', "bindParams" => [$catId]];
                            $parentCategory = $objModelProductCategories->getCategoryDetailsWhere($whereForCat);
                            if (!$parentCategory) {
                                $catFlag = false;
                            }
                        }
                        $queryForFeature .= ")";
                        $queryForFeatureGroup .= ")";
                        $objModelProductFeature = ProductFeatures::getInstance();
                        $whereForFeature = ['rawQuery' => $queryForFeature, 'bindParams' => $bindParamsForFeature];
//                        $featureDetails = json_decode($objModelProductFeature->getAllFeaturesWhere($whereForFeature), true);
                        $featureDetails = json_decode($objModelProductFeature->getAllFeaturesWithVariantsWhere($whereForFeature), true);

                        $whereForFeatureGroup = ['rawQuery' => $queryForFeatureGroup, 'bindParams' => $bindParamsForFeature];
                        $featureGroups = json_decode($objModelProductFeature->getAllFGsWithFsWhere($whereForFeatureGroup), true);
//                        dd($featureGroups);
                        foreach ($featureGroups['data'] as $keyFG => $valueFG) {
                            $whereForFs = ['rawQuery' => "product_features.parent_id IN (?)", "bindParams" => [$valueFG['feature_ids']]];
                            $featureGroups['data'][$keyFG]['featureDetails'] = json_decode($objModelProductFeature->getAllFeaturesWithVariantsWhere($whereForFs), true)['data'];
                        }
//                        dd($featureGroups);
//                        dd($featureDetails);
                        $response['code'] = $featureDetails['code'];
                        $response['message'] = $featureDetails['message'];
                        $response['data']['featureDetails'] = $featureDetails['data'];
                        $response['data']['featureGroupDetails'] = $featureGroups['data'];
//                        dd($response);
                    }
                    break;

                case 'deletedProducts':
                    $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 4, 0]];
                    $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                    $getAllProducts = $objModelProducts->getAllProducts($where, $selectedColumn);
                    $productInfo = json_decode(json_encode($getAllProducts), true);
                    $products = new Collection();
                    foreach ($productInfo as $key => $val) {
                        $products->push([
                            'product_id' => $val['product_id'],
                            'product_images' => '<img src="' . $val['image_url'] . '" width="30px">',
                            'added_date' => date('d-F-Y', strtotime($val['added_date'])),
                            'shop_name' => $val['shop_name'],
                            'product_name' => $val['product_name'],
                            'price_total' => $val['price_total'],
                            'list_price' => $val['list_price'],
                            'min_qty' => $val['min_qty'],
                            'max_qty' => $val['max_qty'],
                            'category_name' => $val['category_name'],
                            'in_stock' => $val['in_stock'],
                            'username' => $val['username'],
                            'available_countries' => $val['available_countries'],
                            'product_status' => $val['product_status'],
                        ]);
                    }

                    // FILTERING STARTS FROM HERE //
                    $filteringRules = '';
                    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                        if ($_REQUEST['product_id'] != '') {
                            $filteringRules[] = "(`products`.`product_id` = " . $_REQUEST['product_id'] . " )";
                        }
                        if ($_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != '') {
                            $filteringRules[] = "(`products`.`added_date` BETWEEN " . strtotime(str_replace('-', ' ', $_REQUEST['date_from'])) . " AND " . strtotime(str_replace('-', ' ', $_REQUEST['date_to'])) . "  )";
                        }
                        if ($_REQUEST['store_name'] != '') {
                            $filteringRules[] = "(`shops`.`shop_name` LIKE '%" . $_REQUEST['store_name'] . "%' )";
                        }
                        if ($_REQUEST['product_name'] != '') {
                            $filteringRules[] = "(`products`.`product_name` LIKE '%" . $_REQUEST['product_name'] . "%' )";
                        }
                        if ($_REQUEST['price_from'] != '' && $_REQUEST['price_to'] != '') {
                            $filteringRules[] = "(`products`.`price_total` BETWEEN " . intval($_REQUEST['price_from']) . " AND " . intval($_REQUEST['price_to']) . "  )";
                        }
                        if ($_REQUEST['list_price_from'] != '' && $_REQUEST['list_price_to'] != '') {
                            $filteringRules[] = "(`products`.`list_price` BETWEEN " . intval($_REQUEST['list_price_from']) . " AND " . intval($_REQUEST['list_price_to']) . "  )";
                        }
                        if ($_REQUEST['minimum_quantity'] != '') {
                            $filteringRules[] = "( `products`.`min_qty` = " . intval($_REQUEST['minimum_quantity']) . ")";
                        }
                        if ($_REQUEST['maximum_quantity'] != '') {
                            $filteringRules[] = "(`products`.`max_qty` = " . intval($_REQUEST['maximum_quantity']) . ")";
                        }
                        if ($_REQUEST['product_categories'] != '') {
                            $filteringRules[] = "(`products`.`category_id` = " . $_REQUEST['product_categories'] . " )";
                        }
                        if ($_REQUEST['added_by'] != '') {
                            $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['added_by'] . "%' )";
                        }
//                        if ($_REQUEST['product_status'] != '') {
//                            $filteringRules[] = "(`products`.`product_status` = " . $_REQUEST['product_status'] . " )";
//                        }

                        // Filter Implode //
                        $implodedWhere = '';
                        if (!empty($filteringRules)) {
                            $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                                return $filterValues;
                            }, $filteringRules));
                        }
                        //   Modify code for filter //
                        $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                        $iDisplayStart = intval($_REQUEST['start']);
                        $sEcho = intval($_REQUEST['draw']);
//                $columns = array('o.order_id', 'o.added_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');
                        $columns = array('products.product_id', 'products.added_date', 'products.product_type', 'users.username', 'shops.shop_name', 'products.product_name', 'products.price_total', 'products.list_price', 'products.min_qty', 'products.max_qty', 'products.category_id', 'products.available_countries', 'products.products_status');
                        $sortingOrder = "";
                        if (isset($_REQUEST['order'])) {
                            $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                        }
                        // End Modify code for filter//
                        if (!empty($implodedWhere)) {
                            $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 4, 0]];
                            $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                            $getAllFilterProducts = $objModelProducts->getAllFilterProducts($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);
                            $productFilter = json_decode(json_encode($getAllFilterProducts), true);
                            $products = new Collection();
                            foreach ($productFilter as $key => $val) {
                                $products->push([
                                    'product_id' => $val['product_id'],
                                    'product_images' => '<img src="' . $val['image_url'] . '" width="80px">',
                                    'added_date' => date('d-F-Y', strtotime($val['added_date'])),
                                    'shop_name' => $val['shop_name'],
                                    'product_name' => $val['product_name'],
                                    'price_total' => $val['price_total'],
                                    'list_price' => $val['list_price'],
                                    'min_qty' => $val['min_qty'],
                                    'max_qty' => $val['max_qty'],
                                    'category_name' => $val['category_name'],
                                    'in_stock' => $val['in_stock'],
                                    'username' => $val['username'],
                                    'available_countries' => $val['available_countries'],
                                    'product_status' => $val['product_status'],
                                ]);
                            }
                        }
                    }

                    return Datatables::of($products)
                        ->addColumn('action', function ($products) {
                            $action = '<div role="group" class="btn-group "> <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"> <i class="fa fa-cog"></i>&nbsp; <span class="caret"></span></button>';
                            $action .= '<ul role="menu" class="dropdown-menu">';
                            $action .= '<li><a href="/admin/edit-supplier/' . $products['product_id'] . '"><i class="fa fa-pencil" data-id="{{$products->product_id}}"></i>&nbsp;Edit</a></li>';
                            $action .= '</ul>';
                            $action .= '</div>';
                            return $action;
                        })
                        ->addColumn('product_status', function ($products) {
                            $button = '<td style="text-align: center">';
                            $button .= '<button class="btn btn-success">Deleted Product</button>';
                            $button .= '<td>';
                            return $button;

                        })
                        ->make();
                    break;
                case 'changeProductStatus':
                    $productId = $inputData['productId'];
                    $whereForUpdate = ['rawQuery' => 'product_id =?', 'bindParams' => [$productId]];
                    $dataToUpdate['product_status'] = $inputData['status'];
                    $dataToUpdate['status_set_by'] = $inputData['statussetby'];
                    $dataToUpdate['status_set_by'] = Session::get('fs_admin')['id'];
                    $updateResult = $objModelProducts->updateProductWhere($dataToUpdate, $whereForUpdate);
                    if ($updateResult == 1) {
                        echo json_encode(['status' => 'success', 'msg' => 'Status has been changed . ']);
                    } else {
                        echo json_encode(['status' => 'error', 'msg' => 'Something went wrong, please reload the page and try again . ']);
                    }
                    break;
                case 'pendingProducts':
                    // NORMAL DATATABLE STARTS HERE//
                    $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 0, 0]];
                    $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                    $getAllProducts = $objModelProducts->getAllProducts($where, $selectedColumn);
                    $productInfo = json_decode(json_encode($getAllProducts), true);
                    $products = new Collection();
                    foreach ($productInfo as $key => $val) {
                        $products->push([
                            'product_id' => $val['product_id'],
                            'product_images' => '<img src="' . $val['image_url'] . '" width="30px">',
                            'added_date' => date('d-F-Y', strtotime($val['added_date'])),
                            'shop_name' => $val['shop_name'],
                            'product_name' => $val['product_name'],
                            'price_total' => $val['price_total'],
                            'list_price' => $val['list_price'],
                            'min_qty' => $val['min_qty'],
                            'max_qty' => $val['max_qty'],
                            'category_name' => $val['category_name'],
                            'in_stock' => $val['in_stock'],
                            'username' => $val['username'],
                            'available_countries' => $val['available_countries'],
                            'product_status' => $val['product_status'],
                        ]);
                    }
                    //NORMAL DATATABLE ENDS//

                    // FILTERING STARTS FROM HERE//


                    $filteringRules = '';
                    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                        if ($_REQUEST['product_id'] != '') {
                            $filteringRules[] = "(`products`.`product_id` = " . $_REQUEST['product_id'] . " )";
                        }
                        if ($_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != '') {
                            $filteringRules[] = "(`products`.`added_date` BETWEEN " . strtotime(str_replace('-', ' ', $_REQUEST['date_from'])) . " AND " . strtotime(str_replace('-', ' ', $_REQUEST['date_to'])) . "  )";
                        }
                        if ($_REQUEST['store_name'] != '') {
                            $filteringRules[] = "(`shops`.`shop_name` LIKE '%" . $_REQUEST['store_name'] . "%' )";
                        }
                        if ($_REQUEST['product_name'] != '') {
                            $filteringRules[] = "(`products`.`product_name` LIKE '%" . $_REQUEST['product_name'] . "%' )";
                        }
                        if ($_REQUEST['price_from'] != '' && $_REQUEST['price_to'] != '') {
                            $filteringRules[] = "(`products`.`price_total` BETWEEN " . intval($_REQUEST['price_from']) . " AND " . intval($_REQUEST['price_to']) . "  )";
                        }
                        if ($_REQUEST['list_price_from'] != '' && $_REQUEST['list_price_to'] != '') {
                            $filteringRules[] = "(`products`.`list_price` BETWEEN " . intval($_REQUEST['list_price_from']) . " AND " . intval($_REQUEST['list_price_to']) . "  )";
                        }
                        if ($_REQUEST['minimum_quantity'] != '') {
                            $filteringRules[] = "( `products`.`min_qty` = " . intval($_REQUEST['minimum_quantity']) . ")";
                        }
                        if ($_REQUEST['maximum_quantity'] != '') {
                            $filteringRules[] = "(`products`.`max_qty` = " . intval($_REQUEST['maximum_quantity']) . ")";
                        }
                        if ($_REQUEST['product_categories'] != '') {
                            $filteringRules[] = "(`products`.`category_id` = " . $_REQUEST['product_categories'] . " )";
                        }
                        if ($_REQUEST['added_by'] != '') {
                            $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['added_by'] . "%' )";
                        }
//                        if ($_REQUEST['product_status'] != '') {
//                            $filteringRules[] = "(`products`.`product_status` = " . $_REQUEST['product_status'] . " )";
//                        }

                        // Filter Implode //
                        $implodedWhere = '';
                        if (!empty($filteringRules)) {
                            $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                                return $filterValues;
                            }, $filteringRules));
                        }
                        //   Modify code for filter //
                        $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                        $iDisplayStart = intval($_REQUEST['start']);
                        $sEcho = intval($_REQUEST['draw']);
//                $columns = array('o.order_id', 'o.added_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');
                        $columns = array('products.product_id', 'products.added_date', 'products.product_type', 'users.username', 'shops.shop_name', 'products.product_name', 'products.price_total', 'products.list_price', 'products.min_qty', 'products.max_qty', 'products.category_id', 'products.available_countries', 'products.products_status');
                        $sortingOrder = "";
                        if (isset($_REQUEST['order'])) {
                            $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                        }
                        // End Modify code for filter//
                        if (!empty($implodedWhere)) {
                            $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 0, 0]];
                            $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                            $getAllFilterProducts = $objModelProducts->getAllFilterProducts($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);
                            $productFilter = json_decode(json_encode($getAllFilterProducts), true);
                            $products = new Collection();
                            foreach ($productFilter as $key => $val) {
                                $products->push([
                                    'product_id' => $val['product_id'],
                                    'product_images' => '<img src="' . $val['image_url'] . '" width="80px">',
                                    'added_date' => date('d-F-Y', strtotime($val['added_date'])),
                                    'shop_name' => $val['shop_name'],
                                    'product_name' => $val['product_name'],
                                    'price_total' => $val['price_total'],
                                    'list_price' => $val['list_price'],
                                    'min_qty' => $val['min_qty'],
                                    'max_qty' => $val['max_qty'],
                                    'category_name' => $val['category_name'],
                                    'in_stock' => $val['in_stock'],
                                    'username' => $val['username'],
                                    'available_countries' => $val['available_countries'],
                                    'product_status' => $val['product_status'],
                                ]);
                            }
                        }
                    }

                    // FILTERING ENDS//

                    return Datatables::of($products)
                        ->addColumn('action', function ($products) {
                            $action = '<div role="group" class="btn-group "> <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"> <i class="fa fa-cog"></i>&nbsp; <span class="caret"></span></button>';
                            $action .= '<ul role="menu" class="dropdown-menu">';
                            $action .= '<li><a href="/admin/edit-supplier/' . $products['product_id'] . '"><i class="fa fa-pencil" data-id="{{$products->product_id}}"></i>&nbsp;Edit</a></li>';
                            $action .= '</ul>';
                            $action .= '</div>';
                            return $action;
                        })
                        ->addColumn('product_status', function ($products) {
                            $button = '<td style="text-align: center">';
                            $button .= '<td class="center" style="text-align: center;">';
                            $button .= '<div class="form-group">';
                            $button .= '<select class="form-control" data-id="' . $products['product_id'] . '" id="statuspending" style="width:90%; margin-left: 2%; background-color: orange">';
                            $button .= '<option value="0" selected style="background-color: whitesmoke">Pending</option>';
                            $button .= '<option value="1" style="background-color: whitesmoke">Approved</option>';
                            $button .= '<option value="3" style="background-color: whitesmoke">Rejected</option>';
                            $button .= '</select>';
                            $button .= '</div>';
                            $button .= '<td>';
                            return $button;

                        })
                        ->make();
                    break;
                case 'rejectedProducts':
                    // NORMAL DATATABLE FOR DISPLAY //
                    $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 3, 0]];
                    $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                    $getAllProducts = $objModelProducts->getAllProducts($where, $selectedColumn);
                    $productInfo = json_decode(json_encode($getAllProducts), true);
                    $products = new Collection();
                    foreach ($productInfo as $key => $val) {
                        $products->push([
                            'product_id' => $val['product_id'],
                            'shop_name' => $val['shop_name'],
                            'product_name' => $val['product_name'],
                            'price_total' => $val['price_total'],
                            'list_price' => $val['list_price'],
                            'min_qty' => $val['min_qty'],
                            'max_qty' => $val['max_qty'],
                            'category_name' => $val['category_name'],
                            'in_stock' => $val['in_stock'],
                            'username' => $val['username'],
                            'available_countries' => $val['available_countries'],
                            'product_status' => $val['product_status'],
                        ]);
                    }
                    // NORMAL DATATABLE ENDS HERE//

                    // FILTERING STARTS FROM HERE //
                    $filteringRules = '';
                    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                        if ($_REQUEST['product_id'] != '') {
                            $filteringRules[] = "(`products`.`product_id` = " . $_REQUEST['product_id'] . " )";
                        }
                        if ($_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != '') {
                            $filteringRules[] = "(`products`.`added_date` BETWEEN " . strtotime(str_replace('-', ' ', $_REQUEST['date_from'])) . " AND " . strtotime(str_replace('-', ' ', $_REQUEST['date_to'])) . "  )";
                        }
                        if ($_REQUEST['store_name'] != '') {
                            $filteringRules[] = "(`shops`.`shop_name` LIKE '%" . $_REQUEST['store_name'] . "%' )";
                        }
                        if ($_REQUEST['product_name'] != '') {
                            $filteringRules[] = "(`products`.`product_name` LIKE '%" . $_REQUEST['product_name'] . "%' )";
                        }
                        if ($_REQUEST['price_from'] != '' && $_REQUEST['price_to'] != '') {
                            $filteringRules[] = "(`products`.`price_total` BETWEEN " . intval($_REQUEST['price_from']) . " AND " . intval($_REQUEST['price_to']) . "  )";
                        }
                        if ($_REQUEST['list_price_from'] != '' && $_REQUEST['list_price_to'] != '') {
                            $filteringRules[] = "(`products`.`list_price` BETWEEN " . intval($_REQUEST['list_price_from']) . " AND " . intval($_REQUEST['list_price_to']) . "  )";
                        }
                        if ($_REQUEST['minimum_quantity'] != '') {
                            $filteringRules[] = "( `products`.`min_qty` = " . intval($_REQUEST['minimum_quantity']) . ")";
                        }
                        if ($_REQUEST['maximum_quantity'] != '') {
                            $filteringRules[] = "(`products`.`max_qty` = " . intval($_REQUEST['maximum_quantity']) . ")";
                        }
                        if ($_REQUEST['product_categories'] != '') {
                            $filteringRules[] = "(`products`.`category_id` = " . $_REQUEST['product_categories'] . " )";
                        }
                        if ($_REQUEST['added_by'] != '') {
                            $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['added_by'] . "%' )";
                        }
//                        if ($_REQUEST['product_status'] != '') {
//                            $filteringRules[] = "(`products`.`product_status` = " . $_REQUEST['product_status'] . " )";
//                        }

                        // Filter Implode //
                        $implodedWhere = '';
                        if (!empty($filteringRules)) {
                            $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                                return $filterValues;
                            }, $filteringRules));
                        }
                        //   Modify code for filter //
                        $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                        $iDisplayStart = intval($_REQUEST['start']);
                        $sEcho = intval($_REQUEST['draw']);
//                $columns = array('o.order_id', 'o.added_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');
                        $columns = array('products.product_id', 'products.added_date', 'products.product_type', 'users.username', 'shops.shop_name', 'products.product_name', 'products.price_total', 'products.list_price', 'products.min_qty', 'products.max_qty', 'products.category_id', 'products.available_countries', 'products.products_status');
                        $sortingOrder = "";
                        if (isset($_REQUEST['order'])) {
                            $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                        }
                        // End Modify code for filter//
                        if (!empty($implodedWhere)) {
                            $where = ['rawQuery' => 'products.product_type = ? AND products.product_status = ? AND product_images.image_type = ?', 'bindParams' => [0, 3, 0]];
                            $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                            $getAllFilterProducts = $objModelProducts->getAllFilterProducts($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);
                            print_a($getAllFilterProducts);
                            $productFilter = json_decode(json_encode($getAllFilterProducts), true);
                            $products = new Collection();
                            foreach ($productFilter as $key => $val) {
                                $products->push([
                                    'product_id' => $val['product_id'],
                                    'product_images' => '<img src="' . $val['image_url'] . '" width="30px">',
                                    'added_date' => date('d-F-Y', strtotime($val['added_date'])),
                                    'shop_name' => $val['shop_name'],
                                    'product_name' => $val['product_name'],
                                    'price_total' => $val['price_total'],
                                    'list_price' => $val['list_price'],
                                    'min_qty' => $val['min_qty'],
                                    'max_qty' => $val['max_qty'],
                                    'category_name' => $val['category_name'],
                                    'in_stock' => $val['in_stock'],
                                    'username' => $val['username'],
                                    'available_countries' => $val['available_countries'],
                                    'product_status' => $val['product_status'],
                                ]);
                            }
                        }
                    }

                    // FITERING ENDS//

                    return Datatables::of($products)
                        ->addColumn('action', function ($products) {
                            $action = '<div role="group" class="btn-group "> <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"> <i class="fa fa-cog"></i>&nbsp; <span class="caret"></span></button>';
                            $action .= '<ul role="menu" class="dropdown-menu">';
                            $action .= '<li><a href="/admin/edit-supplier/' . $products['product_id'] . '"><i class="fa fa-pencil" data-id="{{$products->product_id}}"></i>&nbsp;Edit</a></li>';
                            $action .= '</ul>';
                            $action .= '</div>';
                            return $action;
                        })
                        ->addColumn('product_status', function ($products) {
                            $button = '<td style="text-align: center">';
                            $button .= '<button class="btn btn-success">Rejected Product</button>';
                            $button .= '<td>';
                            return $button;
                        })
                        ->make();
                    break;
                case 'getActiveCategories':
                    $where = ['rawQuery' => 'category_status = ?', 'bindParams' => [1]];
                    $selectedColumn = ['category_id', 'category_name', 'category_status', 'for_shop_id'];
                    $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where, $selectedColumn);
                    if (!empty($allactivecategories)) {
                        $response['code'] = 200;
                        $response['message'] = 'data';
                        $response['data'] = $allactivecategories;
//                        echo json_encode($allactivecategories);
                    } else {
                        echo 0;
                    }
                    break;
                default:
                    break;
            }
        }
        echo json_encode($response, true);
        die;
    }


    public function productListAjaxHandler(Request $request, $method)
    {

        $inputData = $request->input();
        $objModelProducts = Products::getInstance();
        $objCategoryModel = ProductCategory::getInstance();
        $supplierId = Session::get('fs_supplier')['id'];
        switch ($method) {

            case 'manageProducts':
                //   Modify code for filter //
                $iTotalRecords = $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);
                $sEcho = intval($_REQUEST['draw']);
//                $columns = array('o.order_id', 'o.added_date', 'customer_email', 'product_name', 'o.finalprice', 't.tx_type', 'o.order_status');
                $columns = array('products.product_id', 'products.added_date', 'products.product_type', 'users.username', 'shops.shop_name', 'products.product_name', 'products.price_total', 'products.list_price', 'products.min_qty', 'products.max_qty', 'products.category_id', 'products.available_countries', 'products.products_status');
                $sortingOrder = "";
                if (isset($_REQUEST['order'])) {
                    $sortingOrder = $columns[$_REQUEST['order'][0]['column']];
                }
                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {

                    if ($_REQUEST['customActionValue'] != '' && !empty($_REQUEST['productId'])) {

                        $statusData['product_status'] = $_REQUEST['customActionValue'];
                        $whereForStatusUpdate = ['rawQuery' => 'product_id IN (' . implode(',', $_REQUEST['productId']) . ')'];
                        $updateResult = $objModelProducts->updateProductWhere($statusData, $whereForStatusUpdate);
                        if ($updateResult) {
                            //NOTIFICATION TO USER FOR ORDER STATUS CHANGE
                            $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                            $records["customActionMessage"] = "Group action successfully has been completed."; // pass custom message(useful for getting status of group actions)
                        }
                    }
                }
                // End Modify code for filter//
                // NORMAL DATATABLE CODE STARTS//
                $where = ['rawQuery' => 'products.product_type = ? AND products.product_status IN (0,1,2,3,4) AND product_images.image_type = ?', 'bindParams' => [0, 0]];
                $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                $getAllProducts = $objModelProducts->getAllProducts($where, $selectedColumn);
                $productInfo = json_decode(json_encode($getAllProducts), true);
                $products = new Collection();
                foreach ($productInfo as $key => $val) {
                    $products->push([
                        'checkbox' => '<input type="checkbox" name="id[]" value="' . $val['product_id'] . '">',
                        'product_id' => $val['product_id'],
                        'product_images' => '<img src="' . $val['image_url'] . '" width="30px">',
                        'added_date' => date('d-F-Y', ($val['added_date'])),
                        'shop_name' => $val['shop_name'],
                        'product_name' => $val['product_name'],
                        'price_total' => $val['price_total'],
                        'list_price' => $val['list_price'],
                        'min_qty' => $val['min_qty'],
                        'max_qty' => $val['max_qty'],
                        'category_name' => $val['category_name'],
                        'in_stock' => $val['in_stock'],
                        'username' => $val['username'],
                        'available_countries' => $val['available_countries'],
                        'product_status' => $val['product_status'],
                    ]);
                }

                // FILTERING STARTS FROM HERE //
                $filteringRules = '';
                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'filter' && $_REQUEST['action'][0] != 'filter_cancel') {

                    if ($_REQUEST['product_id'] != '') {
                        $filteringRules[] = "(`products`.`product_id` = " . $_REQUEST['product_id'] . " )";
                    }
                    if ($_REQUEST['date_from'] != '' && $_REQUEST['date_to'] != '') {
                        $filteringRules[] = "(`products`.`added_date` BETWEEN " . strtotime(str_replace('-', ' ', $_REQUEST['date_from'])) . " AND " . strtotime(str_replace('-', ' ', $_REQUEST['date_to'])) . "  )";
                    }
                    if ($_REQUEST['store_name'] != '') {
                        $filteringRules[] = "(`shops`.`shop_name` LIKE '%" . $_REQUEST['store_name'] . "%' )";
                    }
                    if ($_REQUEST['product_name'] != '') {
                        $filteringRules[] = "(`products`.`product_name` LIKE '%" . $_REQUEST['product_name'] . "%' )";
                    }
                    if ($_REQUEST['price_from'] != '' && $_REQUEST['price_to'] != '') {
                        $filteringRules[] = "(`products`.`price_total` BETWEEN " . intval($_REQUEST['price_from']) . " AND " . intval($_REQUEST['price_to']) . "  )";
                    }
                    if ($_REQUEST['list_price_from'] != '' && $_REQUEST['list_price_to'] != '') {
                        $filteringRules[] = "(`products`.`list_price` BETWEEN " . intval($_REQUEST['list_price_from']) . " AND " . intval($_REQUEST['list_price_to']) . "  )";
                    }
                    if ($_REQUEST['minimum_quantity'] != '') {
                        $filteringRules[] = "( `products`.`min_qty` = " . intval($_REQUEST['minimum_quantity']) . ")";
                    }
                    if ($_REQUEST['maximum_quantity'] != '') {
                        $filteringRules[] = "(`products`.`max_qty` = " . intval($_REQUEST['maximum_quantity']) . ")";
                    }
                    if ($_REQUEST['product_categories'] != '') {
                        $filteringRules[] = "(`products`.`category_id` = " . $_REQUEST['product_categories'] . " )";
                    }
                    if ($_REQUEST['added_by'] != '') {
                        $filteringRules[] = "(`users`.`username` LIKE '%" . $_REQUEST['added_by'] . "%' )";
                    }
                    if ($_REQUEST['product_status'] != '') {
                        $filteringRules[] = "(`products`.`product_status` = " . $_REQUEST['product_status'] . " )";
                    }
//print_a($filteringRules);
                    // Filter Implode //
                    $implodedWhere = '';
                    if (!empty($filteringRules)) {
                        $implodedWhere = implode(' AND ', array_map(function ($filterValues) {
                            return $filterValues;
                        }, $filteringRules));
                    }
                    if (!empty($implodedWhere)) {
                        $where = ['rawQuery' => 'products.product_type = ? AND products.product_status IN (0,1,2,3,4) AND product_images.image_type = ?', 'bindParams' => [0, 0]];
                        $selectedColumn = ['products.*', 'users.username', 'users.role', 'shops.shop_name', 'product_categories.category_name', 'product_images.image_url'];
                        $getAllFilterProducts = $objModelProducts->getAllFilterProducts($where, $implodedWhere, $sortingOrder, $iDisplayLength, $iDisplayStart, $selectedColumn);

                        $productFilter = json_decode(json_encode($getAllFilterProducts), true);
                        $products = new Collection();
                        foreach ($productFilter as $key => $val) {
                            $products->push([
                                'checkbox' => '<input type="checkbox" name="id[]" value="' . $val['product_id'] . '">',
                                'product_id' => $val['product_id'],
                                'product_images' => '<img src="' . $val['image_url'] . '" width="80px">',
                                'added_date' => date('d-F-Y', ($val['added_date'])),
                                'shop_name' => $val['shop_name'],
                                'product_name' => $val['product_name'],
                                'price_total' => $val['price_total'],
                                'list_price' => $val['list_price'],
                                'min_qty' => $val['min_qty'],
                                'max_qty' => $val['max_qty'],
                                'category_name' => $val['category_name'],
                                'in_stock' => $val['in_stock'],
                                'username' => $val['username'],
                                'available_countries' => $val['available_countries'],
                                'product_status' => $val['product_status'],
                            ]);
                        }
                    }
                }
                $status_list = array(
                    0 => array("warning" => "Pending"),
                    1 => array("success" => "Success"),
                    2 => array("primary" => "InActive"),
                    3 => array("warning" => "Rejected"),
                    4 => array("danger" => "Deleted"),
                    5 => array("danger" => "Finished"),
                );
                return Datatables::of($products, $status_list)
                    ->addColumn('action', function ($products) {
                        $action = '<div role="group" class="btn-group "> <button aria-expanded="false" data-toggle="dropdown" class="btn btn-default dropdown-toggle" type="button"> <i class="fa fa-cog"></i>&nbsp; <span class="caret"></span></button>';
                        $action .= '<ul role="menu" class="dropdown-menu">';
                        $action .= '<li><a href="/admin/edit-supplier/' . $products['product_id'] . '"><i class="fa fa-pencil" data-id="{{$products->product_id}}"></i>&nbsp;Edit</a></li>';
                        $action .= '<li><a href="javascript:void(0);" class="delete-product" data-cid="' . $products['product_id'] . '"><i class="fa fa-trash"></i>&nbsp;Delete</a></li>';
                        $action .= '</ul>';
                        $action .= '</div>';
                        return $action;
                    })
                    ->addColumn('product_status', function ($products) use ($status_list) {
                        return '<span class="label label-sm label-' . (key($status_list[$products['product_status']])) . '">' . (current($status_list[$products['product_status']])) . '</span>';

                    })
                    ->make();
                // NORMAL DATATABLE CODE END'S HERE//
                break;


        }

    }

    public function deletedProducts(Request $request)
    {
        $objCategoryModel = ProductCategory::getInstance();

        $where = ['rawQuery' => '1'];
        $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where);

        return view('Admin/Views/product/deletedProducts', ['allCategories' => $allactivecategories]);

    }

    public function pendingProducts(Request $request)
    {

        $objCategoryModel = ProductCategory::getInstance();
        $where = ['rawQuery' => '1'];
        $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where);

        return view('Admin/Views/product/pendingProducts', ['allCategories' => $allactivecategories]);

    }

    public function rejectedProducts(Request $request)
    {

        $objCategoryModel = ProductCategory::getInstance();

        $where = ['rawQuery' => '1'];
        $allactivecategories = $objCategoryModel->getAllCategoriesWhere($where);
        return view('Admin/Views/product/rejectedProducts', ['allCategories' => $allactivecategories]);
    }

    public function editProduct(Request $request, $productId)
    {
        $temp = [
            "cacheid" => "testcacheid1",
            "testsdata" => [
                [
                    "lessonid" => "1",
                    "drills" => [
                        ["drillid" => "1", "result_ids" => "1,2,3"],
                        ["drillid" => "2", "result_ids" => "4"]
                    ]
                ],
                [
                    "lessonid" => "2",
                    "drills" => [
                        ["drillid" => "1", "result_ids" => "1,2,3"],
                        ["drillid" => "2", "result_ids" => "4"]
                    ]
                ]
            ]
        ];

        dd(json_encode($temp, true));;
        die;

        //GET from product            //GET from productmeta
        $objModelProducts = Products::getInstance();
        $whereForProduct = ['rawQuery' => 'products.product_id = ?', 'bindParams' => [$productId]];
        $productData = json_decode($objModelProducts->getProductWhere($whereForProduct), true);

        if (!empty($productData['data'])) {


            $objModelCategory = ProductCategory::getInstance();
            $objModelFeatures = ProductFeatures::getInstance();
            $objModelProductMeta = ProductMeta::getInstance();
            $objModelProductImage = ProductImage::getInstance();
            $objModelProductOption = ProductOption::getInstance();
            $objModelProductOptionVariant = ProductOptionVariant::getInstance();
            $objModelProductOptionVariantRelation = ProductOptionVariantRelation::getInstance();
            $objModelProductFeatureVariantRelation = ProductFeatureVariantRelation::getInstance();
            $objModelProductOptVarCombination = ProductOptionVariantsCombination::getInstance();
            $objModelProductFeature = ProductFeatures::getInstance();

            $userId = Session::get('fs_admin')['id'];

            $whereForCat = ['rawQuery' => 'category_status =?', 'bindParams' => [1]];
            $allCategories = $objModelCategory->getAllCategoriesWhere($whereForCat);

            $whereForFeatureGroup = ['rawQuery' => 'group_flag =? and status = ?', 'bindParams' => [1, 1]];
            $allFeatureGroups = $objModelFeatures->getAllFeaturesWhere($whereForFeatureGroup);

            //GET from product_feature_variant_relation
            $catId = (int)$productData['data']['category_id'];
            $catFlag = true;
            $parentCategory = array();
            $count = 1;
            $bindParamsForFeature = array();
            $queryForFeature = "";
            $queryForFeatureGroup = "";
            while ($catFlag) {
                if ($count == 1) {
                    $queryForFeatureGroup = '(product_features.group_flag = 1) and (product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ?';
                    $queryForFeature = '(group_flag = 0 and parent_id = 0) and (for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ?';
                } else {
                    $count++;
                    $catId = $parentCategory['category_id'];
                    $queryForFeatureGroup .= 'OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ? OR product_features.for_categories LIKE ?';
                    $queryForFeature .= 'OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ? OR for_categories LIKE ?';
                }
                array_push($bindParamsForFeature, "%,$catId");
                array_push($bindParamsForFeature, "%,$catId,%");
                array_push($bindParamsForFeature, "$catId,%");
                array_push($bindParamsForFeature, "$catId");
                $parentCategory = array();
                $whereForCat = ['rawQuery' => 'parent_category_id = ?', "bindParams" => [$catId]];
                $parentCategory = $objModelCategory->getCategoryDetailsWhere($whereForCat);
                if (!$parentCategory) {
                    $catFlag = false;
                }
            }
            $queryForFeature .= ")";
            $queryForFeatureGroup .= ")";
            $whereForFeature = ['rawQuery' => $queryForFeature, 'bindParams' => $bindParamsForFeature];
            $featureDetails = json_decode($objModelProductFeature->getAllFeaturesWithVariantsWhere($whereForFeature), true);
//            $featureDetails = json_decode($objModelProductFeature->getAllFeaturesWithFVRelationWhere($whereForFeature), true);
            $whereForFeatureGroup = ['rawQuery' => $queryForFeatureGroup, 'bindParams' => $bindParamsForFeature];
            $featureGroups = json_decode($objModelProductFeature->getAllFGsWithFsWhere($whereForFeatureGroup), true);
            foreach ($featureGroups['data'] as $keyFG => $valueFG) {
                $whereForFs = ['rawQuery' => "product_features.parent_id IN (?)", "bindParams" => [$valueFG['feature_ids']]];
                $featureGroups['data'][$keyFG]['featureDetails'] = json_decode($objModelProductFeature->getAllFeaturesWithVariantsWhere($whereForFs), true)['data'];
            }
            $whereForFVRelation = ['rawQuery' => "product_id = ?", 'bindParams' => [$productId]];
            $fvRelations = $objModelProductFeatureVariantRelation->getAllFeatureVariantRelationsWhere($whereForFVRelation);
//            dd($fvRelations);

            $response['code'] = $featureDetails['code'];
            $response['message'] = $featureDetails['message'];
            $response['data']['featureDetails'] = $featureDetails['data'];
            $response['data']['featureGroupDetails'] = $featureGroups['data'];

            //GET from options
            $whereForOptions = ['rawQuery' => 'status = 1'];
            $allOptions = $objModelProductOption->getAllOptionsWhere($whereForOptions);

            //GET from option_variants
//            $objModelProductOptionVariant->getVariants

            //GET from option_variant_relation
            $whereForOptVar = ['rawQuery' => "1"];//product_id = ?", 'bindParams' => [$productId]];
            $whereForJoin = ['column' => 'product_id', 'condition' => '=', 'value' => "$productId"];
            $dataOptVarWithRelations = json_decode($objModelProductOptionVariant->getOptionVarWithRelationsWhere($whereForOptVar, ['*'], $whereForJoin), true);
//            dd(json_decode($dataOptVarWithRelations, true));//$objModelProductOptionVariantRelation

            //GET from option_variants_combination
            $whereForOptVarCombinations = ['rawQuery' => "product_id = ?", 'bindParams' => [$productId]];
            $dataOptVarCombs = json_decode($objModelProductOptVarCombination->getAllCombinationsWhere($whereForOptVarCombinations), true);
//            dd(json_decode($dataOptVarCombs, true));//$objModelProductOptionVariantRelation

            //GET from product_images
            $whereForImages = ['rawQuery' => 'for_product_id = ? and for_combination_id = ?', 'bindParams' => [$productId, 0]];
            $dataDefaultImages = json_decode($objModelProductImage->getAllImagesWhere($whereForImages), true);
//            dd($dataImages);

            if ($request->isMethod('post')) {

                dd($request);
//            $inputData = $request->input('product_data');//Excludes image
                $inputData = $request->all()['product_data'];//Includes image

//            print_a($inputData['options']);
//            print_a($_FILES);

                $returnData = ['code' => 400, "message" => "Nothing to update.", "data" => null];
                if (isset($inputData['updateFormName'])) {
                    $updateFormName = $inputData['updateFormName'];
                    $errors = array();

                    switch ($updateFormName) {
                        case "general":
                            $rules = [
                                'product_name' => 'required',//TODO need more validation here for duplicate check
                                'price' => 'required',
                                'in_stock' => 'required',
                                'comment' => 'max:100',
                            ];
                            $messages = array();
                            $validator = Validator::make($inputData, $rules, $messages);
                            if ($validator->fails()) {
                                return Redirect::back()
                                    ->with(["code" => 400, "status" => 'error', 'message' => 'Please correct the following errors.'])
                                    ->withErrors($validator)
                                    ->withInput();
                            } else {

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
                                $returnData = $objModelProducts->updateProductsWhere($productData);
//                                $returnData['code'] = 200;
//                                $returnData['message'] = "General details saved successfully";
//                                $returnData['data'] = null;
                            }

                            //--------------------------PRODUCT-METADATA----------------------------//
                            $productMetaData['product_id'] = $productId;
                            $productMetaData['full_description'] = trim($inputData['full_description']);
                            $productMetaData['short_description'] = trim($inputData['short_description']);

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

                            //------------------------PRODUCT FEATURES START HERE---------------------//
                            if (array_key_exists('features', $inputData)) {
                                $productDataFeatures = $inputData['features'];
                                $fvrDataToInsert = array();
                                foreach ($productDataFeatures as $keyPDF => $valuePDF) {
                                    if (array_key_exists("single", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => 0, 'display_status' => $productDataFeatures[$keyPDF]['status']];
                                        $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => 0, 'display_status' => $productDataFeatures[$keyPDF]['status']]);
                                    } else if (array_key_exists("muliple", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => implode(",", array_keys($valuePDF['multiple'])), 'display_status' => $valuePDF['status']];
                                        $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => implode(",", array_keys($valuePDF['multiple'])), 'display_status' => $valuePDF['status']]);
                                    } else if (array_key_exists("select", $productDataFeatures[$keyPDF])) {
//                            $fvrDataToInsert[] = ['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => $valuePDF['select'], 'display_status' => $valuePDF['status']];
                                        $objModelProductFeatureVariantRelation->addFeatureVariantRelation(['product_id' => $insertedProductId, 'feature_id' => $keyPDF, 'variant_ids' => "" . $valuePDF['select'], 'display_status' => $valuePDF['status']]);
                                    }
                                }
//                    $objModelProductFeatureVariantRelation->addFeatureVariantRelation($fvrDataToInsert);
                            }
                            //------------------------PRODUCT FEATURES END HERE---------------------//

                            break;

                        //TODO update main image here

                        case "images":
                            $rules = [
                                'mainimage' => 'image|mimes:jpeg,bmp,png|max:1000'
                            ];
                            $messages['mainimage.image'] = 'Only jpg, jpeg, gif images allowed for upload.';
                            $validator = Validator::make($inputData, $rules, $messages);
                            if ($validator->fails()) {
                                return Redirect::back()
                                    ->with(["code" => 400, "status" => 'error', 'message' => 'Please correct the following errors.'])
                                    ->withErrors($validator)
                                    ->withInput();
                            } else {
                                //TODO update otherimages here
                                //----------------------------PRODUCT-IMAGES------------------------------//
                                $productImages = $_FILES['product_data'];
                                $imageData = array();
                                if ($productImages['error']['mainimage'] == 0) {
                                    $mainImageURL = uploadImageToStoragePath($productImages['tmp_name']['mainimage'], 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_0_' . time() . '.jpg', 724, 1024);
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
                                            $otherImageURL = uploadImageToStoragePath($otherImage, 'product_' . $insertedProductId, 'product_' . $insertedProductId . '_' . ($otherImageKey + 1) . '_' . time() . '.jpg', 724, 1024);
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

                                $returnData['code'] = 200;
                                $returnData['message'] = "Images updated successfully";
                                $returnData['data'] = null;
                            }
                            break;

                        case "options":
                            $rules = [
                                'mainimage' => 'image|mimes:jpeg,bmp,png|max:1000'
                            ];
                            $messages['mainimage.image'] = 'Only jpg, jpeg, gif images allowed for upload.';
                            $validator = Validator::make($inputData, $rules, $messages);
                            if ($validator->fails()) {
                                return Redirect::back()
                                    ->with(["code" => 400, "status" => 'error', 'message' => 'Please correct the following errors.'])
                                    ->withErrors($validator)
                                    ->withInput();
                            } else {
                                //TODO options code here
                                if (array_key_exists('options', $inputData)) {
                                    $finalOptionVariantRelationData = array();
                                    $varDataForCombinations = array();
                                    foreach ($inputData['options'] as $key => $optionValue) {
                                        $optionVariantRelationData['product_id'] = $insertedProductId;
                                        $optionVariantRelationData['option_id'] = $optionValue['option_id'];
                                        $optionVariantRelationData['status'] = $optionValue['status'];

                                        $tempOptionVariantData = array();
                                        $variantIds = array();
                                        //-------------------------OLD OPTION VARIANT START-----------------------//
                                        /*
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
                                        */
                                        //-------------------------OLD OPTION VARIANT END-----------------------//

                                        //-------------------------NEW OPTION VARIANT START---------------------//
                                        if (array_key_exists('variantData', $optionValue)) {
                                            foreach ($optionValue['variantData'] as $variantKey => $variantValue) {
                                                $temp = array();
                                                array_push($variantIds, $variantValue['variant_id']);
                                                $temp['VID'] = $variantValue['variant_id'];
                                                $temp['VN'] = $variantValue['variant_name'];
                                                $temp['PM'] = $variantValue['price_modifier'];
                                                $temp['PMT'] = $variantValue['price_modifier_type'];
                                                $temp['WM'] = $variantValue['weight_modifier'];
                                                $temp['WMT'] = $variantValue['weight_modifier_type'];
                                                $temp['STTS'] = $variantValue['status'];
                                                $tempOptionVariantData[] = $temp;
                                            }
                                        }
                                        if (array_key_exists('variantDataNew', $optionValue)) {
                                            foreach ($optionValue['variantDataNew'] as $variantKey => $variantValue) {
                                                $temp = array();
                                                $variantData['option_id'] = $optionValue['option_id'];
                                                $variantData['variant_name'] = $variantValue['variant_name'];
                                                $variantData['added_by'] = $userId;
                                                $variantData['status'] = $variantValue['status'];
                                                $variantData['created_at'] = NULL;
                                                $insertedVariantId = $objModelProductOptionVariant->addNewVariantAndGetID($variantData);
                                                if ($insertedVariantId > 0) {
                                                    $varDataForCombinations[$variantValue['variant_id']] = $insertedVariantId;
                                                    array_push($variantIds, $insertedVariantId);
                                                    $temp['VID'] = $insertedVariantId;
                                                    $temp['VN'] = $variantValue['variant_name'];
                                                    $temp['PM'] = $variantValue['price_modifier'];
                                                    $temp['PMT'] = $variantValue['price_modifier_type'];
                                                    $temp['WM'] = $variantValue['weight_modifier'];
                                                    $temp['WMT'] = $variantValue['weight_modifier_type'];
                                                    $temp['STTS'] = $variantValue['status'];
                                                }
                                                $tempOptionVariantData[] = $temp;
                                            }
                                        }
                                        if (!empty($variantIds) && !empty($tempOptionVariantData)) {
                                            $optionVariantRelationData['variant_ids'] = implode(',', $variantIds);
                                            $optionVariantRelationData['variant_data'] = json_encode($tempOptionVariantData);
                                        }
                                        //-------------------------NEW OPTION VARIANT END---------------------//

                                        $finalOptionVariantRelationData[] = $optionVariantRelationData;
                                    }
                                    if (!empty($finalOptionVariantRelationData)) {
                                        $objModelProductOptionVariantRelation->addNewOptionVariantRelation($finalOptionVariantRelationData);
                                    }

                                    //------------------------PRODUCT OPTION COMBINATIONS START HERE---------------------//
                                    foreach ($inputData['opt_combination'] as $keyCombination => $valueCombination) {
                                        $flags = explode("_", $valueCombination['newflag']);
                                        $combinationVarIds = explode("_", $keyCombination);
                                        $flagKeys = array_keys($flags, "1");
                                        foreach ($flagKeys as $keyFK => $valueFK) {
                                            $combinationVarIds[$keyFK] = $varDataForCombinations[$combinationVarIds[[$keyFK]]];
                                        }
                                        //TODO ADD BARCODE, shippig info and image data for the combination here
                                        $dataCombinations['product_id'] = $insertedProductId;
                                        $dataCombinations['variant_ids'] = implode("_", $combinationVarIds);
                                        $dataCombinations['quantity'] = $valueCombination['quantity'];
                                        $dataCombinations['exception_flag'] = 0;
                                        if (isset($valueCombination['excludeflag']) && $valueCombination['excludeflag'] == 'on') {
                                            $dataCombinations['exception_flag'] = 1;
                                        }
                                        $objModelProductOptVarCombination->addNewOptionVariantsCombination($dataCombinations);

                                    }
                                    //------------------------PRODUCT OPTION COMBINATIONS END HERE---------------------//

                                }


                                $returnData['code'] = 200;
                                $returnData['message'] = "Options saved successfully";
                                $returnData['data'] = null;
                            }
                            break;

                        /* case "features":
                            $returnData['code'] = 200;
                            $returnData['message'] = "Features saved successfully";
                            $returnData['data'] = null;
                            break; */

                        case "filters":
                            $rules = [
                                'mainimage' => 'image|mimes:jpeg,bmp,png|max:1000'
                            ];
                            $messages['mainimage.image'] = 'Only jpg, jpeg, gif images allowed for upload.';
                            $validator = Validator::make($inputData, $rules, $messages);
                            if ($validator->fails()) {
                                return Redirect::back()
                                    ->with(["code" => 400, "status" => 'error', 'message' => 'Please correct the following errors.'])
                                    ->withErrors($validator)
                                    ->withInput();
                            } else {
                                $returnData['code'] = 200;
                                $returnData['message'] = "Filters saved successfully";
                                $returnData['data'] = null;
                            }
                            break;

                        case "tabs":
                            $rules = [
                                'mainimage' => 'image|mimes:jpeg,bmp,png|max:1000'
                            ];
                            $messages['mainimage.image'] = 'Only jpg, jpeg, gif images allowed for upload.';
                            $validator = Validator::make($inputData, $rules, $messages);
                            if ($validator->fails()) {
                                return Redirect::back()
                                    ->with(["code" => 400, "status" => 'error', 'message' => 'Please correct the following errors.'])
                                    ->withErrors($validator)
                                    ->withInput();
                            } else {
                                $returnData['code'] = 200;
                                $returnData['message'] = "Tab details saved successfully";
                                $returnData['data'] = null;
                            }
                            break;

                        default:

                            break;
                    }
                }
            }
            foreach ($allCategories as $key => $value) {
                $allCategories[$key]->display_name = $this->getCategoryDisplayName($value->category_id);
            }
            return view('Admin/Views/product/editProduct', ['code' => '', 'allCategories' => $allCategories, 'allOptions' => $allOptions, 'featureGroups' => json_decode($allFeatureGroups, true), 'productData' => $productData['data'], 'dataOptVarWithRelations' => $dataOptVarWithRelations, 'dataOptVarCombs' => $dataOptVarCombs, 'dataDefaultImages' => $dataDefaultImages]);
        } else {
            return view('Admin/Views/product/editProduct', ['code' => '400', 'message' => 'No such product exists.', 'productData' => array()]);
        }

    }


}
