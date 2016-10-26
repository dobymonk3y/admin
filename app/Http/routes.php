<?php

Route::group(['middleware' => 'admin'], function () {

    Route::get('/test', 'Admin\OrderController@test');//测试'

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
    Route::get('/orders/edit/{id}', 'Admin\OrderController@edit');

    #人事相关
    Route::get('/personnel', 'Admin\PersonnelController@index');
    Route::get('/personnel/onthejob', 'Admin\PersonnelController@onthejob');
    Route::get('/personnel/holiday', 'Admin\PersonnelController@holiday');
    Route::get('/personnel/leaving', 'Admin\PersonnelController@leaving');
    Route::get('/personnel/index', 'Admin\PersonnelController@index');

    #报表 日志
    Route::get('/log/login','Admin\LogController@login');
});

#认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');