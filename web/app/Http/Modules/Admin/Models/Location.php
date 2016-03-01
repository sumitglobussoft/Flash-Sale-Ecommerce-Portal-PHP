<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Location model
 * Class Location
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class Location extends Model
{

    private static $_instance = null;

    protected $table = 'location';
	protected $fillable = ['location_id', 'name', 'location_type', 'parent_id', 'is_visible'];


    /**
     * Get instance/object of this class
     * @return Location|null
     * @since 14-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Location();
        return self::$_instance;
    }

    /**
     * Get all locations
     * @param $where Where clause for DB-Query
     * @param array $selectedColumns Column names to be fetched
     * @return mixed
     * @throws Exception
     * @since 14-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllLocationsWhere($where, $selectedColumns = ['*'])
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


    public function getAllCountryDetails($where)
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select()
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }

    }


    public function getStateByCountryId($where)
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select()
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }
    }

    public function getCityByCountryId($where)
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select()
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }
    }

}
