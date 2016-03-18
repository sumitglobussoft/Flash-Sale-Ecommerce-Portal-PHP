<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PermissionUserRelation extends Model
{

    private static $_instance = null;

    protected $table = 'permission_user_relation';
    protected $fillable = ['pur_id', 'user_id', 'permission_ids'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new PermissionUserRelation();
        return self::$_instance;
    }

    public function insertmanagerpermission()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = DB::table($this->table)->insert($data);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }

    }

    public function getPermissiondetailsByUserId($where, $selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->join('users', 'users.id', '=', 'permission_user_relation.user_id')
                // ->join('permissions', 'permissions.permission_id', '=', 'permission_user_relation.permission_ids')

//                ->orWhereIn('permission_user_relation.permission_ids', $f);
//                ->where(function ($q) {
//                    $q->whereNull('permission_user_relation.permission_ids')->orWhere('user.year_from', '>', DB::raw('course.year_from'));
//                })
                ->select($selectedColumns)
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }


    }

    public function getPermissionDetailsById()
    {

        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
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

    public function updatePermissionInfo()
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

    public function deleteUserPermission($where)
    {
        try {
            $sql = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->delete();
            return $sql;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }


}
