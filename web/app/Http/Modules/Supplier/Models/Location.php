<?php

namespace FlashSale\Http\Modules\Supplier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{

    private static $_instance = null;

    protected $table = 'location';

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Location();
        return self::$_instance;
    }

    /**
     * Get all Location details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 27-1-2016
     * @author Harshal Wagh
     */
    public function getAllLocationsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;
    }


}
