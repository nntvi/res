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
    Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

    // Area & Table
    Route::get('/area/index', 'AreaController@index')->name('area.index');
    Route::post('/area/store', 'AreaController@store')->name('area.p_store');
    Route::post('/area/update/{id}', 'AreaController@update')->name('area.update');
    Route::get('/area/delete/{id}', 'AreaController@delete')->name('area.delete');

    Route::get('/table/index', 'TableController@index')->name('table.index');
    Route::get('/table/store', 'TableController@viewStore')->name('table.store');
    Route::post('/table/store', 'TableController@store')->name('table.p_store');

    Route::get('/table/viewupdate/{id}', 'TableController@viewUpdate')->name('table.update');
    Route::post('/table/update/{id}', 'TableController@update')->name('table.p_update');
    Route::get('/table/delete/{id}', 'TableController@delete')->name('table.delete');

    // Group Menu
    Route::get('/groupmenu/index', 'GroupMenuController@index')->name('groupmenu.index');
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
});




Route::get('/home', 'HomeController@index')->name('home');
