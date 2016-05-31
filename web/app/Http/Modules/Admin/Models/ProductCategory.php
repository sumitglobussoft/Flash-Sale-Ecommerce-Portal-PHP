<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Product-category model
 * Class ProductCategory
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class ProductCategory extends Model
{

    private static $_instance = null;

    protected $table = 'product_categories';
    protected $fillable = ['id_path', 'level'];

    /**
     * Get instance/object of this class
     * @return ProductCategory|null
     * @since 19-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductCategory();
        return self::$_instance;
    }

    /**
     * Add new category
     * @return string|array
     * @throws Exception
     * @since 19-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addCategory()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = DB::table($this->table)->insertGetId($data);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get all category details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 21-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllCategoriesWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;
    }

    /**
     * Get a category details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 21-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getCategoryDetailsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->first();
        return $result;
    }

    /**
     * Update category details
     * @return string
     * @throws Exception
     * @since 24-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateCategoryWhere()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $updatedResult = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                return $updatedResult;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


    public function getParentCategoryId()
    {

        try {
            $result = DB::table("product_categories")
                ->where('parent_category_id', 0)
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

    public function getCategoryInfoById()
    {

        if (func_num_args() > 0) {
            $categoryId = func_get_arg(0);
            try {
                $result = DB::table("product_categories")
                    ->select(array(DB::raw('GROUP_CONCAT(DISTINCT category_name) AS category_name', 'GROUP_CONCAT(DISTINCT category_id) AS category_id')))
                    //  ->where('GROUP_CONCAT(DISTINCT category_id) AS category_id')
                    //  ->groupBy('category_name')

                    ->whereIn('category_id', $categoryId)
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

    public function getCategoryById()
    {

        if (func_num_args() > 0) {
            $categoryId = func_get_arg(0);
            try {
                $result = DB::table("product_categories")
                    ->select()
                    ->whereIn('category_id', $categoryId)
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
    public function getCategoryNameById($where,$selectedColumn){

        {
            try {
                $result = DB::table($this->table)
                    ->select($selectedColumn)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->toSql();
                    ->get();
            } catch
            (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            }

        }

    }

    public function getSubCategoriesForMaincategory($where,$selectedColumn = ['*']){

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumn)
                ->groupBy('parent_category_id')
                ->get();
            return $result;
        }catch(QueryException $e){
            echo $e;
        }
    }


}
