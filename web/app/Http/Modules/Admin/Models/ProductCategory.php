<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{

    private static $_instance = null;

    protected $table = 'product_categories';
    protected $fillable = ['id_path','level'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductCategory();
        return self::$_instance;
    }

    public function addCategory()
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

    public function getAllCategoriesWhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->where($where['column'], $where['condition'], $where['value'])
                ->get();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getCategoryDeltailsWhere($where)
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->where($where['column'], $where['condition'], $where['value'])
                ->first();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function updateCategoryWhere()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $updatedResult = DB::table($this->table)
                    ->where($where['column'], $where['condition'], $where['value'])
                    ->update($data);
                return $updatedResult;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }


}
