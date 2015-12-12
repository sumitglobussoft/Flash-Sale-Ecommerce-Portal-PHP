<?php

namespace FlashSale\Http\Modules\Admin\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    private static $_instance = null;

    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public static function getInstance()
    {
        if (!is_object(self::$_instance))  //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
            self::$_instance = new User();
        return self::$_instance;
    }

    public function getUserWhere($email, $password)
    {
        $result = User::where('email', $email)
            ->where('password', bcrypt($password))
            ->first();
//        $result = User::all();
        return $result;
    }

    /**
     * @param $columnName
     * @param $condition
     * @param $coulumnValue
     * @return mixed
     */
    /*
     * TEST FUNCTION
     */
    public function getUserByColumnConditionAndValue($columnName, $condition, $coulumnValue)
    {
        $result = User::where($columnName, $condition, $coulumnValue)
            ->first();
        return $result;
    }

    /**
     * @param $userId
     * @return mixed
     * @author Akash M. Pai <akashpai@globussoft.com>
     */
    public function getUserById($userId)
    {
        $result = User::whereId($userId)->first();
        return $result;
    }

    public function temp()
    {

    }


}
