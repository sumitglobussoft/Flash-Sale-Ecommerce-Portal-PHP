<?php
namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ProductFilterOption extends Model
{

    private static $_instance = null;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_filter_option';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_filter_option_id', 'product_filter_option_name', 'product_filter_category_id', 'product_filter_option_description', 'product_filter_group_id', 'added_by', 'added_date', 'product_filter_option_status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFilterOption();
        return self::$_instance;
    }

    public function getProductFilterOptionWhere()
    {

        if (func_num_args() > 0) {

            $filteroptionname = func_get_arg(0);
            try {
                $result = DB::table("product_filter_option")
//                ->where('available_from', '<',time()) //Need to modify the available date less than current date//
                    ->where('product_filter_option_name', $filteroptionname)
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
                $result = DB::table('product_filter_option')->insert($data);
                return $result;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    public function getAllFilterGroup()
    {

        try {
            $result = DB::table("product_filter_option")
                ->select()
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

    public function updateFilterOption()
    {

        if (func_num_args() > 0) {
            $featureId = func_get_arg(0);
            $featureStatus = func_get_arg(1);

            try {
                $result = DB::table("product_filter_option")
                    ->where('product_filter_option_id', $featureId)
                    ->update($featureStatus);
            } catch (QueryException $e) {
                echo $e;
            }
            return $result;


        }
    }

    public function getFilterDetailsById()
    {
        if (func_num_args() > 0) {
            $filterId = func_get_arg(0);
            try {
                $result = DB::table("product_filter_option")
                    ->leftJoin('product_features', function ($join) {
                        $join->on('product_filter_option.product_filter_feature_id', '=', 'product_features.feature_id');
                    })
                    ->where('product_filter_option_id', $filterId)
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

    public function deletefilteroption()
    {

        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            $delete = DB::table('product_filter_option')
                ->where('product_filter_option_id', $id)
                ->delete();

            return $delete;
        }

    }

}