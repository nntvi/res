<?php
Route::group(['prefix' => 'ajax'], function() {
    Route::get('material/{codeCoupon}','AjaxController@getMaterialByImportCoupon');
    Route::get('search/suppliers/{search}','AjaxController@searchSupplier');
    Route::get('getCapitalPrice/{idMaterial}','AjaxController@getCapitalPrice');
    Route::get('getImportCoupon/{idSupplier}','AjaxController@getUnPaidImport');

    Route::group(['prefix' => 'order'], function () {
        Route::get('table/{idTable}','AjaxController@getDishOrderTable');
        Route::post('store','OrderController@orderTablePost');
        Route::post('update/{idBill}','OrderController@addMoreDish');
    });

    Route::group(['prefix' => 'getMaterial'], function() {
        Route::get('bySupplier/{idSupplier}','AjaxController@getMaterialBySupplier');
        Route::group(['prefix' => 'export'], function() {
            Route::get('cook/{idObjectCook}','AjaxController@getMaterialToExportCook');
            Route::get('supplier/{idSupplier}','AjaxController@getImportCouponByIdSupplier');
        });
        Route::group(['prefix' => 'destroy'], function() {
            Route::get('warehouse/{name}','AjaxController@searchMaterialDestroy');
            Route::get('cook/{id}/{name}','AjaxController@searchMaterialDestroyCook');

        });
    });

    Route::group(['prefix' => 'report'], function() {
        Route::get('getDateTime/{id}','AjaxController@getDateTimeToReport');
        Route::get('overview/{dateStart}/{dateEnd}','AjaxController@showOverview');
        Route::get('bestseller/{timeStart}/{timeEnd}','AjaxController@getDataChartBestSeller');
    });
});
?>
