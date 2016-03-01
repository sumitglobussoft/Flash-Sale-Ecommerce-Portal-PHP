<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Settings section model
 * Class SettingsSection
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class SettingsSection extends Model
{

    private static $_instance = null;

    /**
     * @var string Table name
     */
    protected $table = 'settings_sections';

    /**
     * @var int Number of minutes for which the value should be cached.
     */
    private $minutes = 60;


    /**
     * Get instance/object of this class
     * @return SettingsSection|null
     * @since 02-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new SettingsSection();
        return self::$_instance;
    }

    /**
     * Get all settings sections
     * @param array $where
     * @param array $selectedColumns
     * @return array|bool|object
     * @throws Exception
     * @since 06-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllSectionWhere($where, $selectedColumns = ['*'])
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
