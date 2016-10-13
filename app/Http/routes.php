<?php

Route::group(['middleware' => 'admin'], function () {
    #数据统计
    Route::get('/', 'Admin\IndexController@index');
    Route::get('index', 'Admin\IndexController@index');
    #订单管理相关
    Route::get('/orders', 'Admin\OrderController@index');
    Route::get('/orders/index', 'Admin\OrderController@index');
    Route::get('/orders/new', 'Admin\OrderController@newOrders');
});

#认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');