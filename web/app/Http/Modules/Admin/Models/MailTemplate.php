<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MailTemplate extends Model
{

    private static $_instance = null;

    protected $table = 'mail_templates';
    protected $fillable = ['temp_id', 'temp_name','temp_content','status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new MailTemplate();
        return self::$_instance;
    }


    public function getTemplateByName($temp_name)
    {
//        try{
//            $result = DB::table($this->table)
//                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->select()
//                ->first();
//
////        } catch (\Exception $e) {
////            return $e->getMessage();
////        }
//        if($result){
//            return $result;
//        }else{
//            return 0;
//        }
        $result = DB::table('mail_templates')
            ->select()
            ->where('temp_name', $temp_name)
            ->first();
        return $result;

    }

}
