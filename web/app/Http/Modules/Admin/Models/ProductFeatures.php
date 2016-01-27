<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductFeatures extends Model
{

    private static $_instance = null;

    protected $table = 'product_features';
    protected $fillable = ['feature_name', 'shop_id', 'group_flag', 'feature_type', 'parent_id', 'full_description', 'display_on_product', 'display_on_catalog', 'status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFeatures();
        return self::$_instance;
    }

    /**
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.com>
     */
    public function addFeature()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = DB::table($this->table)->insertGetId($data, 'feature_id');
                return json_encode(array('code' => 200, 'message' => 'Feature added successfully.', 'data' => $result));
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
    public function getAllFeaturesWhere($where, $selectedColumns = ['*'])
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
    public function getFeatureWhere($where, $selectedColumns = ['*'])
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
                $returnData['message'] = 'All features.';
            } else {
                $returnData['code'] = 400;
                $returnData['message'] = 'No data found.';
            }
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

    public function updateFeatureWhere()
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $updatedResult = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                if ($updatedResult) {
                    $returnData['code'] = 200;
                    $returnData['message'] = 'Changes saved successfully.';
                } else {
                    $returnData['code'] = 100;
                    $returnData['message'] = 'Nothing to update';
                }
            } catch (\Exception $e) {
                $returnData['code'] = 400;
                $returnData['message'] = 'Something went wrong. Please reload the page and try again.';
            }
        }
        return json_encode($returnData);
    }

    /*
     * SAMPLE FUNCTION FOR WHERE BEFORE USING WHERERAW
     */
    public function sampleFunctionOld()
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->where($where['column'], $where['condition'], $where['value'])
                ->get();
            $returnData['data'] = $result;
            $returnData['code'] = 200;
            $returnData['message'] = 'All features.';
        }
        return json_encode($returnData);
    }

    /*
     * MULTIPLE WHERE SAMPLE FUNCTION
     */
    public function sampleFunction()
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $instance = $this;
            $result = DB::table($this->table)
                ->whereNested(function ($query) use ($where, $instance) {
                    $instance->generateWhere($where, $query);
                })
                ->get();
            $returnData['data'] = $result;
            $returnData['code'] = 200;
            $returnData['message'] = 'All features.';
        }
        return json_encode($returnData);
    }

    private function generateWhere($where, $query)
    {
        if (isset($where) && !empty($where)) {
            if (isset($where['and']) && !empty($where['and'])) {
                foreach ($where['and'] as $keyWhereAnd => $valueWhereAnd) {
                    switch ($valueWhereAnd['condition']) {
                        case "":

                            break;

                        default:
                            $query->where($valueWhereAnd['column'], $valueWhereAnd['condition'], $valueWhereAnd['value']);
                            break;
                    }
                }
            }
            if (isset($where['or']) && !empty($where['or'])) {
                foreach ($where['or'] as $keyWhereOr => $valueWhereOr) {
                    switch ($valueWhereOr['condition']) {
                        case "":

                            break;

                        default:
                            $query->orWhere($valueWhereOr['column'], $valueWhereOr['condition'], $valueWhereOr['value']);
                            break;
                    }
                }
            }
            return $query;
        } else {
            return null;
        }
    }


    public function getProductFeatureWhere()
    {

        if (func_num_args() > 0) {

            $filtergroupname = func_get_arg(0);
            try {
                $result = DB::table("product_features")
//                ->where('available_from', '<',time()) //Need to modify the available date less than current date//
                    ->where('feature_name', $filtergroupname)
                    ->get();

            } catch (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }

    }

    public function addProductfilterWhere()
    {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            try {
                $result = DB::table('product_features')->insert($data);
                return $result;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getAllFeatureWhere()
    {

        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->get();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


    public function getFeatureDetailsById()
    {

        if (func_num_args() > 0) {
            $featureId = func_get_arg(0);
            try {
                $result = DB::table("product_features")
                    ->where('feature_id', $featureId)
                    ->get();

            } catch (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }

    }
}
