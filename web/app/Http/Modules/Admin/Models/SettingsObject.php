<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SettingsObject extends Model
{

    private static $_instance = null;

    protected $table = 'settings_objects';

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new SettingsObject();
        return self::$_instance;
    }

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

    public function getAllObjectsAndVariantsOfASectionWhere($where, $selectedColumns = ['*'])
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);

//            $result = DB::table($this->table)
//                ->join('settings_sections', function ($join) {
//                    $join->on("$this->table.section_id", '=', 'settings_sections.section_id');
//                })
//                ->join('settings_descriptions', function ($join) {
//                    $join->on("$this->table.object_id", '=', 'settings_descriptions.object_id');
//                })
//                ->join('settings_variants', function ($join) {
//                    $join->on("$this->table.object_id", '=', 'settings_variants.object_id');
//                })
//                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
//                ->select(DB::raw('settings_objects.object_id , settings_objects.*, settings_sections.name AS section_name,settings_descriptions.value as desc_value, GROUP_CONCAT(settings_variants.variant_id) as variant_ids, GROUP_CONCAT(settings_variants.name) as variant_names'))
//                ->orderBy('settings_objects.position')
//                ->groupBy('settings_variants.object_id')
//                ->get();
//            return $result;

//            $result = DB::table($this->table)
//                ->join('settings_sections', 'settings_sections.section_id', '=', 'settings_objects.section_id')
//                ->join('settings_descriptions', 'settings_descriptions.object_id', '=', 'settings_objects.object_id')
//                ->join('settings_variants', 'settings_variants.object_id', '=', 'settings_objects.object_id')
//                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
////                ->select('settings_objects.*', 'settings_sections.name AS section_name', 'settings_descriptions.value AS setting_name','settings_descriptions.tooltip')
//                ->select(DB::raw('settings_objects.object_id , settings_objects.*, settings_sections.name AS section_name,settings_descriptions.value as desc_value, GROUP_CONCAT(settings_variants.variant_id) as variant_ids, GROUP_CONCAT(settings_variants.name) as variant_names'))
//                ->orderBy('settings_objects.position')
//                ->groupBy('settings_variants.object_id')
//                ->get();

            DB::statement('SET SESSION group_concat_max_len = 1000000');
            $result = DB::table($this->table)
                ->join('settings_sections', 'settings_sections.section_id', '=', 'settings_objects.section_id')
                ->join('settings_descriptions', 'settings_descriptions.object_id', '=', 'settings_objects.object_id')
                ->leftJoin('settings_variants', 'settings_variants.object_id', '=', 'settings_objects.object_id')
                ->leftJoin('settings_descriptions as sd', function ($join) {
                    $join->on('sd.object_id', '=', 'settings_variants.variant_id');
                })
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select(DB::raw('settings_objects.object_id , settings_objects.*, settings_sections.name AS section_name,settings_descriptions.value as setting_name, GROUP_CONCAT(DISTINCT(settings_variants.variant_id) ORDER BY settings_variants.position) as variant_ids, GROUP_CONCAT(DISTINCT(settings_variants.name)  ORDER BY settings_variants.position  SEPARATOR "____") as variant_names, settings_descriptions.tooltip, GROUP_CONCAT(CASE sd.object_type WHEN "V" THEN sd.value END  ORDER BY settings_variants.position SEPARATOR "____") AS var_names'))
                ->orderBy('settings_objects.position')
                ->groupBy('settings_objects.object_id')
//                ->toSql();
                ->get();
//            die($result);
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


}
