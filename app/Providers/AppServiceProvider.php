<?php

namespace App\Providers;

use App\Area;
use App\User;
use App\Table;
use App\Material;
use App\GroupMenu;
use App\WarehouseCook;
use App\MaterialDetail;
use App\OrderDetailTable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


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
            'App\Helper\IGetDateTime',
            'App\Helper\GetDateTime'
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
            'App\Repositories\PositionRepository\IPositionRepository',
            'App\Repositories\PositionRepository\PositionRepository'
        );

        $this->app->bind(
            'App\Repositories\ReportRepository\IReportRepository',
            'App\Repositories\ReportRepository\ReportRepository'
        );

        $this->app->bind(
            'App\Repositories\BookingRepository\IBookingRepository',
            'App\Repositories\BookingRepository\BookingRepository'
        );

        $this->app->bind(
            'App\Repositories\DayRepository\IDayRepository',
            'App\Repositories\DayRepository\DayRepository'
        );

        $this->app->bind(
            'App\Repositories\VoucherRepository\IVoucherRepository',
            'App\Repositories\VoucherRepository\VoucherRepository'
        );

        $this->app->bind(
            'App\Repositories\MethodRepository\IMethodRepository',
            'App\Repositories\MethodRepository\MethodRepository'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('status_area', function ($attribute, $value, $parameters, $validator)
        {
            $check = Area::where('name',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('code_table', function ($attribute, $value, $parameters, $validator)
        {
            $check = Table::where('code',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('status_table', function ($attribute, $value, $parameters, $validator)
        {
            $check = Table::where('name',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('check_status_mat_detail', function ($attribute, $value, $parameters, $validator)
        {
            $check = MaterialDetail::where('name',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('status_groupmenu', function ($attribute, $value, $parameters, $validator)
        {
            $check = GroupMenu::where('name',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('status_material', function ($attribute, $value, $parameters, $validator)
        {
            $check = Material::where('name',$value)->where('status','1')->get();
            return count($check) == 0 ? true : false ;
        });

        Validator::extend('check_old_password', function ($attribute, $value, $parameters, $validator)
        {
            $getOldPw = $this->getPassword(auth()->user()->id);
            return Hash::check($value, $getOldPw, []) == true ? true : false ;
        });

        Validator::extend('check_to_cook', function ($attribute, $value, $parameters, $validator)
        {
            $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $check = OrderDetailTable::selectRaw('count(id) as qty')->whereBetween('updated_at',[$today . " 00:00:00",$today . " 23:59:59"])
                    ->where('status','1')->value('qty');
            return $check == 0 ? true : false ;
        });
    }

    public function getPassword($idUser)
    {
        $password = User::where('id',$idUser)->value('password');
        return $password;
    }
}
