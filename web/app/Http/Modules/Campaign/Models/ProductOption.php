<?php

namespace FlashSale\Http\Modules\Campaign\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Product-option model
 * Class ProductOption
 * @package FlashSale\Http\Modules\Campaign\Models
 */
class ProductOption extends Model
{

    private static $_instance = null;

    protected $table = 'product_options';

    /**
     * Get instance/object of this class
     * @return ProductOption|null
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOption();
        return self::$_instance;
    }

    /**
     * Get all option details
     * @param $where
     * @param array $selectedColumns Column names to be fetched
     * @return mixed
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function getAllOptionsWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }



}