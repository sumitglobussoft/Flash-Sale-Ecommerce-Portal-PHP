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
class Products extends Model
{

    private static $_instance = null;

    protected $table = 'products';

    /**
     * Get instance/object of this class
     * @return Products|null
     * @since 10-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Products();
        return self::$_instance;
    }

    public function getProductNameById($where,$selectedColumn)
    {
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
            } else {
                return 0;
            }

        }
    }

    public function getProductNameByIdWhere($where)
    {
        {
            try {
                $result = DB::table($this->table)
                    ->select()
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
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

    public function getAllSupplierProducts($where,$selectedColumn){

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumn)
                ->get();
            return $result;
        }catch(QueryException $e){
            echo $e;
        }
    }
}