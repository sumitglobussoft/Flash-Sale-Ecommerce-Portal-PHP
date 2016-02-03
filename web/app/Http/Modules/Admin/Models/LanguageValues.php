<?php


namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LanguageValues extends Model
{

    private static $_instance = null;

    protected $table = 'language_values';
    protected $fillable = ['lang_value_id', 'lang_code', 'name', 'value'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new LanguageValues();
        return self::$_instance;
    }


    public function addLanguagesValue()
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


    public function getLanguageValueDetails()
    {

        try {
            $query = DB::table($this->table)
//               ->select(array('languages.lang_id', 'languages.lang_code', 'languages.name', 'location.name as location_name', 'languages.status'))
//               ->join('location', 'location.location_id', '=', 'languages.country_code');
                ->select(array('lang_value_id', 'name', 'value'));

            return $query;

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public function getLanguageValueDetailsById($where)
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

    public function updateLanguageValueStatus()
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

    public function getAllLanguageVariable($selectedColumns = ['*'],$lcode)
    {

        try {
            $result = DB::table($this->table)
                ->select($selectedColumns,['*', DB::raw('IF(`'.$lcode.'` IS NOT NULL, `'.$lcode.'`, 1000000) `'.$lcode.'`')])
                ->orderBy($lcode, 'asc')
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;

        }
    }


    public function getAllLanguageVariableWhere($where, $selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;

        }
    }

    public function getLangDetailsById($lcode)
    {

        try {
            $result = DB::table($this->table)
                ->leftjoin('languages', 'languages.lang_code', '=', 'language_values.' . $lcode . '')
                ->select('languages.lang_code', 'language_values.*')
//                ->toSql();
//            die;
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }

    }


}