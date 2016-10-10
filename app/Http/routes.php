<?php

Route::group(['middleware' => 'admin'], function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::get('index', 'Admin\IndexController@index');
});

// 认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');