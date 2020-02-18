<?php

namespace App\Providers;

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
