<?php
Route::group(['prefix' => 'ajax'], function() {
    Route::get('material/{codeCoupon}','AjaxController@getMaterialByImportCoupon');
    Route::get('search/suppliers/{search}','AjaxController@searchSupplier');
    Route::get('getCapitalPrice/{idMaterial}','AjaxController@getCapitalPrice');
    Route::get('getImportCoupon/{dateStart}/{dateEnd}/{idSupplier}','AjaxController@getImportCouponToPaymentVc');
    Route::get('checkNVL/{idDishOrder}','CookScreenController@checkNVL');
    Route::get('getArea/{idTable}','AjaxController@getAreaByIdTable');

    Route::get('getDishInCook/{idCook}','CookScreenController@getDetail');

    Route::group(['prefix' => 'search'], function () {
        Route::get('paymentvoucher/{code}','AjaxController@searchPaymentVoucher');
        Route::get('dish/{name}','AjaxController@searchDish');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('table/{idBill}/{idTable}','AjaxController@getDishOrderTable');
        Route::post('store','OrderController@orderTablePost');
        Route::post('update/{idBill}','OrderController@addMoreDish');
        Route::post('match/{idBill}','OrderController@matchTable');
        Route::post('destroy/{idBill}','OrderController@destroyTable');
    });

    Route::group(['prefix' => 'getMaterial'], function() {
        Route::get('bySupplier/{idSupplier}','AjaxController@getMaterialBySupplier');
        Route::get('byIdPlan/{idPlan}','AjaxController@getMaterialByIdPlan');
        Route::get('byIdType/{idType}/{idGroupNVL}','AjaxController@getMaterialByIdType');
        Route::get('byIdMaterial/{idMaterial}','AjaxController@getMaterialByIdMaterial');
        Route::get('cookemergency/{idCook}','AjaxController@getMaterialByIdCook');

        Route::group(['prefix' => 'export'], function() {
            Route::get('cook/{idObjectCook}','AjaxController@getMaterialToExportCook');
            Route::get('supplier/{idSupplier}','AjaxController@getImportCouponByIdSupplier');
        });

        Route::group(['prefix' => 'destroy'], function() {
            Route::get('warehouse/{arrIdMaterial}','AjaxController@searchMaterialDestroy');
            Route::get('cook/{cook}/{arrIdMaterial}','AjaxController@searchMaterialDestroyCook');

        });
    });

    Route::group(['prefix' => 'report'], function() {
        Route::get('dish/{dateStart}/{dateEnd}/{idGroupmenu}','AjaxController@reportDish');
        Route::get('getDateTime/{id}','AjaxController@getDateTimeToReport');
        Route::get('overview/{dateStart}/{dateEnd}','AjaxController@showOverview');
        Route::get('profit/{dateStart}/{dateEnd}','AjaxController@getProfit');
        Route::get('chartCustomer/{typeTime}','AjaxController@createCustomerChart');
    });
});
?>
