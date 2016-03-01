<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Settings variant model
 * Class SettingsVariant
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class SettingsVariant extends Model
{

    private static $_instance = null;
    /**
     * @var string Table name
     */
    protected $table = 'settings_variants';
    /**
     * @var int Number of minutes for which the value should be cached.
     */
    private  $minutes= 60;

    /**
     * Get instance/object of this class
     * @return SettingsVariant|null
     * @since 06-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new SettingsVariant();
        return self::$_instance;
    }

    /**
     * Get all variant details
     * @param $where
     * @param array $selectedColumns
     * @return array|bool|object
     * @throws Exception
     * @since 06-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllVariantWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $cacheKey = $this->table . "::" . implode('-', array_flatten($where));
            if (cacheGet($cacheKey)) return cacheGet($cacheKey);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            cachePut($cacheKey, $result, $this->minutes);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


}
