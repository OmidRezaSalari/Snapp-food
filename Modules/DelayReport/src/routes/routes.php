<?php

Route::group(["middleware" => ["auth:api"], 'prefix' => 'v1/', 'namespace' => 'V1', 'as' => "v1."], function () {

    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {

        Route::post('delays/reports', "DelayReportController@addDelayReport")
            ->name("add-delay-report")->middleware("validDeliveryTime");

        Route::post('/reviews', "DelayReportController@sendForReview")
            ->name("forReviews")->middleware("isBusyAgent");
    });

    Route::group(["middleware" => ["auth:api"], 'prefix' => 'vendors', 'as' => 'vendors.'], function () {
        Route::get('/', "DelayReportController@vendorsDelayReportCount");
    });
});
