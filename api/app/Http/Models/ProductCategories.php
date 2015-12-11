<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductCategories extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'category_name', 'created_by', 'category_status', 'status_set_by', 'parent_category_id','for_shop_id','category_banner_url','page_title','meta_description','meta_keywords'];

    public function getCategoriesWhere(){

        if (func_num_args() > 0) {
            $categoryId = func_get_arg(0);
            try {
                $result = DB::table("product_categories")
                    ->select()
                    ->whereIn('category_id', $categoryId)
                    ->where('category_status', 1)
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