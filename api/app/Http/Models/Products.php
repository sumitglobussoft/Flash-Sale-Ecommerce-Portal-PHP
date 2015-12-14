<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Products extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_id', 'for_shop_id', 'product_name', 'product_description', 'category_id', 'brand_id', 'for_gender', 'for_age_group_id', 'delivery_price_type', 'delivery_price', 'estimated_deliver_time', 'added_date', 'added_by', 'product_status', 'status_set_by', 'material_ids', 'pattern_ids', 'available_countries', 'page_title', 'meta_description', 'meta_keywords'];


    public function getProductDetailsWhere()
    {
        if (func_num_args() > 0) {
            $productID = func_get_arg(0);
//              echo"<pre>";print_r($where);die("fvgj");
            try {
                $result = DB::table("products")
                    ->select('products.product_id', 'product_name', 'product_description', 'brand_id', 'for_gender', 'for_age_group_id', 'delivery_price_type', 'delivery_price', 'estimated_delivery_time', 'product_status', 'material_ids', 'pattern_ids', 'tag_ids', 'available_countries', 'shop_name', 'shop_id', 'category_name', 'discount_type', 'discount_value', 'available_from', 'available_upto', 'campaign_name', 'campaign_type', 'price', 'sale_price', 'productmeta.sizing_id', 'productmeta.color_id', 'product_sizing.sizing_name', 'product_colors.color_name')
                    ->where('products.product_id', $productID)
                    ->where('products.product_status', 1)
                    ->leftjoin('shops', 'products.for_shop_id', '=', 'shops.shop_id')
                    ->orWhere('shops.shop_status', 1)
                    ->join('product_categories', 'products.category_id', '=', 'product_categories.category_id')
                    ->leftJoin('Campaigns', function ($join) {
                        $join->on('products.product_id', '=', 'Campaigns.for_product_ids');
                    })
                    ->where('products.product_id', 'LIKE', '%' . $productID . '%')
                    ->leftJoin('productmeta', 'productmeta.product_id', '=', 'products.product_id')
                    ->orderBy('productmeta.product_id', 'asc')
                    ->leftJoin('product_sizing', function ($join) {
                        $join->on('productmeta.sizing_id', '=', 'product_sizing.sizing_id')
                            ->where('product_sizing.sizing_status', '=', 1);
                    })
                    ->leftJoin('product_colors', function ($join) {
                        $join->on('productmeta.color_id', '=', 'product_colors.color_id')
                            ->where('product_colors.color_status', '=', 1);

                    })
                    //      ->join('product_materials', 'product_materials.pm_id', '=', 'SUBSTRING_INDEX(`products`.`products.material_ids`, ",", 1)')
                    //   ->join('product_materials', 'product_materials.pm_id', '=', 'products.material_ids')
                    // ->where('products.material_ids (IN)',join('product_materials', 'product_materials.pm_id', '=', 'products.material_ids'))
                    //   ->join('product_patterns', 'product_patterns.pp_id', '=', 'products.pattern_ids')
                    //   ->join('product_tags', 'product_tags.ptag_id', '=', 'products.tag_ids')
                    //   ->orWhere('product_materials.material_status', 1)
                    //   ->orWhere('product_patterns.pattern_status', 1)
                    //   ->orWhere('product_tags.tag_status', 1)
                    //  ->whereIn('products.material_ids')
                    //   ->whereNull('products.material_ids')
                    //   ->whereNull('products.pattern_ids')
                    //  ->whereNull('products.tag_ids')
                    ->get();
//                   echo $result;die;
//                echo "<pre>";
//                print_r($result);
//                echo "</pre>";
//                die("xdgsv");
            } catch (QueryException $e) {
                echo $e;
            }
            //   echo'<pre>';print_r($result);die("xdgs");
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }
    }

    /**
     * @return int
     */

    public function getProductWhere()
    {

        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            try {
                $result = DB::table("products")
                    ->select()
                    ->whereIn('product_id', $productId)
                    ->where('product_status', 1)
                    ->get();

            } catch (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }

        }
    }


}

