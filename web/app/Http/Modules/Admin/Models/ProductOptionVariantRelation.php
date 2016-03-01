<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use \Exception;

/**
 * Class ProductOptionVariantRelation
 * @package FlashSale\Http\Modules\Admin\Models
 * @since 29-02-2016
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class ProductOptionVariantRelation extends Model
{

    private static $_instance = null;

    protected $table = 'product_option_variant_relation';


    /**
     * Get instance/object of this class
     * @return ProductOptionVariantRelation|null
     * @since 29-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new ProductOptionVariantRelation();
        return self::$_instance;
    }

    /**
     * Add new option-variant relation data
     * @return string|int
     * @throws Exception
     * @since 29-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewOptionVariantRelation()
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
}
