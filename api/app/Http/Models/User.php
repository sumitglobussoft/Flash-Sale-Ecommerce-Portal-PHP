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

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'last_name', 'email', 'password', 'username', 'profilepic', 'role', 'status'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @param int : $userId
     * @return array
     * @throws "Argument Not Passed"
     * @throws
     * @author Harshal
     * @uses Authentication::login[1]//Used in each service for getting user login token details
     */
    public function getUsercredsWhere()
    {

        if (func_num_args() > 0) {
            $userId = func_get_arg(0);

            try {
                $result = DB::table("users")
                    ->select()
                    ->where('id', $userId)
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
    }

    /**
     * @param int : $userId
     * @return int
     * @throws "Argument Not Passed"
     * @throws
     * @author Harshal
     * @uses Authentication::signup[1]
     */
    public function deleteUserDetails()
    {
        if (func_num_args() > 0) {
            $userId = func_get_arg(0);
            $sql = DB::table('users')->where('id', '=', $userId)->delete();
            if ($sql) {
                return $sql;
            } else {
                return 0;
            }
        }
    }

    /**
     * @param int : $resetcode ,String: $fpdemail, array : $data
     * @return 0,1
     * @throws "Argument Not Passed"
     * @throws
     * @author Harshal
     * @uses authentication::forgotPassword[1]
     */
    public function checkMail()
    {
        if (func_num_args() > 0) {
            $fpdemail = func_get_arg(0);
            $resetcode = func_get_arg(1);
            $data = array(
                'reset_code' => $resetcode
            );
            $row = DB::table("users")
                ->select()
                ->where('email', $fpdemail)
                ->first();
            if ($row) {
                try {
                    $updated = DB::table('users')
                        ->where('email', $fpdemail)
                        ->update($data);
                } catch (Exception $exc) {
                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated)
                    return $updated;
            } else {
                return false;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /**
     * @param int : $resetcode ,String: $fpdemail
     * @return 0,1
     * @throws "Argument Not Passed"
     * @throws
     * @since 22/12/2015
     * @author Harshal
     * @uses authentication::forgotPassword[1]
     */
    public function verifyResetCode()
    {
        if (func_num_args() > 0) {
            $fpwemail = func_get_arg(0);
            $resetcode = func_get_arg(1);
            $row = DB::table("users")
                ->select()
                ->where('email', $fpwemail)
                ->where('reset_code', $resetcode)
                ->first();
            if ($row) {
                return 1;
            } else {
                return 0;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /**
     * @param int : $resetcode ,String: $fpwemail, String : $password
     * @return 0,1
     * @throws "Argument Not Passed"
     * @throws
     * @since 22/12/2015
     * @author Harshal
     * @uses authentication::forgotPassword[1]
     */
    public function resetPassword()
    {
        if (func_num_args() > 0) {
            $fpwemail = func_get_arg(0);
            $fpwresetcode = func_get_arg(1);
            $password = func_get_arg(2);
            $row = DB::table("users")
                ->select()
                ->where('email', $fpwemail)
                ->where('reset_code', $fpwresetcode)
                ->first();

            if ($row) {
                try {
                    $data = array('password' => $password, 'reset_code' => '');
                    $updated = DB::table('users')
                        ->where('email', $fpwemail)
                        ->update($data);
                } catch (Exception $exc) {
                    throw new Exception('Unable to update, exception occured' . $exc);
                }
                if ($updated) {
                    return $updated;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            throw new Exception('Argument not passed');
        }
    }

    /**
     * @param int : $id , array : $data
     * @return 0,1
     * @throws "Argument Not Passed"
     * @throws
     * @author Harshal
     * @uses authentication::login[1]
     */
    public function UpdateUserDetailsbyId()
    {
        if (func_num_args() > 0) {
            $id = func_get_arg(0);
            $data = func_get_arg(1);
            $sql = DB::table('users')->where('id', $id)->update($data);
            return 1;
        }
    }

    /**
     * @param int : $userId
     * @return array
     * @throws "Argument Not Passed"
     * @throws
     * @author Harshal
     * @uses profile::profileSettings[1]
     */
    function getUsercreds()
    {
        if (func_num_args() > 0) {
            $userId = func_get_arg(0);
            $result = DB::table('users')
                ->where('users.id', $userId)
                ->leftJoin('usersmeta', 'users.id', '=', 'usersmeta.user_id')
                ->select('users.id', 'users.name', 'users.last_name', 'users.username', 'users.email', 'users.profilepic', 'usersmeta.addressline1', 'usersmeta.addressline2', 'usersmeta.city', 'usersmeta.state', 'usersmeta.country', 'usersmeta.phone', 'usersmeta.zipcode')
                ->first();
            if ($result) {
                return $result;
            } else {
                return 0;
            }
        }
    }

}
