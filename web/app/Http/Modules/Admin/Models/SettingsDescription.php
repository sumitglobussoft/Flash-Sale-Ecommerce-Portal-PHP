<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Settings description model
 * Class SettingsDescription
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class SettingsDescription extends Model
{

    private static $_instance = null;
    /**
     * @var string Table name
     */
    protected $table = 'settings_descriptions';

    /**
     * @var int Number of minutes for which the value should be cached.
     */
    private  $minutes= 60;

    /**
     * Get instance/object of this class
     * @return SettingsSection|null
     * @since 02-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new SettingsDescription();
        return self::$_instance;
    }

    /**
     * Get all settings description
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @throws Exception
     * @since 02-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllSettingsDescriptionWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $cacheKey = $this->table . "::" . implode('-', array_flatten($where));
            if (cacheGet($cacheKey)) return cacheGet($cacheKey);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            cacheForever($cacheKey, $result);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


}
