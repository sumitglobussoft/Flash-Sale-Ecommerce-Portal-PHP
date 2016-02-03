<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class Permissions extends Model
{

    private static $_instance = null;

    protected $table = 'permissions';
    protected $fillable = ['permission_id', 'permission_name', 'permission_url', 'permission_details', 'permission_description'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Permissions();
        return self::$_instance;
    }

    public function getAllPermissions($where, $selectedColumns = ['*'])
    {


        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;


    }

    public function getPermissionNameByIds($where)
    {
        {
            try {
                $result = DB::table($this->table)
                    ->select((array(DB::raw('GROUP_CONCAT(DISTINCT permission_details) AS permission_details', 'GROUP_CONCAT(DISTINCT permission_id) AS permission_id'))))
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

    public function getPermitDetail($where)
    {
        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }

    }


}