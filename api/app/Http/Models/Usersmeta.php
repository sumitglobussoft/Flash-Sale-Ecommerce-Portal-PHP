<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class Usersmeta extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usersmeta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'addressline1', 'addressline2', 'city', 'state', 'country', 'zipcode', 'phone'];


    /**
     * @param array : $where
     * @return array
     * @throws "Argument Not Passed"
     * @author Harshal
     * @uses Profile::profileAjaxHandler[2]
     */
    public function getUsermetaWhere($where, $selectedColumns = ['*'])
    {
            try {
                $result = DB::table("usersmeta")
                    ->select($selectedColumns)
                    ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                    ->first();
            } catch (QueryException $e) {
                echo $e;
            }
            if ($result) {
                return $result;
            } else {
                return 0;
            }
    }

    /**
     * @param array : $where, $data
     * @return int
     * @throws "Argument Not Passed"
     * @author Harshal
     * @uses Profile::profileAjaxHandler[2]
     */
    public function UpdateUsermetawhere()
    {
        if (func_num_args() > 0) {
            $where = func_get_arg(0);
            $data = func_get_arg(1);
            $sql = DB::table('usersmeta')
                ->whereRaw($where['rawQuery'], isset($where['bindParams']) ? $where['bindParams'] : array())
                ->update($data);
            return 1;
        }
    }

    /**
     * @param array : $data
     * @return int
     * @throws "Argument Not Passed"
     * @author Harshal
     * @uses Profile::profileAjaxHandler[2]
     */
    public function addUsermeta()
    {
        if (func_num_args() > 0) {
            $data = func_get_arg(0);
            $sql = DB::table('usersmeta')->insert($data);
            if ($sql) {
                return $sql;
            } else {
                return 0;
            }
        }
    }


}