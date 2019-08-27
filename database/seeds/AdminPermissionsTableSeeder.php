<?php

use Illuminate\Database\Seeder;

class AdminPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_permissions')->delete();
        
        \DB::table('admin_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '所有权限',
                'slug' => '*',
                'http_method' => '',
                'http_path' => '*',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:42:58',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '仪表盘',
                'slug' => 'dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:43:11',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '登录',
                'slug' => 'auth.login',
                'http_method' => '',
                'http_path' => '/auth/login
/auth/logout',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:43:19',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '系统设置',
                'slug' => 'auth.setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:43:28',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '系统管理',
                'slug' => 'auth.management',
                'http_method' => '',
                'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:44:33',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '异常处理',
                'slug' => 'ext.reporter',
                'http_method' => '',
                'http_path' => '/exceptions*',
                'created_at' => '2019-08-20 15:20:39',
                'updated_at' => '2019-08-27 10:44:46',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '用户列表',
                'slug' => 'user',
                'http_method' => '',
                'http_path' => '/user',
                'created_at' => '2019-08-27 10:46:02',
                'updated_at' => '2019-08-27 10:46:02',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '用户管理',
                'slug' => 'userInfo',
                'http_method' => '',
                'http_path' => '/userInfo',
                'created_at' => '2019-08-27 10:52:09',
                'updated_at' => '2019-08-27 10:52:09',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '菜品管理',
                'slug' => 'food',
                'http_method' => '',
                'http_path' => '/food',
                'created_at' => '2019-08-27 10:52:40',
                'updated_at' => '2019-08-27 10:52:40',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '供餐管理',
                'slug' => 'server',
                'http_method' => '',
                'http_path' => '/server',
                'created_at' => '2019-08-27 10:52:53',
                'updated_at' => '2019-08-27 10:52:53',
            ),
            10 => 
            array (
                'id' => 12,
                'name' => '预约管理',
                'slug' => 'appointment',
                'http_method' => '',
                'http_path' => '/appointment',
                'created_at' => '2019-08-27 10:53:38',
                'updated_at' => '2019-08-27 10:53:38',
            ),
            11 => 
            array (
                'id' => 13,
                'name' => '特殊预约管理',
                'slug' => 'special',
                'http_method' => '',
                'http_path' => '/special',
                'created_at' => '2019-08-27 10:53:57',
                'updated_at' => '2019-08-27 10:53:57',
            ),
            12 => 
            array (
                'id' => 14,
                'name' => '违约管理',
                'slug' => 'default',
                'http_method' => '',
                'http_path' => '/default',
                'created_at' => '2019-08-27 10:54:10',
                'updated_at' => '2019-08-27 10:54:10',
            ),
            13 => 
            array (
                'id' => 15,
                'name' => '评价管理',
                'slug' => 'evaluation',
                'http_method' => '',
                'http_path' => '/evaluation',
                'created_at' => '2019-08-27 10:54:25',
                'updated_at' => '2019-08-27 10:54:25',
            ),
            14 => 
            array (
                'id' => 16,
                'name' => 'ENV参数设置',
                'slug' => 'env-manager',
                'http_method' => '',
                'http_path' => '/env-manager',
                'created_at' => '2019-08-27 10:56:13',
                'updated_at' => '2019-08-27 10:56:13',
            ),
        ));
        
        
    }
}