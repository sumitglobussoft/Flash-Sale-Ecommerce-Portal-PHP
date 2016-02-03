<?php


namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

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

    public function addlanguages()
    {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = DB::table($this->table)->insertGetId($data);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }

    }


    /**
     * Get All Languages
     * Query For Datatable
     * @return string
     *
     */
    public function getAvailableLanguageDetails()
    {

        try {
            $query = DB::table($this->table)
                ->select(array('languages.lang_id', 'languages.lang_code', 'languages.name', 'location.name as location_name', 'languages.status'))
                ->join('location', 'location.location_id', '=', 'languages.country_code');

            return $query;

        } catch (\Exception $e) {
            return $e->getMessage();
        }


    }

    public function getAllLanguageDetails($where, $selectedColumns = ['*'])
    {

        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->join('location', 'location.location_id', '=', 'languages.country_code')
                ->select($selectedColumns)
                ->get();
            return $result;
        } catch (QueryException $e) {
            echo $e;
        }
    }


    public function updateLanguageStatus()
    {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
//            echo"<pre>";print_r($data);
//            echo"<pre>";print_r($where);die("cf");
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        } else {
            throw new Exception('Argument Not Passed');
        }

    }

    /**
     * @param array : $where
     * @return int
     * @throws "Argument Not Passed"
     * @throws
     * @author Vini
     * @uses Delete User
     */
    public function deleteLanguage($where)
    {
        $sql = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->delete();
        if ($sql) {
            return $sql;
        } else {
            return 0;
        }
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