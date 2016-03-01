<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Product-option model
 * Class ProductOption
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class ProductOption extends Model
{

    private static $_instance = null;

    protected $table = 'product_options';

    /**
     * Get instance/object of this class
     * @return ProductOption|null
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOption();
        return self::$_instance;
    }

    /**
     * Add new option
     * @return string
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewOption()
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
     * Get all option details
     * @param $where
     * @param array $selectedColumns Column names to be fetched
     * @return mixed
     * @throws Exception
     * @since 28-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getAllOptionsWhere($where, $selectedColumns = ['*'])
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
     * Get an option details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 23-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function getOptionWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->first();
        return $result;
//            return $result;
//            $instance = $this;
//            $result = DB::table($this->table)
//                ->whereNested(function ($query) use ($where, $instance) {
//                    $instance->generateWhere($where, $query);
//                })
//                ->first();


    }

    /**
     * Update product option details
     * @return string
     * @throws Exception
     * @since 31-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function updateOptionWhere()
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
     * Delete option details
     * @return string
     * @throws Exception
     * @since 05-01-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function deleteOptionWhere()
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

    private function generateWhere($where, $query)
    {
        if (isset($where) && !empty($where)) {
            if (isset($where['column'])) {
                switch (strtoupper($where['condition'])) {
                    case "BETWEEN":
                        $query->whereBetween($where['column'], $where['value']);
                        break;

                    case "NOTBETWEEN":
                        $query->whereNotBetween($where['column'], $where['value']);
                        break;

                    case "IN":
                        $query->whereIn($where['column'], $where['value']);
                        break;

                    default:
                        $query->where($where['column'], $where['condition'], $where['value']);
                        break;
                }
            } else {
                if (isset($where['and']) && !empty($where['and'])) {
                    foreach ($where['and'] as $keyWhereAnd => $valueWhereAnd) {
                        switch (strtoupper($valueWhereAnd['condition'])) {
                            case "BETWEEN":
                                $query->whereBetween($valueWhereAnd['column'], $valueWhereAnd['value']);
                                break;

                            case "NOTBETWEEN":
                                $query->whereNotBetween($valueWhereAnd['column'], $valueWhereAnd['value']);
                                break;

                            case "IN":
                                $query->whereIn($valueWhereAnd['column'], $valueWhereAnd['value']);
                                break;

                            default:
                                $query->where($valueWhereAnd['column'], $valueWhereAnd['condition'], $valueWhereAnd['value']);
                                break;
                        }
                    }
                }
                if (isset($where['or']) && !empty($where['or'])) {
                    foreach ($where['or'] as $keyWhereOr => $valueWhereOr) {
                        switch (strtoupper($valueWhereOr['condition'])) {
                            case "between":
                                $query->orWhereBetween($valueWhereOr['column'], $valueWhereOr['value']);
                                break;

                            case "NOTBETWEEN":
                                $query->orWhereNotBetween($valueWhereOr['column'], $valueWhereOr['value']);
                                break;

                            case "IN":
                                $query->orWhereIn($valueWhereOr['column'], $valueWhereOr['value']);
                                break;

                            default:
                                $query->orWhere($valueWhereOr['column'], $valueWhereOr['condition'], $valueWhereOr['value']);
                                break;
                        }
                    }
                }
            }
            return $query;

        } else {
            return false;
        }
    }

}
