<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Productmeta extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'productmeta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['productmeta_id', 'product_id', 'color_id', 'sizing_id', 'quantity_total', 'quantity_sold', 'barcode_gtin', 'barcode_upc', 'barcode_ean', 'price', 'sale_price'];


    public function getProductsizeDetails()
    {
        if (func_num_args() > 0) {
            $productId = func_get_arg(0);
            try {
                $result = DB::table("products")
                    ->select()
                    ->where("p.product_id='" . $productId . "' and p.productmeta_status=1")
                    ->joinleft(array('ps' => 'product_sizing'), 'p.sizing_id = ps.sizing_id')
                    ->joinleft(array('pc' => 'product_colors'), 'p.color_id = pc.color_id')
                    ->where("ps.sizing_status=1 or p.sizing_id=0")
                    ->where("pc.color_status=1 or pc.color_id=0");
                    
//            echo $select;die;
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

