<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Currency model
 * Class Currency
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class Currency extends Model
{

    private static $_instance = null;

    protected $table = 'currencies';

    /**
     * Get instance/object of this class
     * @return Currency|null
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Currency();
        return self::$_instance;
    }

    /**
     * Add new currency
     * @return string|int
     * @throws Exception
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewCurrency()
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
     * Get all available currencies
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @throws Exception
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllCurrenciesWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->select($selectedColumns)
                    ->orderBy('position')
                    ->get();
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get a currency details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getCurrencyWhere($where, $selectedColumns = ['*'])
    {
        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->first();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update currency details
     * @return string|int
     * @throws Exception
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateCurrencyWhere()
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
     * Delete currency details
     * @return string|int
     * @throws Exception
     * @since 21-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function deleteCurrencyWhere()
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
