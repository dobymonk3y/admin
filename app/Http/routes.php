<?php

Route::group(['middleware' => ['admin','EnableCross']], function () {

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
    Route::get('/orders/follow', 'Admin\OrderController@followOrder');
    Route::get('/orders/assign', 'Admin\OrderController@assignOrder');
    Route::get('/orders/drivers', 'Admin\OrderController@drivers');
    Route::get('/orders/drivers/search', 'Admin\OrderController@driversearch');
    Route::get('/orders/designate', 'Admin\OrderController@dodesignate');
    Route::get('/orders/search', 'Admin\OrderController@search');
    Route::get('/orders/myfollow','Admin\OrderController@myfollow');
    Route::get('/orders/unfollow','Admin\OrderController@unfollow');
    Route::post('/orders/update/{id}', 'Admin\OrderController@update');
    Route::get('/orders/cancelorder/{id}', 'Admin\OrderController@cancel');

    #人事相关
    Route::get('/personnel', 'Admin\PersonnelController@index');
    Route::get('/personnel/onthejob', 'Admin\PersonnelController@onthejob');
    Route::get('/personnel/holiday', 'Admin\PersonnelController@holiday');
    Route::get('/personnel/leaving', 'Admin\PersonnelController@leaving');
    Route::get('/personnel/index', 'Admin\PersonnelController@index');
    Route::get('/personnel/add', 'Admin\PersonnelController@addNew');
    Route::post('/personnel/save', 'Admin\PersonnelController@saveNew');

    #报表 日志
    Route::get('/log/login','Admin\LogController@login');
    Route::get('/log/logincheck','Admin\LogController@logincheck');
    Route::get('/log/mylogin','Admin\LogController@mylogin');
    Route::get('/log/process','Admin\LogController@process');
    Route::get('/log/processcheck','Admin\LogController@processcheck');
    Route::get('/log/assign',['as'=>'assinglog','uses'=>'Admin\LogController@assignlog']);

    #客服提交跟进记录
    Route::get('/customerrecord/store','Admin\CustomerRecordController@store');

    #个人资料
    Route::get('/user/profiles','Admin\UserController@index');
    Route::post('/user/update','Admin\UserController@update');
    Route::get('/user/password','Admin\UserController@password');
    Route::post('/user/changepwd','Admin\UserController@change');
});

#认证路由...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('event',function(){
    Event::fire(new \App\Events\SomeEvent(14));
    return "Hello world!";
});