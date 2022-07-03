<?php

Route::group(['prefix' => 'v1/users', 'namespace' => 'V1', 'as' => 'v1.users.'], function () {

    Route::group(['as' => 'register.'], function () {
        Route::post('/register', "RegisterController@register")->name('new-user');
    });

    Route::group(['prefix' => 'login', 'as' => 'login.'], function () {
        Route::post('/', "LoginController@login")->name('success');


    });


});