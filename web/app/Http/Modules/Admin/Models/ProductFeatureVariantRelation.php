<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductFeatureVariantRelation extends Model
{

    private static $_instance = null;

    protected $table = 'product_feature_variant_relation';
    protected $fillable = ['product_id', 'feature_id', 'variant_ids', 'display_status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFeatureVariantRelation();
        return self::$_instance;
    }

    /**
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.com>
     */
    public function addFeatureVariantRelation($data)
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = $this->firstOrCreate($data);
                return json_encode(array('code' => 200, 'message' => 'Feature relation added successfully.', 'data' => $result));
//                return $result;
            } catch (\Exception $e) {
                return json_encode(array('code' => 400, 'message' => 'Could not add data. Please try again later', 'data' => $e));
//                return $e->getMessage();
            }
        } else {
            return json_encode(array('code' => 400, 'message' => 'Argument Not Passed.'));
//            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * @param string $where one or more where conditions
     * @return array of all results matching the where condition or null
     * @author Akash M. Pai <akashpai@globussoft.com>
     */
    public function getAllFeatureVariantRelationsWhere($where, $selectedColumns = ['*'])
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            $returnData['code'] = 200;
            $returnData['message'] = 'All features.';
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

    /**
     * @param string $where one or more where conditions
     * @return array of result matching the where condition or null
     * @author Akash M. Pai <akashpai@globussoft.com>
     */
    public function getFeatureVariantRelationWhere($where, $selectedColumns = ['*'])
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->first();
            if ($result) {
                $returnData['code'] = 200;
                $returnData['message'] = 'All feature variants relations.';
            } else {
                $returnData['code'] = 400;
                $returnData['message'] = 'No data found.';
            }
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

    public function updateFeatureVariantRelationWhere()
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $updatedResult = $this->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                if ($updatedResult) {
                    $returnData['code'] = 200;
                    $returnData['message'] = 'Changes saved.';
                } else {
                    $returnData['code'] = 100;
                    $returnData['message'] = 'Nothing to update.';
                }
            } catch (\Exception $e) {
                $returnData['code'] = 400;
                $returnData['message'] = 'Something went wrong. Please reload the page and try again.';
            }
        }
        return json_encode($returnData);
    }

    public function deleteFeatureVariantRelationWhere()
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->delete();
                if ($result) {
                    $returnData['code'] = 200;
                    $returnData['message'] = 'Variant Relation/s deleted.';
                } else {
                    $returnData['code'] = 100;
                    $returnData['message'] = 'Could not delete. Try again later.';
                }
            } catch (\Exception $e) {
                $returnData['code'] = 400;
                $returnData['message'] = 'Something went wrong. Please reload the page and try again.';
            }
        }
        return json_encode($returnData);
    }

}
