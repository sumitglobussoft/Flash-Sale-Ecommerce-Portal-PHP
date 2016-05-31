<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductCategories extends Model

{
    private static $_instance = null;
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
    protected $fillable = ['category_id', 'category_name', 'created_by', 'category_status', 'status_set_by', 'parent_category_id', 'for_shop_id', 'category_banner_url', 'page_title', 'meta_description', 'meta_keywords'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductCategories();
        return self::$_instance;
    }

    public function getCategoriesWhere()
    {

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

    /**
     * Get Category Name By Category_id.
     * @param $where
     * @return int
     * @since 24-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function getCategoryNameById($where, $selectedColumn = ['*'])
    {
        {
            try {
                $result = DB::table($this->table)
//                    ->select((array(DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name', 'GROUP_CONCAT(DISTINCT parent_category_id) AS parent_category_id'))),$selectedColumn)
                    ->select($selectedColumn)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->groupBy('parent_category_id')
                    ->get();
            } catch
            (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }

        }

    }

    /**
     * Get Category Name By Category_id.
     * @param $where
     * @return int
     * @since 24-02-2016
     * @author Vini Dubey <vinidubey@globussoft.com>
     */
    public function getAllCategories($where, $selectedColumn = ['*'])
    {
        {
            try {
                $result = DB::table($this->table)
//                    ->select((array(DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name', 'GROUP_CONCAT(DISTINCT parent_category_id) AS parent_category_id'))),$selectedColumn)
                    ->select($selectedColumn)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->groupBy('parent_category_id')
                    ->get();
            } catch
            (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }

        }

    }

    public function getCategoryWhere($where, $selectedColumn = ['*'])
    {

        try {
            $result = DB::table($this->table)
//                    ->select((array(DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name', 'GROUP_CONCAT(DISTINCT parent_category_id) AS parent_category_id'))),$selectedColumn)
                ->select($selectedColumn)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->toSql();
                ->get();
            return $result;
        } catch
        (QueryException $e) {
            echo $e;
        }


    }


    public function getAllCategoryWhereByGrouping($where, $selectedColumn = ['*'])
    {

        try {
            $result = DB::table($this->table)
//                    ->select((array(DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name', 'GROUP_CONCAT(DISTINCT parent_category_id) AS parent_category_id'))),$selectedColumn)
                ->select($selectedColumn)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->groupBy("parent_category_id")
//                ->toSql();
                ->get();
            return $result;
        } catch
        (QueryException $e) {
            echo $e;
        }
    }


}