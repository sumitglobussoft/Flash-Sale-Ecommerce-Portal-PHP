<?php

namespace FlashSale\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth as AuthUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        $lang = Session::get ('locale');
        if ($lang != null) \App::setLocale($lang);
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
//            $userRole = $request->user()->role;
            if ($parentmodule == "admin") {
                if (Session::has('fs_admin')) {    // || Session::has('fs_manager')) { // $userRole = 5,4
                    $userRoleFlag = true;
                    /* IN TEST MODE FOR ADMIN AND MANAGER LOGIN IN SAME WINDOW USING SAME LAYOUT BUT DIFFERENT ROUTES
                    /* ROLE BASED PERMISSION CHECK BLOCK START
                     if (Session::has('fs_manager')) { //$userRole = 4) {
                         /* USER BASED PERMISSION CHECK BLOCK START
                         $userId = Session::get('fs_manager')['id'];
                         $currentUrl = $request->getRequestUri();
                         $explodedUrl = explode("/admin/", $currentUrl);
 //                        if (count($explodedUrl) > 1) {
                         if ($explodedUrl[1] != 'logout') {
                             $permissionResult = DB::table('permissions')->select()->where('permission_url', "$currentUrl")->first();
                             if ($permissionResult) {
                                 $permissionId = $permissionResult->permission_id;
                                 $userPermissionResult = DB::table('permission_user_relation')->select()->where('permission_ids', 'like', $permissionId)
                                     ->orWhere('permission_ids', 'like', $permissionId . ",&")
                                     ->orWhere('permission_ids', 'like', "%," . $permissionId . ",%")
                                     ->orWhere('permission_ids', 'like', "%," . $permissionId)
                                     ->where('user_id', $userId)
                                     ->first();
                                 if ($userPermissionResult) {
 //                                        $redirectUrlForManager = "/manager/" . $explodedUrl[1];
 //                                        return redirect($redirectUrlForManager);
                                     return $next($request);
                                 } else {
                                     return redirect('/admin/access-denied');//'/manager/access-denied');
                                 }
                             } else {
                                 return redirect('/admin/page-not-found');//'/manager/page-not-found');
                             }
                         }
 //                        }
                         /* USER BASED PERMISSION CHECK BLOCK END
                     }
                     /* ROLE BASED PERMISSION CHECK BLOCK END */
                }
                if (!$userRoleFlag) {
                    return redirect('/admin/login');
                }
            } else if ($parentmodule == "manager") {//THIS BLOCK IS USED IF MANAGER URL HAS TO BE DIFFERENT THAN /admin/{route}
                /* ROLE BASED PERMISSION CHECK BLOCK START */
                if (Session::has('fs_manager')) { //$userRole = 4) {
                    $userRoleFlag = true;
                    /* USER BASED PERMISSION CHECK BLOCK START */
                    $userId = Session::get('fs_manager')['id'];
                    $currentUrl = $request->getRequestUri();
                    $permissionResult = DB::table('permissions')->select()->where('permission_url', "$currentUrl")->first();
                    if ($permissionResult) {
                        $permissionId = $permissionResult->permission_id;
                        $userPermissionResult = DB::table('permission_user_relation')->select()->where('permission_ids', 'like', $permissionId)
                            ->orWhere('permission_ids', 'like', $permissionId . ",&")
                            ->orWhere('permission_ids', 'like', "%," . $permissionId . ",%")
                            ->orWhere('permission_ids', 'like', "%," . $permissionId)
                            ->where('user_id', $userId)
                            ->first();
                        if ($userPermissionResult) {
                            return $next($request);
                        } else {
                            return redirect('/manager/access-denied');
                        }
                    } else {
                        return redirect('/manager/page-not-found');
                    }
                    /* USER BASED PERMISSION CHECK BLOCK END */
                }
                /* ROLE BASED PERMISSION CHECK BLOCK END */
                if (!$userRoleFlag) {
                    return redirect('/manager/login');
                }
            } else if ($parentmodule == "supplier") {
                if (Session::has('fs_supplier')) { //$userRole == 3) {
                    $userRoleFlag = true;
                }
                if (!$userRoleFlag) {
                    return redirect('/supplier/login');
                }
            } else if ($parentmodule == "user") {
                if (Session::has('fs_buyer') || Session::has('fs_customer') || Session::has('fs_admin')) { //ALSO USE " || Session::has('fs_supplier')" in if condition if SUPPLIER CAN ACT AS A BUYER/CUSTOMER  //$userRole = 1,2
                    $userRoleFlag = true;
                }
                if (!$userRoleFlag) {
                    return redirect('/');
                }
            }
        }
        return $next($request);
    }


}
