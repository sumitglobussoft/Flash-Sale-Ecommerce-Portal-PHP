<?php
namespace FlashSale\Http\Modules\Admin\Models;

use Hamcrest\Text\SubstringMatcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ProductFeatures extends Model
{

    private static $_instance = null;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_features';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['feature_id', 'feature_name', 'shop_id', 'group', 'feature_type', 'categories_path', 'parent_id', 'full_description', 'display_on_product', 'display_on_catalog', 'created_at', 'updated_at', 'added_by', 'status'];


    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductFeatures();
        return self::$_instance;
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

    public function getAllFeaturesWhere()
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