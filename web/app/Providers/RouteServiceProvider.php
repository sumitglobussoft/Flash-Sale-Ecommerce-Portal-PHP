<?php

namespace FlashSale\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'FlashSale\Http\Modules';
    //        if single router.php is to be used comment above line and uncomment below line
//    protected $namespace = 'FlashSale\Http\Controllers';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        //
//        $modules = config("module.modules");
//        while (list(, $module) = each($modules)) {
//            if (file_exists(public_path() . '/../Http/Modules/' . $module . '/routes.php')) {
//                include public_path() . '/../Http/Modules/' . $module . '/routes.php';
//            }
//        }
        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            $modules = config("module.modules");
            while (list(, $module) = each($modules)) {
                include public_path() . '/../app/Http/Modules/' . $module . '/routes.php';
            }
        });
//        if single router.php is to be used comment above lines and uncomment below line
//            require app_path('Http/routes.php');
    }
}
