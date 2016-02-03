<?php

namespace FlashSale\Http\Modules\Supplier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Product-category model
 * Class ProductCategory
 * @package FlashSale\Http\Modules\Supplier\Models
 */
class ProductCategory extends Model
{

    private static $_instance = null;

    protected $table = 'product_categories';

    /**
     * Get instance/object of this class
     * @return ProductCategory|null
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
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
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
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
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
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
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
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
     * @since 29-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
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

}
