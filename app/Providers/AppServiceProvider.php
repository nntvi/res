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
            'App\Repositories\AnnouceRepository\IAnnouceRepository',
            'App\Repositories\AnnouceRepository\AnnouceRepository'
        );

        $this->app->bind(
            'App\Repositories\AjaxRepository\IAjaxRepository',
            'App\Repositories\AjaxRepository\AjaxRepository'
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
            'App\Repositories\MaterialDetailRepository\IMaterialDetailRepository',
            'App\Repositories\MaterialDetailRepository\MaterialDetailRepository'
        );

        $this->app->bind(
            'App\Repositories\MaterialActionRepository\IMaterialActionRepository',
            'App\Repositories\MaterialActionRepository\MaterialActionRepository'
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
            'App\Repositories\CookScreenRepository\ICookScreenRepository',
            'App\Repositories\CookScreenRepository\CookScreenRepository'
        );

        $this->app->bind(
            'App\Repositories\DishRepository\IDishRepository',
            'App\Repositories\DishRepository\DishRepository'
        );

        $this->app->bind(
            'App\Repositories\OrderRepository\IOrderRepository',
            'App\Repositories\OrderRepository\OrderRepository'
        );

        $this->app->bind(
            'App\Repositories\PayRepository\IPayRepository',
            'App\Repositories\PayRepository\PayRepository'
        );

        $this->app->bind(
            'App\Repositories\WarehouseRepository\IWarehouseRepository',
            'App\Repositories\WarehouseRepository\WarehouseRepository'
        );

        $this->app->bind(
            'App\Repositories\WarehouseCookRepository\IWarehouseCookRepository',
            'App\Repositories\WarehouseCookRepository\WarehouseCookRepository'
        );

        $this->app->bind(
            'App\Repositories\ImportCouponRepository\IImportCouponRepository',
            'App\Repositories\ImportCouponRepository\ImportCouponRepository'
        );

        $this->app->bind(
            'App\Repositories\ExportCouponRepository\IExportCouponRepository',
            'App\Repositories\ExportCouponRepository\ExportCouponRepository'
        );

        $this->app->bind(
            'App\Repositories\ShiftRepository\IShiftRepository',
            'App\Repositories\ShiftRepository\ShiftRepository'
        );

        $this->app->bind(
            'App\Repositories\SalaryRepository\ISalaryRepository',
            'App\Repositories\SalaryRepository\SalaryRepository'
        );

        $this->app->bind(
            'App\Repositories\ReportRepository\IReportRepository',
            'App\Repositories\ReportRepository\ReportRepository'
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
