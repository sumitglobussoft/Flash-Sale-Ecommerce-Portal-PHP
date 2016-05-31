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
    protected $primaryKey = 'product_filter_option_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['product_filter_option_id', 'product_filter_option_name', 'product_filter_category_id', 'product_filter_option_description','product_filter_type', 'product_filter_group_id', 'added_by', 'added_date', 'product_filter_option_status', 'updated_at', 'created_at'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFilterOption();
        return self::$_instance;
    }

    public function getProductFilterOptionWhere()
    {

        if (func_num_args() > 0) {

            $where = func_get_arg(0);
            try {
                $result = DB::table("product_filter_option")
//                ->where('available_from', '<',time()) //Need to modify the available date less than current date//
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
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
                $result = DB::table($this->table)->insert($data);
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
            $where = func_get_arg(0);
            $featureStatus = func_get_arg(1);

            try {
                $result = DB::table("product_filter_option")
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($featureStatus);

            } catch (QueryException $e) {
                echo $e;
            }
            return $result;


        }
    }

    public function getFilterDetailsById($where)
    {

        try {
            $result = DB::table("product_filter_option")
                ->leftJoin('product_features', function ($join) {
                    $join->on('product_filter_option.product_filter_feature_id', '=', 'product_features.feature_id');
                })
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->get();

        } catch (QueryException $e) {
            echo $e;
        }
        return $result;

    }

    public function deletefilteroption()
    {

        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $delete = DB::table('product_filter_option')
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->delete();

            return $delete;
        }

    }

    public function getFilterOptionAndGroup($where, $selectColumns = ['*'])
    {

        try {
            $result = DB::table("product_filter_option")
                ->leftJoin('product_features', function ($join) {
                    $join->on('product_filter_option.product_filter_feature_id', '=', 'product_features.feature_id');
                })
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->select($selectColumns)
                ->groupBy('product_filter_group_id')
//                ->toSql();
                ->get();

        } catch (QueryException $e) {
            echo $e;
        }
        return $result;
    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return static
     */
//    public static function updateOrCreate($where, $finalData)
//    {
//        $instance = static::firstOrNew($where)
//                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array());
//        $instance->fill($finalData)->save();
//
//         return $instance;
//    }
    public static function updateOrCreate(array $attributes, array $values = array())
    {
//       echo'<pre>';print_r($attributes);
//        print_r($values);
        $instance = static::firstOrNew($attributes);
        $instance->fill($values)->save();

        return $instance;
    }


    /**
     * If the register exists in the table, it updates it.
     * Otherwise it creates it
     * @param array $data Data to Insert/Update
     * @param array $keys Keys to check for in the table
     * @return Object
     */
    static function createOrUpdate($data, $keys)
    {

        $record = self::where($keys)->first();
        if (is_null($record)) {
            return self::create($data);
        } else {
            return self::where($keys)->update($data);
        }
    }

}