<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Languages extends Model
{

    private static $_instance = null;

    protected $table = 'languages';
    protected $fillable = ['lang_id', 'lang_code', 'name', 'status', 'country_code'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Languages();
        return self::$_instance;
    }

    public function getAllLanguages($selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->select($selectedColumns)
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;

        }
    }

}