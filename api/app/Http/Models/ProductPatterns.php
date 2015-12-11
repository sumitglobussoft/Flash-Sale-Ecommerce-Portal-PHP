<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductPatterns extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_patterns';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pp_id', 'pattern_name', 'added_by', 'added_date', 'pattern_status', 'status_set_by'];


    /**
     * @return int
     *
     *
     */
    public function getProductPatternWhere()
    {

        if (func_num_args() > 0) {
            $productpatternId = func_get_arg(0);
            try {
                $result = DB::table("product_patterns")
                    ->select()
                    ->whereIn('pp_id', $productpatternId)
                    ->where('pattern_status', 1)
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