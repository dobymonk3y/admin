<?php

Route::group(['middleware' => 'admin'], function () {

    #数据统计
    Route::get('/', 'Admin\IndexController@index');
    Route::get('index', 'Admin\IndexController@index');

    #订单管理相关
    Route::get('/orders', 'Admin\OrderController@index');
    Route::get('/orders/new', 'Admin\OrderController@newOrders');
    Route::get('/orders/wait', 'Admin\OrderController@waitOrders');
    Route::get('/orders/remove', 'Admin\OrderController@removeOrders');
    Route::get('/orders/unpay', 'Admin\OrderController@unpayOrders');
    Route::get('/orders/pay', 'Admin\OrderController@payOrders');
    Route::get('/orders/cancel', 'Admin\OrderController@cancelOrders');
    Route::get('/orders/show/{id}', 'Admin\OrderController@showOrder');


});

#认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');