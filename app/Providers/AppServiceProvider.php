<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Auth;
use App\Libraries\Constant;
use Request;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.admin.menu', function ($view) {
            $menus = array();
            $userMenuList = Constant::getMenuList();
            $view->with('usermenu', $userMenuList)->with('menus', $userMenuList);
        });
    }
}
