<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Class ProductOptionVariantCombination
 * @package FlashSale\Http\Modules\Admin\Models
 * @since 18-03-2016
 * @author Akash M. Pai <akashpai@globussoft.in>
 */
class ProductOptionVariantsCombination extends Model
{

    private static $_instance = null;

    protected $table = 'product_option_variants_combination';
    protected $fillable = ['product_id', 'variant_ids', 'quantity', 'exception_flag'];

    /**
     * Get instance/object of this class
     * @return ProductOptionVariantRelation|null
     * @since 29-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOptionVariantsCombination();
        return self::$_instance;
    }

    /**
     * Add new option-variant combination data
     * @return string|int
     * @throws Exception
     * @since 18-03-2016
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function addNewOptionVariantsCombination()
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
     * @param $where
     * @param array $selectedColumns
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function getCombinationWhere($where, $selectedColumns = ['*'])
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->first();
            $returnData['code'] = 200;
            $returnData['message'] = 'Combination data.';
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

    /**
     * @param $where
     * @param array $selectedColumns
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function getAllCombinationsWhere($where, $selectedColumns = ['*'])
    {
        $returnData = array('code' => 400, 'message' => 'Argument Not Passed.', 'data' => null);
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectedColumns)
                ->get();
            $returnData['code'] = 200;
            $returnData['message'] = 'All combinations.';
            $returnData['data'] = $result;
        }
        return json_encode($returnData);
    }

    /**
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function updateCombinationWhere()
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

    /**TODO: COMPLETE COMMENT BLOCK
     * @return string
     * @author Akash M. Pai <akashpai@globussoft.in>
     */
    public function deleteCombinationWhere()
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
                    $returnData['message'] = 'Variant Combination/s deleted.';
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
