<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('login', 'UserController@weappLogin');

Route::group([

    'middleware' => 'api',

], function ($router) {

    $router->group(['prefix' => 'auth'],function ($router){
        // 登录接口
        $router->post('login', 'UserController@login');
        // 刷新token
        $router->get('refresh', 'UserController@refresh');
    });

    // 登录接口
    $router->group([
        'middleware' => 'checkLogin'
    ],function ($router){

        // 供餐查询
        $router->get('serverFood', 'FoodController@serverFood');

        // 预约
        $router->prefix('appoint')->group(function ($router){
            $router->get('index', 'AppointController@index');
            // 确认预约
            $router->post('confirm', 'AppointController@confirm');

        });
        // 管理员
        $router->group([
            'middleware' => 'isAdmin'
        ],function ($router){

            $router->get('test', 'UserController@test');

        });
    });
});
