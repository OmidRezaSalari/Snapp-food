<?php

Route::group(['prefix' => 'v1/orders', 'namespace' => 'V1', 'as' => 'v1.orders.'], function () {

    Route::group(['prefix' => '/delays', 'as' => 'delays.'], function () {
        Route::post('/reports', "DelayReportController@addReports")->middleware('isValidDeliveryTime')
            ->name("add-new-report");
    });
});
