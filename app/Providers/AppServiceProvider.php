<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(199);

        $this->app->bind(
            'App\Helper\ICheckAction',
            'App\Helper\CheckAction'
        );

        $this->app->bind(
            'App\Repositories\UserRepository\IUserRepository',
            'App\Repositories\UserRepository\UserRepository'
        );

        $this->app->bind(
            'App\Repositories\PermissionRepository\IPermissionRepository',
            'App\Repositories\PermissionRepository\PermissionRepository'
        );

        $this->app->bind(
            'App\Repositories\PermissionDetailRepository\IPermissionDetailRepository',
            'App\Repositories\PermissionDetailRepository\PermissionDetailRepository'
        );

        $this->app->bind(
            'App\Repositories\AreaRepository\IAreaRepository',
            'App\Repositories\AreaRepository\AreaRepository'
        );

        $this->app->bind(
            'App\Repositories\TableRepository\ITableRepository',
            'App\Repositories\TableRepository\TableRepository'
        );

        $this->app->bind(
            'App\Repositories\GroupMenuRepository\IGroupMenuRepository',
            'App\Repositories\GroupMenuRepository\GroupMenuRepository'
        );

        $this->app->bind(
            'App\Repositories\ToppingRepository\IToppingRepository',
            'App\Repositories\ToppingRepository\ToppingRepository'
        );

        $this->app->bind(
            'App\Repositories\MaterialRepository\IMaterialRepository',
            'App\Repositories\MaterialRepository\MaterialRepository'
        );

        $this->app->bind(
            'App\Repositories\SupplierRepository\ISupplierRepository',
            'App\Repositories\SupplierRepository\SupplierRepository'
        );

        $this->app->bind(
            'App\Repositories\CookRepository\ICookRepository',
            'App\Repositories\CookRepository\CookRepository'
        );

        $this->app->bind(
            'App\Repositories\DishRepository\IDishRepository',
            'App\Repositories\DishRepository\DishRepository'
        );

        $this->app->bind(
            'App\Repositories\OrderRepository\IOrderRepository',
            'App\Repositories\OrderRepository\OrderRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
