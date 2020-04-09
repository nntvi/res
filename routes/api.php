<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Get Material By IdSupplier
Route::get('getMaterialBySupplier/{idSupplier}','AjaxController@getMaterialBySupplier');

// Get Object to Export
Route::get('getOjbectToExport/{id}','AjaxController@getObjectToExport');

// Get Material to Export Cook
Route::get('getMaterialToExportCook/{idObjectCook}','AjaxController@getMaterialToExportCook');
Route::get('getMaterialToExportSupplier/{idObjectSupplier}','AjaxController@getMaterialToExportSupplier');

// Get Material In Warehouse Cook By IdCook
Route::get('getMaterialWarehouse/{$idCook}','AjaxController@getMaterialWarehouse');

// Get Matrial In Warehouse By IdType to Destroy
Route::get('getMaterialWarehouseToDestroy/{$idType}','AjaxController@getMaterialWarehouseToDestroy');

Route::get('getObjectToReport/{idType}','AjaxController@getObjectToReport');

Route::get('getDateTimeToReport/{id}','AjaxController@getDateTimeToReport');

// Route::get('loadReport/{dateStart}/{dateEnd}','AjaxController@loadReport');

Route::get('searchMaterialDestroy/{name}','AjaxController@searchMaterialDestroy');
Route::get('searchMaterialDestroyCook/{id}/{name}','AjaxController@searchMaterialDestroyCook');




//Route::get('searchMaterialDetail/{name}','AjaxController@getSearchMaterialDetail');


