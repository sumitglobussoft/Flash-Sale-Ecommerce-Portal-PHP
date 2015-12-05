<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductImages extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pi_id', 'for_product_id', 'image_type', 'images_upload_type', 'image_url'];


    public function getProductimagesWhere() {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            try {
                $result = DB::table("product_images")
                    ->select()
                    ->where($productId)
                    ->get();
            }catch (QueryException $e){
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

