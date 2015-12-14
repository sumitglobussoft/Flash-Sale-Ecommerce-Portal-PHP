<?php

namespace FlashSale\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth as AuthUser;
use Illuminate\Support\Facades\DB;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     * @param  Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $parentmodule)
    {
//        dd($request); die;
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/login');
            }
        }
        $userRoleFlag = false;
//        if (AuthUser::check()) {
//            die("checked");
//        } else {
//            die("checked else");
//        }die;
        if (AuthUser::check()) {
            if ($parentmodule == "admin") {
                if ($request->user()->role == 5 || $request->user()->role == 4) {
                    $userRoleFlag = true;
                    $userId = $request->user()->id;
                    if ($request->user()->role == 4) {
                        $currentUrl = $request->getRequestUri();
                        $permissionResult = DB::table('permissions')->select()->join('permission_user_relation', function ($query) {
                            return $query->on('permission_ids', 'like', 'permission_id')
                                ->orWhere('permission_ids', 'like', 'permission_id' . ",&")
                                ->orWhere('permission_ids', 'like', "%," . 'permission_id' . ",%")
                                ->orWhere('permission_ids', 'like', "%," . 'permission_id');
                        })->where('user_id', $userId)
                            ->where('permission_url', $currentUrl)
                            ->first();
                        if ($permissionResult) {
                            return $next($request);
                        } else {
                            return redirect('/admin/access-denied');
                        }
                    }
                }
                if (!$userRoleFlag) {
                    AuthUser::logout();
                    return redirect('/admin/login');
                }
            } else if ($parentmodule == "supplier") {
                if ($request->user()->role == 3) {
                    $userRoleFlag = true;
                }
                if (!$userRoleFlag) {
                    AuthUser::logout();
                    return redirect('/suppliers/login');
                }
            } else if ($parentmodule == "user") {
                if ($request->user()->role == 1 || $request->user()->role == 2) {
                    $userRoleFlag = true;
                }
                if (!$userRoleFlag) {
                    AuthUser::logout();
                    return redirect('/');
                }
            }
        }
        return $next($request);
    }


}
