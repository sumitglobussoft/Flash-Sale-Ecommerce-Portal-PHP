<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Products
 * @package FlashSale\Http\Modules\Admin\Models
 * @author Dinanath Thakur <dinanaththakur@globussoft.in>
 */
class Products extends Model
{

    private static $_instance = null;

    protected $table = 'products';

    /**
     * Get instance/object of this class
     * @return Products|null
     * @since 17-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Products();
        return self::$_instance;
    }

    /**
     * Add new product
     * @return string
     * @throws Exception
     * @since 17-02-2016
     * @author Dinanath Thakur <dinanaththakur@globussoft.in>
     */
    public function addNewProduct()
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
}
