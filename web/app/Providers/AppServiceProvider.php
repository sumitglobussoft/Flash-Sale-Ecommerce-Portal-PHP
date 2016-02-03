<?php

namespace FlashSale\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $modules = config("module.modules");
        while (list(, $module) = each($modules)) {
//            if(file_exists(public_path() . "/../app/Http/Modules/" . $module . '/routes.php')) {
//                include public_path() . "/../app/Http/Modules/" .$module.'/routes.php';
//            }
//            if(is_dir(__DIR__.'/Http/Modules/'.$module.'/Views')) {
            if (is_dir(public_path() . "/../app/Http/Modules/" . $module . "/Views")) {
                $this->loadViewsFrom(public_path() . "/../app/Http/Modules/" . $module . "/Views", $module);
            }
        }
    }

    /**     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
