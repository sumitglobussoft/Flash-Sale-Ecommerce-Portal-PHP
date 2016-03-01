<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Settings object model
 * Class SettingsObject
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class SettingsObject extends Model
{

    private static $_instance = null;
    /**
     * @var string Table name
     */
    protected $table = 'settings_objects';

    /**
     * @var int Number of minutes for which the value should be cached.
     */
    private $minutes = 60;


    /**
     * Get instance/object of this class
     * @return SettingsObject|null
     * @since 07-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new SettingsObject();
        return self::$_instance;
    }

    /**
     * Get all objects based on some condition
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @throws Exception
     * @since 07-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllObjectWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get all objects and their related variants for a section
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @throws Exception
     * @since 08-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllObjectsAndVariantsOfASectionWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $cacheKey = $this->table . "::" . implode('-', array_flatten($where));
            if (cacheGet($cacheKey)) return cacheGet($cacheKey);
//            die("no cache");
            DB::statement('SET SESSION group_concat_max_len = 10000');
            $result = DB::table($this->table)
                ->join('settings_sections', 'settings_sections.section_id', '=', 'settings_objects.section_id')
                ->join('settings_descriptions', 'settings_descriptions.object_id', '=', 'settings_objects.object_id')
                ->leftJoin('settings_variants', 'settings_variants.object_id', '=', 'settings_objects.object_id')
                ->leftJoin('settings_descriptions as sd', function ($join) {
                    $join->on('sd.object_id', '=', 'settings_variants.variant_id');
                })
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select(DB::raw('settings_objects.object_id ,
                settings_objects.*,
                settings_sections.name AS section_name,
                settings_descriptions.value AS setting_name,
                settings_descriptions.tooltip,
                GROUP_CONCAT(DISTINCT(settings_variants.variant_id) ORDER BY settings_variants.position) AS variant_ids,
                GROUP_CONCAT(DISTINCT(BINARY settings_variants.name)  ORDER BY settings_variants.position  SEPARATOR "____") AS variant_names,
                GROUP_CONCAT(CASE sd.object_type WHEN "V" THEN sd.value END  ORDER BY settings_variants.position SEPARATOR "____") AS var_names'))
                ->orderBy('settings_objects.position')
                ->groupBy('settings_objects.object_id')
                ->get();
            cachePut($cacheKey, $result, $this->minutes);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Update object details
     * @return string|int
     * @throws Exception
     * @since 12-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateObjectWhere()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                if ($result)
                    cacheClearByTableNames([$this->table]);
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Get a setting value
     * @param array $where
     * @param array $selectedColumns
     * @return array|bool|object
     * @since 20-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getSettingObjectWhere($where, $selectedColumns = ['*'])
    {
        try {
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->first();
            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
