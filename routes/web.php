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



Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('layouts');
});


Route::group(['middleware' => ['auth']], function() {
    // Permission
    Route::get('/permission/index', 'PermissionController@index')->name('permission.index');
    Route::post('/permission/store', 'PermissionController@store')->name('permission.p_store');
    Route::get('/permission/viewupdate/{id}','PermissionController@getEdit')->name('permission.update');
    Route::post('/permission/update/{id}','PermissionController@postEdit')->name('permission.p_update');
    Route::get('/permission/delete/{id}','PermissionController@delete')->name('permission.delete');

    // Permission Detail
    Route::get('/per_detail/index', 'PermissionDetailController@index')->name('perdetail.index');
    Route::post('/per_detail/store', 'PermissionDetailController@store')->name('perdetail.p_store');
    Route::get('/per_detail/viewupdate/{id}','PermissionDetailController@getEdit')->name('perdetail.update');
    Route::post('/per_detail/update/{id}','PermissionDetailController@postEdit')->name('perdetail.p_update');
    Route::get('/per_detail/delete/{id}','PermissionDetailController@delete')->name('perdetail.delete');

    // UserPermsision
    Route::get('/user/index', 'UserController@index')->name('user.index');
    Route::get('/user/store', 'UserController@viewstore')->name('user.store');
    Route::post('/user/store', 'UserController@store')->name('user.p_store');
    Route::get('/user/update/{id}', 'UserController@viewUpdate')->name('user.update');
    Route::post('/user/update/{id}', 'UserController@update')->name('user.p_update');
    Route::post('/user/update_password/{id}','UserController@updatePassword')->name('user.p_updatepassword');
    Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

    // Area
    Route::get('/area/index', 'AreaController@index')->name('area.index');
    Route::post('/area/store', 'AreaController@store')->name('area.p_store');
    Route::post('/area/update/{id}', 'AreaController@update')->name('area.update');
    Route::get('/area/delete/{id}', 'AreaController@delete')->name('area.delete');

    // Table
    Route::get('/table/index', 'TableController@index')->name('table.index');
    Route::get('/table/store', 'TableController@viewStore')->name('table.store');
    Route::post('/table/store', 'TableController@store')->name('table.p_store');

    Route::get('/table/viewupdate/{id}', 'TableController@viewUpdate')->name('table.update');
    Route::post('/table/update/{id}', 'TableController@update')->name('table.p_update');
    Route::get('/table/delete/{id}', 'TableController@delete')->name('table.delete');

    // Group Menu
    Route::get('/groupmenu/index', 'GroupMenuController@index')->name('groupmenu.index');
    Route::get('/groupmenu/viewstore', 'GroupMenuController@viewStore')->name('groupmenu.v_store');
    Route::post('/groupmenu/store', 'GroupMenuController@store')->name('groupmenu.store');
    Route::post('/groupmenu/search', 'GroupMenuController@search')->name('groupmenu.search');
    Route::post('/groupmenu/update/{id}', 'GroupMenuController@update')->name('groupmenu.update');
    Route::get('/groupmenu/delete/{id}', 'GroupMenuController@delete')->name('groupmenu.delete');

    // Topping
    Route::get('/topping/index', 'ToppingController@index')->name('topping.index');
    Route::post('/topping/store', 'ToppingController@store')->name('topping.p_store');
    Route::post('/topping/update/{id}', 'ToppingController@update')->name('topping.p_update');
    Route::get('/topping/delete/{id}', 'ToppingController@delete')->name('topping.delete');

    // Supplier
    Route::get('/supplier/index', 'SupplierController@index')->name('supplier.index');
    Route::get('/supplier/store', 'SupplierController@viewStore')->name('supplier.store');
    Route::post('/supplier/store', 'SupplierController@store')->name('supplier.p_store');
    Route::get('/supplier/viewupdate/{id}', 'SupplierController@viewUpdate')->name('supplier.update');
    Route::post('/supplier/update/{id}', 'SupplierController@update')->name('supplier.p_update');
    Route::get('/supplier/delete/{id}', 'SupplierController@delete')->name('supplier.delete');

    // Cook
    Route::get('/cook/index', 'CookController@index')->name('cook.index');
    Route::get('/cook/store', 'CookController@store')->name('cook.store');
    Route::post('/cook/update/{id}', 'CookController@update')->name('cook.update');

    // Dishes
    Route::get('/dishes/index', 'DishesController@index')->name('dishes.index');
    Route::get('/dishes/store', 'DishesController@viewStore')->name('dishes.store');
    Route::post('/dishes/store', 'DishesController@store')->name('dishes.p_store');
    Route::get('/dishes/viewupdate/{id}', 'DishesController@viewUpdate')->name('dishes.update');
    Route::post('/dishes/update/{id}', 'DishesController@update')->name('dishes.p_update');
    Route::get('/dishes/delete/{id}', 'DishesController@delete')->name('dishes.delete');
    Route::post('/dishes/search', 'DishesController@search')->name('dishes.search');

    // Material Group
    Route::get('/material/index', 'MaterialController@index')->name('material.index');
    Route::post('/material/store', 'MaterialController@store')->name('material.store');
    Route::post('/material/update/{id}', 'MaterialController@update')->name('material.update');
    Route::get('/material/delete/{id}', 'MaterialController@delete')->name('material.delete');

    // Material Action
    Route::get('/material_action/index', 'MaterialActionController@index')->name('material_action.index');
    Route::get('/material_action/viewStore', 'MaterialActionController@viewStore')->name('material_action.store');
    Route::post('/material_action/store', 'MaterialActionController@store')->name('material_action.p_store');
    Route::get('/material_action/moreDetail/{id}', 'MaterialActionController@showMoreDetail')->name('material_action.detail');
    Route::get('/material_action/update/{id}', 'MaterialActionController@viewUpdate')->name('material_action.update');
    Route::post('/material_action/update/{id}', 'MaterialActionController@update')->name('material_action.p_update');
    Route::get('/material_action/delete/{id}', 'MaterialActionController@delete')->name('material_action.delete');

    // Material Detail
    Route::get('/material_detail/index', 'MaterialDetailController@index')->name('material_detail.index');
    Route::post('/material_detail/store', 'MaterialDetailController@store')->name('material_detail.store');
    Route::post('/material_detail/update/{id}', 'MaterialDetailController@update')->name('material_detail.update');
    Route::get('/material_detail/delete/{id}', 'MaterialDetailController@delete')->name('material_detail.delete');
    Route::post('/material_detail/search', 'MaterialDetailController@search')->name('material_detail.search');

    // Order
    Route::get('/order/index', 'OrderController@showTable')->name('order.index');
    Route::get('/order/orderTable', 'OrderController@orderTable')->name('order.order');
    Route::post('/order/tempOrder','OrderController@orderTablePost')->name('order.temporder');
    Route::get('/order/viewUpdate/{id}', 'OrderController@viewUpdate')->name('order.update');
    Route::post('/order/update/{id}','OrderController@update')->name('order.p_update');
    Route::get('/order/addmoredish/{id}','OrderController@viewaddMoreDish')->name('order.addmore');
    Route::post('/order/addmoredish/{id}','OrderController@addMoreDish')->name('order.p_addmore');
    Route::get('/order/deletedish/{id}','OrderController@deleteDish')->name('order.delete');

    // CookingScreen
    Route::get('/cook_screen/index', 'CookScreenController@index')->name('cook_screen.index');
    Route::get('/cook_screen/detail/{id}', 'CookScreenController@getDetail')->name('cook_screen.detail');
    Route::post('/cook_screen/update/{id}', 'CookScreenController@update')->name('cook_screen.p_update');

    // Pay
    Route::get('/pay/index/{id}', 'PayController@index')->name('pay.index');
    Route::post('/pay/update/{id}', 'PayController@update')->name('pay.p_update');

    // WareHouse
    Route::get('/warehouse/index/', 'WareHouseController@index')->name('warehouse.index');
    Route::get('/warehouse/viewImport/', 'WareHouseController@viewImport')->name('warehouse.import');
    Route::post('/warehouse/import/', 'WareHouseController@import')->name('warehouse.p_import');
    Route::get('/warehouse/detail/{code}', 'WareHouseController@getDetail')->name('warehouse.detail');
    Route::post('/warehouse/detail/{id}', 'WareHouseController@updateDetail')->name('warehouse.p_detail');
    Route::get('/warehouse/printdetail/{code}', 'WareHouseController@printDetail')->name('warehouse.print_detail');

    Route::get('/excel/index/', 'WareHouseController@testExcel')->name('excel.index');
});




Route::get('/home', 'HomeController@index')->name('home');
