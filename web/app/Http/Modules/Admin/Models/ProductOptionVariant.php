<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductOptionVariant extends Model
{

    private static $_instance = null;

    protected $table = 'product_option_variants';

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOptionVariant();
        return self::$_instance;
    }

    /**
     * Add new variant details
     * @return string
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function addNewVariant()
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
     * @param $where
     * @param array $selectedColumns Column names to be fetched
     * @return mixed
     * @since 30-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function getAllVariantsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;

    }

    /**
     * Get a variant details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 02-01-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function getVariantWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->first();
        return $result;

    }

    /**
     * Update variant details
     * @return string
     * @throws Exception
     * @since 04-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function updateVariantWhere()
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

    /**
     * Delete variant details
     * @return string
     * @throws Exception
     * @since 20-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function deleteVariantWhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $updatedResult = DB::table($this->table)
//                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->whereRaw($where['rawQuery'])
                    ->delete();
                return $updatedResult;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
