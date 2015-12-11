<?php

namespace FlashSaleApi\Http\Models;

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


    public function getShopDetail()
    {
        if (func_num_args() > 0) {
            $count = func_get_arg(0);  // The number of rows to return.
            $offset = func_get_arg(1);  //Start returning after this many rows.
            try {
                $result = DB::table("shops")
//                ->where('available_from', '<',time()) //Need to modify the available date less than current date//
                    ->where('shop_status', 1)
                    ->limit($count,$offset)
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