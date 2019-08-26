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
//        // 刷新token
//        $router->get('refresh', 'UserController@refresh');
    });

    // 登录接口
    $router->group([
        'middleware' => 'checkLogin'
    ],function ($router){

        // 就餐相关
        $router->prefix('eat')->group(function ($router){
            // 今天供餐食物
            $router->get('serverFood', 'FoodController@serverFood');
            // 开餐排队
            $router->get('toEat', 'FoodController@toEat');
            // 就餐记录
            $router->get('dinnerLog', 'EatController@dinnerLog');
            // 就餐评价
            $router->post('setEvaluation', 'EatController@setEvaluation');
            // 我的评价
            $router->get('evaluationLog', 'EatController@evaluationLog');
        });

        // 预约
        $router->prefix('appoint')->group(function ($router){
            $router->get('index', 'AppointController@index');
            // 确认预约
            $router->post('confirm', 'AppointController@confirm');
            // 特殊预约
            $router->get('special', 'AppointController@special');
            // 特殊预约提审
            $router->post('arraignment', 'AppointController@arraignment');
            // 我的预约
            $router->get('myReservation', 'AppointController@myReservation');
            // 预约详情
            $router->get('reservationDetail', 'AppointController@reservationDetail');
            // 取消预约
            $router->get('cancel', 'AppointController@cancel');
            // 重新预约
            $router->get('refresh', 'AppointController@refresh');
        });

        // 管理员
        $router->group([
            'middleware' => 'isAdmin',
        ],function ($router){
            // 就餐相关
            $router->prefix('eat')->group(function ($router){
                // 评价列表
                $router->get('adminEvaluationLog', 'EatController@adminEvaluationLog');
            });

            // 预约相关
            $router->prefix('appoint')->group(function ($router){
                // 审核列表
                $router->get('verifyList', 'AppointController@verifyList');
                // 审核通过/拒绝
                $router->post('setVerify', 'AppointController@setVerify');
                // 审核结果列表
                $router->get('verifyResult', 'AppointController@verifyResult');
                // 普通预约统计
                $router->get('normalTotal', 'AppointController@normalTotal');
            });
        });
    });
});
