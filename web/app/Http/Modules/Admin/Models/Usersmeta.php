<?php
namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;


class Usersmeta extends Model
{

    protected $table = 'usersmeta';
    protected $fillable = ['user_id', 'addressline1', 'addressline2', 'city', 'state', 'country', 'zipcode', 'phone'];
    private static $_instance = null;

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Usersmeta();
        return self::$_instance;
    }

//    public function getAvaiableUserMetaDetails($where){
//
//        try{
//            $result = Usersmeta::whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
////                ->whereRaw($status['rawQuery'], isset($status['bindParams']) ? $status['bindParams'] : array())
//                ->select()
//                ->get();
//
//            return $result;
//
//        }catch (QueryException $e){
//            echo $e;
//        }
//
//    }

    public function getAvaiableUserMetaDetails()
    {

        try {
            $result = Usersmeta::join('users', function ($join) {
                $join->on('usersmeta.user_id', '=', 'users.id');
            })
//                ->leftJoin('location', function ($join) {
//                    $join->on('location.location_id', '=', 'usersmeta.city');
//                })
//                ->join('location', function ($join) {
//                    $join->on('location.location_id', '=', 'usersmeta.state');
//                })
                ->join('location', function ($join) {
                    $join->on('location.location_id', '=', 'usersmeta.country');
                })
                ->select()
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }

    }

    public function getUserMetaInfoByUserId($where,$selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->join('users', function ($join) {
                    $join->on('usersmeta.user_id', '=', 'users.id');
                })
                ->join('location','location.location_id', '=', 'usersmeta.country')
                ->select($selectedColumns)
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }


    }


}