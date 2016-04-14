<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Product-option-variant model
 * Class ProductOptionVariant
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class ProductOptionVariant extends Model
{

    private static $_instance = null;

    protected $table = 'product_option_variants';


    /**
     * Get instance/object of this class
     * @return ProductOptionVariant|null
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOptionVariant();
        return self::$_instance;
    }

    /**
     * Add new variant details
     * @return string|int
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewVariant()
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

    /**
     * Add new variant details and return id
     * @return string|int
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewVariantAndGetID()
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
     * @param $where
     * @param array $selectedColumns Column names to be fetched
     * @return mixed
     * @since 30-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllVariantsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;

    }

    /**
     * Get a variant details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 02-01-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getVariantWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->first();
        return $result;

    }

    /**
     * Update variant details
     * @return string
     * @throws Exception
     * @since 04-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateVariantWhere()
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

    /**
     * Delete variant details
     * @return string
     * @throws Exception
     * @since 20-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function deleteVariantWhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->delete();
                return $result;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**TODO: COMPLETE COMMENT BLOCK
     * @param $where
     * @param array $selectedColumns
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function getOptionVarWithRelationsWhere($where, $selectedColumns = ['*'])
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $whereForJoin = func_get_arg(2);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->leftjoin('product_option_variant_relation as povr', function ($join) use ($whereForJoin) {
                    $join->on('povr.option_id', '=', 'product_option_variants.option_id');
                    $join->where($whereForJoin['column'], $whereForJoin['condition'], $whereForJoin['value']);
                })
                ->leftjoin('product_option_variants as pov', function ($join) {
                    $join->on('pov.option_id', '=', 'product_option_variants.option_id');
                    $join->on('pov.variant_id', '=', 'product_option_variants.variant_id');
                })
                ->select(DB::raw("product_option_variants.*, CONCAT('[', GROUP_CONCAT(DISTINCT CONCAT('{\"VID\":\"',pov.variant_id,'\",\"VN\":\"',pov.variant_name,'\",\"PM\":\"',pov.price_modifier,'\",\"PMT\":\"',pov.price_modifier_type,'\",\"WM\":\"',pov.weight_modifier,'\",\"WMT\":\"',pov.weight_modifier_type,'\",\"STTS\":\"',pov.status,'\"}') ORDER BY pov.variant_id SEPARATOR ','),']') AS all_variant_data, povr.relation_id, povr.variant_ids, povr.variant_data, povr.product_id"))
                ->distinct('product_option_variants.option_id')
                ->distinct('pov.variant_id')
                ->groupBy('product_option_variants.option_id')
                ->get();
            if ($result) {
                $returnData['code'] = 200;
                $returnData['message'] = 'All option variants with relation.';
            } else {
                $returnData['code'] = 400;
                $returnData['message'] = 'No data found.';
            }
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

}
