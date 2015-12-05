<?php

namespace FlashSale\Http\Middleware;

use Closure;
use FlashSale\Http\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class Admin
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
    public function handle($request, Closure $next)
    {

//        print_r($request->all());die;
//        if ($this->auth->hasRole($role)) {
//
//        }
//        return $next($request);

//        var_dump($this->auth->guest());
//        die;

        if ($request->user()->role != 5) {
//            if ($this->auth->check()) {
//                return redirect('/admin/dashboard');
//            }
//        } else {
            Auth::logout();
            return redirect()->guest('/admin/login');
        }
//        if ($this->auth->user()) {
//            if ($request->ajax()) {
//                return response('Unauthorized.', 401);
//            } else {
//                return redirect()->guest('/admin/login');
//            }
//        }
//        if ($this->auth->check()) {
//            return redirect('view');
//        }

        return $next($request);
    }


}
