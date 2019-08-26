<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 用户列表
    $router->get('user', 'UserController@index');

    // 用户管理
    $router->resource('userInfo', 'UserInfoController');

    // 菜品管理
    $router->resource('food', 'FoodController');

    // 供餐管理
    $router->resource('server','ServerController');

    // 系统设置
    $router->resource('setting','SettingController');

    // 预约管理
    $router->resource('appointment','AppointmentController');

    // 特殊预约管理
    $router->resource('special','SpecialController');
});
