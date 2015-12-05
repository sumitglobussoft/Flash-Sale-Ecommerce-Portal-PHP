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
    protected $fillable = ['product_id', 'for_shop_id','product_name','product_description','category_id','brand_id','for_gender','for_age_group_id','delivery_price_type','delivery_price','estimated_deliver_time','added_date','added_by','product_status','status_set_by','material_ids','pattern_ids','available_countries','page_title','meta_description','meta_keywords'];


    public function getProductDetailsWhere() {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table("products")
                    ->select()
                    ->where($where)
                    ->where("p.product_status=1")
                    ->join(array('s' => 'shop'), "p.for_shop_id=s.shop_id and s.shop_status = 1", array('s.shop_name'));
                 //   ->join(array('pm' => 'product_materials'),"pm.pm_id=p.material_ids",array('pm.material_name'));
            }catch (QueryException $e){
                echo $e;
            }
            echo'<prer>';print_r($result);di("xdgs");
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }
    }

}

