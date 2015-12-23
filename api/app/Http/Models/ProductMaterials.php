<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductMaterials extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_materials';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pm_id', 'material_name', 'added_by', 'added_date', 'material_status', 'status_set_by'];


    public function getProductMaterialWhere()
    {

        if (func_num_args() > 0) {
            $materialId = func_get_arg(0);
            try {
                $result = DB::table("product_materials")
                    ->select()
                    ->whereIn('pm_id', $materialId)
                    ->where('material_status', 1)
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