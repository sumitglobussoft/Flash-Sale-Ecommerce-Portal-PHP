<?php

namespace FlashSale\Http\Modules\Supplier\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;


class Usersmeta extends Model
{

    protected $table = 'usersmeta';
    protected $fillable = ['user_id', 'addressline1', 'addressline2', 'city', 'state', 'country', 'zipcode', 'phone'];

    public function getUsersMetaDetailsWhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $result = DB::table($this->table)
                ->where($where)
                ->first();
            return $result;
        } else {
            throw new Exception('Argument Not Passed');
        }
    }

    /**
     * Update user data
     * @param array $data
     * @param array $where
     * @return mixed|int
     * @throws Exception
     * @since 09-12-2015
     * @author Dinanath Thakur <dinanaththakur@globussoft.com>
     */
    public function updateUsersMetaDetailsWhere()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $where = func_get_arg(1);
            try {
                $updatedResult = DB::table($this->table)
                    ->where($where)
                    ->update($data);
                return $updatedResult;
            } catch (\Exception $e) {
                return $e->getMessage();
            }

        } else {
            throw new Exception('Argument Not Passed');
        }
    }


}