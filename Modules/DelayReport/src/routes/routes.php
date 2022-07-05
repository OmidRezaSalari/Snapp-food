<?php

Route::group(["middleware" => ["auth:api"], 'prefix' => 'v1/orders', 'namespace' => 'V1', 'as' => 'v1.orders.'], function () {

    Route::group(['middleware' => ["validDeliveryTime"], 'prefix' => '/delays', 'as' => 'delays.'], function () {
        Route::post('/reports', "DelayReportController@addReport")
            ->name("add-new-report");
    });

    Route::post('/reviews', "DelayReportController@sendForReview")->middleware("isBusyAgent")
        ->name("forReviews");
});
