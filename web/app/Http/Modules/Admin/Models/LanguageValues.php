<?php


namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LanguageValues extends Model
{

    private static $_instance = null;

    protected $table = 'language_values';
    protected $fillable = ['lang_code','name','value'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new LanguageValues();
        return self::$_instance;
    }







}