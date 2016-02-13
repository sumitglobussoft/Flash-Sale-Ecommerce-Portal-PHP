<?php

namespace FlashSale\Http\Modules\Supplier\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Shop extends Model
{

    private static $_instance = null;

    protected $table = 'shops';
    protected $fillable = ['shop_id', 'user_id', 'shop_name', 'shop_banner', 'parent_category_id', 'status_set_by', 'shop_status'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Shop();
        return self::$_instance;
    }

    /**
     * Get all shop details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
     * @since 28-1-2016
     * @author Harshal Wagh
     */
    public function getAllshopsWhere($where, $selectedColumns = ['*'])
    {
        $result = DB::table($this->table)
            ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
            ->select($selectedColumns)
            ->get();
        return $result;
    }

    /**
     * Add shop details
     * @param $data
     * @return int
     * @since 28-1-2016
     * @author Harshal Wagh
     */
    public function addShop($data)
    {
        $result = DB::table($this->table)
            ->insertGetId($data);
        return $result;

    }

    /**
     * Get shop details for Datatable
     * @param $user_id
     * @return array
     * @since 29-1-2016
     * @author Harshal Wagh
     */
    public function getAvailableShopDetails($user_id)
    {

        try {
            $result = Shop::where('user_id', $user_id)
                ->where('shop_status','<>','4')
                ->select(['shop_id', 'shop_name', 'shop_status'])
                ->get();

            return $result;

        } catch (\Exception $e) {
            return $e->getMessage();

        }
    }

    /**
     * @param array : $where
     * @return int
     * @throws "Argument Not Passed"
     * @since 29-1-2016
     * @author Harshal Wagh
     * @uses
     */
    public function updateShopWhere()
    {

        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $result = DB::table($this->table)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->update($data);
                return 1;
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

}
