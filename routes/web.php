<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ReportController;

Auth::routes(['register' => false]);

Route::get('/customer/index', 'CustomerController@index')->name('customer.index');
Route::group(['middleware' => ['auth']], function() {

    // New day
    Route::group(['prefix' => 'day'], function () {
        Route::get('hello', 'DayController@hello')->name('hello');
        Route::get('open', 'DayController@open')->name('day.open');
        Route::get('close', 'DayController@close')->name('day.close');
    });

    // Permission
    Route::group(['prefix' => 'permission'], function() {
        Route::get('index', 'PermissionController@index')->name('permission.index');
        Route::post('store', 'PermissionController@store')->name('permission.p_store');
        Route::get('viewupdate/{id}','PermissionController@getEdit')->name('permission.update');
        Route::post('updateName/{id}','PermissionController@updateName')->name('permission.p_updatename');
        Route::get('viewUpdateDetail/{id}','PermissionController@viewUpdateDetail')->name('permission.updatedetail');
        Route::post('updateDetail/{id}','PermissionController@updateDetail')->name('permission.p_updatedetail');
        Route::get('delete/{id}','PermissionController@delete')->name('permission.delete');

    });

    // Permission Detail
    Route::group(['prefix' => 'per_detail'], function() {
        Route::get('index', 'PermissionDetailController@index')->name('perdetail.index');
        Route::post('store', 'PermissionDetailController@store')->name('perdetail.p_store');
        Route::get('viewupdate/{id}','PermissionDetailController@getEdit')->name('perdetail.update');
        Route::post('update/{id}','PermissionDetailController@postEdit')->name('perdetail.p_update');
        Route::get('delete/{id}','PermissionDetailController@delete')->name('perdetail.delete');
    });

    // UserPermsision
    Route::group(['prefix' => 'user'], function() {
        Route::get('index', 'UserController@index')->name('user.index');
        Route::get('store', 'UserController@viewstore')->name('user.store');
        Route::post('store', 'UserController@store')->name('user.p_store');
        Route::post('update_username/{id}', 'UserController@updateUsername')->name('user.p_updateusername');
        Route::get('viewShift/{id}', 'UserController@viewShift')->name('user.shift');
        Route::get('updateshift/{id}', 'UserController@updateShift')->name('user.p_shift');
        Route::get('viewUpdatePassword/{id}', 'UserController@viewUpdatePassword')->name('user.updatepassword');
        Route::post('update_password/{id}','UserController@updatePassword')->name('user.p_updatepassword');
        Route::get('viewUpdateRole/{id}', 'UserController@viewUpdateRole')->name('user.updaterole');
        Route::post('updateRole/{id}', 'UserController@updateRole')->name('user.p_updaterole');
        Route::post('updatePosition/{id}', 'UserController@updatePosition')->name('user.p_updateposition');
        Route::get('delete/{id}', 'UserController@delete')->name('user.delete');
    });

    // Area
    Route::group(['prefix' => 'area'], function() {
        Route::get('index', 'AreaController@index')->name('area.index');
        Route::post('store', 'AreaController@store')->name('area.p_store');
        Route::post('update/{id}', 'AreaController@update')->name('area.update');
        Route::get('delete/{id}', 'AreaController@delete')->name('area.delete');
        Route::get('import', 'AreaController@importExcel')->name('area.importexcel');
    });

    // Table
    Route::group(['prefix' => 'table'], function() {
        Route::post('store', 'TableController@store')->name('table.p_store');
        Route::post('updateName/{id}', 'TableController@updateName')->name('table.p_updatename');
        Route::post('updateArea/{id}', 'TableController@updateArea')->name('table.p_updatearea');
        Route::post('updateChair/{id}', 'TableController@updateChair')->name('table.p_updatechair');
        Route::get('delete/{id}', 'TableController@delete')->name('table.delete');
    });

    // Group Menu
    Route::group(['prefix' => 'groupmenu'], function() {
        Route::get('index', 'GroupMenuController@index')->name('groupmenu.index');
        Route::get('viewstore', 'GroupMenuController@viewStore')->name('groupmenu.v_store');
        Route::post('store', 'GroupMenuController@store')->name('groupmenu.store');
        Route::post('updatename/{id}', 'GroupMenuController@updateName')->name('groupmenu.updatename');
        Route::post('updatecook/{id}', 'GroupMenuController@updateCook')->name('groupmenu.updatecook');
        Route::get('delete/{id}', 'GroupMenuController@delete')->name('groupmenu.delete');
        Route::get('export', 'GroupMenuController@exportExcel')->name('groupmenu.exportexcel');
    });

    // Topping
    Route::group(['prefix' => 'topping'], function() {
        Route::get('index', 'ToppingController@index')->name('topping.index');
        Route::post('store', 'ToppingController@store')->name('topping.p_store');
        Route::post('updatename/{id}', 'ToppingController@updateName')->name('topping.p_updatename');
        Route::post('updateprice/{id}', 'ToppingController@updatePrice')->name('topping.p_updateprice');
        Route::post('updategroup/{id}', 'ToppingController@updateGroup')->name('topping.p_updategroup');
        Route::get('delete/{id}', 'ToppingController@delete')->name('topping.delete');
    });

    // Supplier
    Route::group(['prefix' => 'supplier'], function() {
        Route::get('index', 'SupplierController@index')->name('supplier.index');
        Route::get('store', 'SupplierController@viewStore')->name('supplier.store');
        Route::post('store', 'SupplierController@store')->name('supplier.p_store');
        Route::get('viewupdate/{id}', 'SupplierController@viewUpdate')->name('supplier.update');
        Route::post('update/{id}', 'SupplierController@update')->name('supplier.p_update');
        Route::post('updateName/{id}', 'SupplierController@updateName')->name('supplier.p_updatename');
        Route::get('delete/{id}', 'SupplierController@delete')->name('supplier.delete');
    });

    // Cook

    Route::group(['prefix' => 'cook'], function() {
        Route::get('index', 'CookController@index')->name('cook.index');
        Route::get('store', 'CookController@store')->name('cook.store');
        Route::post('update/{id}', 'CookController@update')->name('cook.update');
    });

    // Dishes
    Route::group(['prefix' => 'dishes'], function() {
        Route::get('index', 'DishesController@index')->name('dishes.index');
        Route::get('store', 'DishesController@viewStore')->name('dishes.store');
        Route::post('store', 'DishesController@store')->name('dishes.p_store');
        Route::post('updateImage/{id}', 'DishesController@updateImage')->name('dishes.p_updateimage');
        Route::post('updateSalePrice/{id}', 'DishesController@updateSalePrice')->name('dishes.p_updatesaleprice');
        Route::post('updateUnit/{id}', 'DishesController@updateUnit')->name('dishes.p_updateunit');
        Route::post('updateStatus/{id}', 'DishesController@updateStatus')->name('dishes.p_updatestatus');
        Route::post('updateNote/{id}', 'DishesController@updateNote')->name('dishes.p_updatenote');
        Route::get('delete/{id}', 'DishesController@delete')->name('dishes.delete');
        Route::get('export', 'DishesController@exportExcel')->name('dishes.exportexcel');
    });

    // Material
    Route::group(['prefix' => 'material'], function() {
        Route::get('index', 'MaterialController@index')->name('material.index');
        Route::post('store', 'MaterialController@store')->name('material.store');
        Route::post('updatename/{id}', 'MaterialController@updateName')->name('material.updateName');
        Route::post('updategroup/{id}', 'MaterialController@updateGroup')->name('material.updateGroup');
        Route::get('delete/{id}', 'MaterialController@delete')->name('material.delete');
        Route::get('export', 'MaterialController@exportExcel')->name('material.exportexcel');
    });

    // Material Action

    Route::group(['prefix' => 'material_action'], function() {
        Route::get('index', 'MaterialActionController@index')->name('material_action.index');
        Route::get('viewStore/{id}', 'MaterialActionController@viewStore')->name('material_action.store');
        Route::post('store/{id}', 'MaterialActionController@store')->name('material_action.p_store');
        Route::get('moreDetail/{id}', 'MaterialActionController@showMoreDetail')->name('material_action.detail');
        Route::post('update/{id}', 'MaterialActionController@update')->name('material_action.p_update');
        Route::get('delete/{id}', 'MaterialActionController@delete')->name('material_action.delete');
    });

    // Material Detail
    Route::group(['prefix' => 'material_detail'], function() {
        Route::get('index', 'MaterialDetailController@index')->name('material_detail.index');
        Route::post('store', 'MaterialDetailController@store')->name('material_detail.store');
        Route::post('updateName/{id}', 'MaterialDetailController@updateName')->name('material_detail.p_updatename');
        Route::post('updateType/{id}', 'MaterialDetailController@updateType')->name('material_detail.p_updatetype');
        Route::get('delete/{id}', 'MaterialDetailController@delete')->name('material_detail.delete');
        Route::get('export', 'MaterialDetailController@exportExcel')->name('material_detail.exportexcel');
    });

    // Order
    Route::group(['prefix' => 'order'], function() {
        Route::get('index', 'OrderController@showTable')->name('order.index');
        Route::get('orderTable', 'OrderController@orderTable')->name('order.order');
        Route::post('tempOrder','OrderController@orderTablePost')->name('order.temporder');
        Route::get('viewUpdate/{id}', 'OrderController@viewUpdate')->name('order.update');
        Route::post('update/{id}','OrderController@update')->name('order.p_update');
        Route::get('addmoredish/{id}','OrderController@viewaddMoreDish')->name('order.addmore');
        Route::post('addmoredish/{id}','OrderController@addMoreDish')->name('order.p_addmore');
        Route::get('deletedish/{id}','OrderController@deleteDish')->name('order.delete');
        Route::get('delete/{idOrderTable}','OrderController@deleteOrderTable')->name('order.deleteorder');
    });

    // Bill
    Route::group(['prefix' => 'bill'], function () {
        Route::get('index', 'OrderController@showBill')->name('bill.index');
        Route::get('detail/{id}', 'OrderController@getDetailBill')->name('bill.detail');
    });
    // CookingScreen
    Route::group(['prefix' => 'cook_screen'], function() {
        Route::get('index', 'CookScreenController@index')->name('cook_screen.index');
        Route::get('detail/{id}', 'CookScreenController@getDetail')->name('cook_screen.detail');
        Route::get('materialcook/{id}', 'CookScreenController@getMaterialByIdCook')->name('cook_screen.materialcook');
        Route::post('update/{id}/{idCook}', 'CookScreenController@update')->name('cook_screen.p_update');
        Route::post('updateFinish/{id}/{idCook}', 'CookScreenController@updateFinish')->name('cook_screen.updatefinish');
        Route::get('updateMaterialDetail/{idMaterial}/{idCook}', 'CookScreenController@updateMaterialDetail')
                ->name('cook_screen.p_updatematerial');
    });

    // Pay
    Route::group(['prefix' => 'pay'], function() {
        Route::get('index/{id}', 'PayController@index')->name('pay.index');
        Route::get('print/{id}', 'PayController@print')->name('pay.print');
        Route::post('update/{id}', 'PayController@update')->name('pay.p_update');
        Route::get('bill/{id}', 'PayController@showBill')->name('pay.bill');
    });

    // WareHouse
    Route::group(['prefix' => 'warehouse'], function() {
        Route::get('index/', 'WareHouseController@index')->name('warehouse.index');
        Route::post('updateLimitStock/{id}', 'WareHouseController@updateLimitStock')->name('warehouse.p_updateLimitStock');
        Route::get('reportView', 'WareHouseController@reportIndex')->name('reportwarehouse.index');
        Route::post('report', 'WareHouseController@report')->name('reportwarehouse.p_report');
        Route::get('reportdetail/{id}/{dateStart}/{dateEnd}', 'WareHouseController@getDetailReport')->name('reportwarehouse.detail');
        Route::get('export/{dateStart}/{dateEnd}', 'WareHouseController@exportExcel')->name('warehouse.exportexcel');
    });

    //Warehouse Cook
    Route::group(['prefix' => 'warehousecook'], function() {
        Route::get('index', 'WareHouseCookController@index')->name('warehousecook.index');
        Route::get('reset', 'WareHouseCookController@reset')->name('warehousecook.reset');
        Route::get('viewImport', 'WareHouseCookController@viewImport')->name('warehousecook.import');
        Route::post('report', 'WareHouseCookController@report')->name('warehousecook.report');
        Route::get('exportExcel/{cook}/{dateStart}/{dateEnd}', 'WareHouseCookController@exportExcel')->name('warehousecook.exportexcel');
    });

    // Import Coupon
    Route::group(['prefix' => 'importcoupon'], function() {
        Route::get('index/', 'ImportCouponController@index')->name('importcoupon.index');
        Route::get('typeimport/', 'ImportCouponController@getType')->name('importcoupon.gettype');
        Route::get('viewImport/', 'ImportCouponController@viewImport')->name('importcoupon.import');
        Route::post('import/', 'ImportCouponController@import')->name('importcoupon.p_import');
        Route::post('importplan/', 'ImportCouponController@importPlan')->name('importcoupon.p_importplan');
        Route::get('detail/{id}', 'ImportCouponController@getDetail')->name('importcoupon.detail');
        Route::post('detail/{id}', 'ImportCouponController@updateDetail')->name('importcoupon.p_detail');
        Route::get('printdetail/{id}', 'ImportCouponController@printDetail')->name('importcoupon.print_detail');
    });

    // Export Coupon
    Route::group(['prefix' => 'exportcoupon'], function() {
        Route::get('index/', 'ExportCouponController@index')->name('exportcoupon.index');
        Route::get('viewExport/', 'ExportCouponController@viewExport')->name('exportcoupon.export');
        Route::post('export/', 'ExportCouponController@export')->name('exportcoupon.p_export');
        Route::post('exportSupplier/', 'ExportCouponController@exportSupplier')->name('exportcoupon.p_exportSupplier');
        Route::get('destroyWarehouse/', 'ExportCouponController@viewDestroyWarehouse')->name('exportcoupon.destroywarehouse');
        Route::post('destroyWarehouse/', 'ExportCouponController@destroyWarehouse')->name('exportcoupon.p_destroywarehouse');
        Route::get('destroyWarehouseCook/{id}', 'ExportCouponController@viewDestroyWarehouseCook')->name('exportcoupon.destroywarehousecook');
        Route::post('destroyWarehouseCook/', 'ExportCouponController@destroyWarehouseCook')->name('exportcoupon.p_destroywarehousecook');
        Route::get('detail/{id}', 'ExportCouponController@getDetail')->name('exportcoupon.detail');
        Route::get('detailsupplier/{id}', 'ExportCouponController@getDetailExportSupplier')->name('exportcoupon.detailsupplier');
        Route::get('printdetail/{id}', 'ExportCouponController@printDetail')->name('exportcoupon.print_detail');
    });

    // WareHouse Export
    Route::group(['prefix' => 'warehouse_export'], function() {
        Route::get('cook/', 'WareHouseExportController@exportCookIndex')->name('warehouse_exportcook.index');
        Route::get('viewExport/', 'WareHouseExportController@viewExport')->name('warehouse_export.export');
        Route::post('export/', 'WareHouseExportController@export')->name('warehouse_export.p_export');
        Route::get('detail/{code}', 'WareHouseExportController@getDetail')->name('warehouse_export.detail');
        Route::get('detail/{code}', 'WareHouseExportController@getDetail')->name('warehouse_export.detail');
        Route::get('printdetail/{code}', 'WareHouseExportController@printDetail')->name('warehouse_export.detail');
    });

    // Shift
    Route::group(['prefix' => 'shift'], function() {
        Route::get('index/', 'ShiftController@index')->name('shift.index');
        Route::post('store/', 'ShiftController@store')->name('shift.p_store');
        Route::post('updateName/{id}', 'ShiftController@updateName')->name('shift.p_updatename');
        Route::post('updateTime/{id}', 'ShiftController@updateTime')->name('shift.p_updatetime');
        Route::get('/delete/{id}', 'ShiftController@delete')->name('shift.delete');
    });

    // Position
    Route::group(['prefix' => 'postion'], function() {
        Route::get('index', 'PositionController@index')->name('position.index');
        Route::post('store', 'PositionController@store')->name('position.p_store');
        Route::post('updatename/{id}', 'PositionController@updateName')->name('position.p_updatename');
        Route::post('updatesalary/{id}', 'PositionController@updateSalary')->name('position.p_updatesalary');
        Route::get('delete/{id}', 'PositionController@delete')->name('position.delete');
        //Route::get('export/', 'WareHouseController@testExcel')->name('excel.index');
    });

    Route::group(['prefix' => 'voucher'], function () {
        Route::get('index', 'VoucherController@index')->name('voucher.index');

        Route::group(['prefix' => 'payment'], function () {
            Route::get('object', 'VoucherController@chooseObject')->name('voucher.payment');
            //Route::get('store', 'VoucherController@storePaymentView')->name('voucher.storepayment');
            Route::post('store', 'VoucherController@storePayment')->name('voucher.p_storepayment');
            Route::post('storeemergency', 'VoucherController@storePaymentEmergency')->name('voucher.p_storepaymentemergency');
        });
    });

    // Report
    Route::group(['prefix' => 'report'], function() {

        Route::group(['prefix' => 'overview'], function() {
            Route::get('index', 'ReportController@overview')->name('overview.index');
        });

        Route::group(['prefix' => 'order'], function() {
            Route::get('view', 'ReportController@viewReportOrder')->name('report.order');
            Route::post('post', 'ReportController@reportOrder')->name('report.p_order');
            Route::get('export/{dateStart}/{dateEnd}','ReportController@exportOrderReport')->name('report.exportorder');
        });

        Route::group(['prefix' => 'table'], function() {
            Route::get('view', 'ReportController@viewReportTable')->name('report.table');
            Route::post('post', 'ReportController@reportTable')->name('report.p_table');
            Route::get('export/{dateStart}/{dateEnd}/{status}','ReportController@exportTableReport')->name('report.exporttable');
        });

        Route::group(['prefix' => 'dish'], function() {
            Route::get('view', 'ReportController@viewDish')->name('report.dish');
            Route::post('post', 'ReportController@reportDish')->name('report.p_dish');
            Route::get('export/{dateStart}/{dateEnd}/{idGroupMenu}','ReportController@exportDishReport')->name('report.exportdish');
            Route::get('destroyView', 'ReportController@viewDestroyDish')->name('report.destroydish');
            Route::post('destroyViewPost', 'ReportController@reportDestroyDish')->name('report.p_destroydish');
            Route::get('exportdestroydish/{dateStart}/{dateEnd}/{idGroupMenu}','ReportController@exportDestroyDishReport')->name('report.exportdestroydish');
        });

        Route::group(['prefix' => 'supplier'], function () {
            Route::get('view', 'ReportController@viewReportSupplier')->name('report.supplier');
            Route::post('post', 'ReportController@reportSupplier')->name('report.p_supplier');
            Route::get('export/{dateStart}/{dateEnd}/{idSupplier}','ReportController@exportSupplierReport')->name('report.exportsupplier');
        });

        Route::group(['prefix' => 'profit'], function () {
            Route::get('index', 'ReportController@profit')->name('profit.index');
        });

    });

    // Booking
    Route::group(['prefix' => 'booking'], function () {
        Route::get('index', 'BookingController@index')->name('booking.index');
        Route::post('store', 'BookingController@store')->name('booking.store');
    });

    // Method Math
    Route::group(['prefix' => 'method'], function () {
        Route::get('index','MethodController@index')->name('method.index');
        Route::get('getQty','MethodController@getQty')->name('method.storyQty');
        Route::get('storeText','MethodController@viewStoreText')->name('method.storeText');
        Route::post('storeText','MethodController@storeText')->name('method.p_storeText');
        Route::post('storeNumber/{id}','MethodController@storeNumber')->name('method.p_storeNumber');
        Route::get('update/{id}','MethodController@update')->name('method.update');
        Route::get('delete/{id}','MethodController@delete')->name('method.delete');
    });

    // Plan Import Material

    Route::group(['prefix' => 'plan'], function() {
        Route::group(['prefix' => 'import'], function() {
            Route::get('index','PlanController@index')->name('importplan.index');
            Route::get('viewstore','PlanController@viewStore')->name('importplan.viewstore');
            Route::post('store','PlanController@store')->name('importplan.store');
            Route::get('detail/{id}/{idSupplier}','PlanController@getDetail')->name('importplan.detail');
            Route::post('detail','PlanController@postDetail')->name('importplan.p_detail');
        });
    });

    // Ajax
    include "ajax.php";
});
