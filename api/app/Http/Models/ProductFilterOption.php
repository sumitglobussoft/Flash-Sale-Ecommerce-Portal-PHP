<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductFilterOption extends Model

{
    private static $_instance = null;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_filter_option';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_filter_option_id', 'product_filter_option_name', 'product_filter_category_id', 'product_filter_option_description', 'product_filter_feature_id', 'product_filter_parent_product_id', 'added_by', 'added_date', 'product_filter_option_status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFilterOption();
        return self::$_instance;
    }


    public function getAllFilterOption($where, $selectedColumn = ['*'])
    {

        try {
//            DB::statement('SET SESSION group_concat_max_len = 10000'); // Uncomment when group concat value exceeds
            $result = DB::table($this->table)
                ->select($selectedColumn)
                ->join('product_filter_option as pg','product_filter_option.product_filter_option_id','=','pg.product_filter_group_id')
//                ->join('product_filter_option as pg','pg.product_filter_group_id','=','product_filter_option.product_filter_type')
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->groupBy('product_filter_option.product_filter_option_id')
//                ->toSql();
                ->get();
            return $result;
        } catch
        (QueryException $e) {
            echo $e;
        }


    }


}