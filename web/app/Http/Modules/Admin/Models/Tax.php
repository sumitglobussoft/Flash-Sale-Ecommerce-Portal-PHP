<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Class Tax
 * @package FlashSale\Http\Modules\Admin\Models
 * @since 04-03-2016
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class Tax extends Model
{

    private static $_instance = null;


    protected $table = 'taxes';


    /**
     * Get instance/object of this class
     * @return Tax|null
     * @since 04-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Tax();
        return self::$_instance;
    }

    /**
     * Add new tax details
     * @return string|int
     * @throws Exception
     * @since 04-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewTax()
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
     * Get all tax details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @throws Exception
     * @since 04-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllTaxDetailsWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->orderBy('priority')
                ->get();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get a tax detail
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 05-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getTaxDetailsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->first();
        return $result;
    }

    /**
     * Update tax details
     * @return string|int
     * @throws Exception
     * @since 05-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateTaxWhere()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Delete a tax details
     * @return string|int
     * @throws Exception
     * @since 05-03-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function deleteTaxWhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->delete();
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
