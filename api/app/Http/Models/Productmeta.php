<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;


class Productmeta extends Model

{

    private static $_instance = null;
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

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Productmeta();
        return self::$_instance;
    }
    /**
     * Get product sizing ,color details and campaign details discount from product meta by product id
     * @return int
     * @throws Exception
     * @author Vini Dubey <vinidubey@globussoft.com>
     * @since 07-12-2015
     */

    public function getProductsizeDetails()
    {
        if (func_num_args() > 0) {
            $productmetaId = func_get_arg(0);
            try {
                $result = DB::table("productmeta")
                    ->select()
                    ->where('productmeta.product_id', $productmetaId)
                    ->where('productmeta.productmeta_status', 1)
                    ->join('products', 'products.product_id', '=', 'productmeta.product_id')
                    ->leftJoin('Campaigns', function ($join) {
                        $join->on('productmeta.product_id', '=', 'Campaigns.for_product_ids');
                    })
                    ->where('Campaigns.for_product_ids', 'LIKE', '%' . $productmetaId . '%')
                    ->leftJoin('product_sizing', function ($join) {
                        $join->on('productmeta.sizing_id', '=', 'product_sizing.sizing_id')
                            ->where('product_sizing.sizing_status', '=', 1);
                    })
                    ->leftJoin('product_colors', function ($join) {
                        $join->on('productmeta.color_id', '=', 'product_colors.color_id')
                            ->where('product_colors.color_status', '=', 1);
                    })
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

