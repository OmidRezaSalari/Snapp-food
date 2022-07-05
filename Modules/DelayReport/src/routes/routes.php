<?php

Route::group(['prefix' => 'v1/orders', 'namespace' => 'V1', 'as' => 'v1.orders.'], function () {

    Route::group(['middleware' => ["auth:api", "validDeliveryTime"], 'prefix' => '/delays', 'as' => 'delays.'], function () {
        Route::post('/reports', "DelayReportController@addReport")
            ->name("add-new-report");
    });
});
