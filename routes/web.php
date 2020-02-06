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

Route::get('/', function () {
    return view('layouts');
});

Route::get('/permission', 'PermissionController@index');

Route::get('/view-add-permission', 'PermissionController@viewstore');

Route::post('/add-permission', 'PermissionController@store');

Route::get('/edit-permission/{id}','PermissionController@getEdit');

Route::post('/edit-post-permission/{id}','PermissionController@postEdit');

Route::get('/delete-permission/{id}','PermissionController@delete');
