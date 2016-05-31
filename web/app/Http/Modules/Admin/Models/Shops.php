<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class Shops extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shops';
    private static $_instance = null;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['shop_id', 'user_id', 'shop_name', 'shop_banner', 'parent_category_id', 'shop_status', 'status_set_by'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new Shops();
        return self::$_instance;
    }
   public function getAllStoreWhere(){

           try {
               $result = DB::table("shops")
//                ->where('available_from', '<',time()) //Need to modify the available date less than current date//
                   ->where('shop_status', 1)
                   ->leftJoin('users', function ($join) {
                       $join->on('users.id', '=', 'shops.shop_id');
                   })
                   ->where('users.role', '=' ,3)
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

    public function getShopDetails($where)
    {

        try {
            $result = Shops::whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->join('users', 'users.id', '=', 'shops.user_id')
                ->select(['shop_id', 'shop_name', 'users.name', 'users.last_name', 'shop_status'])
                ->get();

            return $result;

        } catch (\Exception $e) {
            return $e->getMessage();

        }

    }

    /**
     * Get all shop details
     * @param $where
     * @param array $selectedColumns
     * @return mixed
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
     * @param array : $where
     * @return int
     * @throws "Argument Not Passed"
     * @since 4-4-2016
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

}

