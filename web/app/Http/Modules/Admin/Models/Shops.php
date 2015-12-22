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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['shop_id', 'user_id', 'shop_name', 'shop_banner', 'parent_category_id', 'shop_status', 'status_set_by'];

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


}

