<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductOptionVariants extends Model

{
    private static $_instance = null;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_option_variants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['variant_id', 'option_id', 'variant_name', 'price_modifier', 'price_modifier_type', 'weight_modifier', 'weight_modifier_type', 'added_by', 'updated_at', 'created_at', 'status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOptionVariants();
        return self::$_instance;
    }

    public function getOptionVariantsInfo($where,$selectedColumn = ['*']){

        try {
            $result = DB::table($this->table)
                ->join('product_options', 'product_options.option_id', '=', 'product_option_variants.option_id')
                ->select($selectedColumn)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->get();
            return $result;
        } catch
        (QueryException $e) {
            echo $e;
        }
    }

    public function getOptionVariantDetailsForPopup($where,$selectedColumn = ['*']){

        try {
            $result = DB::table($this->table)
//                ->join('product_images', 'product_images.for_product_id', '=', 'products.product_id')
                ->leftJoin('product_option_variant_relation as product_option_variant_relation', function ($join) {
                    $join->on('product_option_variants.variant_id', '=',  DB::raw('SUBSTRING_INDEX(product_option_variant_relation.variant_ids, ",", 1)'));
                })
//                ->leftJoin('product_option_variants_combination as product_option_variants_combination',function($join){
//                    $join->on('product_option_variants.variant_id','=','SUBSTRING_INDEX(GROUP_CONCAT(DISTINCT `product_option_variants_combination.variant_ids`  SEPARATOR " _ "),",")  as groups');
//                })
                ->leftJoin('product_option_variants_combination as product_option_variants_combination',function($join){
                    $join->on('product_option_variants.variant_id','=',DB::raw('SUBSTRING_INDEX(product_option_variants_combination.variant_ids, "_", 1)'));
                })
                ->leftJoin('product_images','product_images.for_combination_id', '=', 'product_option_variants_combination.combination_id')
                ->select($selectedColumn)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->toSql();die($result);
                ->get();
            return $result;
        } catch
        (QueryException $e) {
            echo $e;
        }

    }
}