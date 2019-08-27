<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => '仪表盘',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 2,
                'title' => '系统管理',
                'icon' => 'fa-tasks',
                'uri' => NULL,
                'permission' => 'auth.management',
                'created_at' => NULL,
                'updated_at' => '2019-08-27 10:55:24',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 3,
                'title' => '管理员管理',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 4,
                'title' => '角色管理',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 5,
                'title' => '权限管理',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 6,
                'title' => '菜单管理',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 7,
                'title' => '操作日志',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 0,
                'title' => '功能',
                'icon' => 'fa-bars',
                'uri' => NULL,
                'permission' => 'user',
                'created_at' => '2019-08-17 18:17:54',
                'updated_at' => '2019-08-27 10:56:48',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 0,
                'title' => '管理',
                'icon' => 'fa-bars',
                'uri' => NULL,
                'permission' => NULL,
                'created_at' => '2019-08-17 18:18:03',
                'updated_at' => '2019-08-17 18:18:03',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 8,
                'order' => 0,
                'title' => '用户列表',
                'icon' => 'fa-user',
                'uri' => 'user',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:18:21',
                'updated_at' => '2019-08-17 18:18:21',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 8,
                'order' => 0,
                'title' => '预约管理',
                'icon' => 'fa-clock-o',
                'uri' => 'appointment',
                'permission' => 'appointment',
                'created_at' => '2019-08-17 18:18:48',
                'updated_at' => '2019-08-27 10:56:57',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 8,
                'order' => 0,
                'title' => '评价管理',
                'icon' => 'fa-bell-o',
                'uri' => 'evaluation',
                'permission' => 'evaluation',
                'created_at' => '2019-08-17 18:19:14',
                'updated_at' => '2019-08-27 10:57:06',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 8,
                'order' => 0,
                'title' => '特殊预约管理',
                'icon' => 'fa-bell',
                'uri' => 'special',
                'permission' => 'special',
                'created_at' => '2019-08-17 18:20:26',
                'updated_at' => '2019-08-27 10:57:15',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 8,
                'order' => 0,
                'title' => '菜品管理',
                'icon' => 'fa-bars',
                'uri' => 'food',
                'permission' => 'food',
                'created_at' => '2019-08-17 18:20:55',
                'updated_at' => '2019-08-27 10:57:24',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 8,
                'order' => 0,
                'title' => '供餐管理',
                'icon' => 'fa-bars',
                'uri' => 'server',
                'permission' => 'server',
                'created_at' => '2019-08-17 18:21:29',
                'updated_at' => '2019-08-27 10:57:32',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 8,
                'order' => 0,
                'title' => '违约管理',
                'icon' => 'fa-bars',
                'uri' => 'default',
                'permission' => 'default',
                'created_at' => '2019-08-17 18:22:06',
                'updated_at' => '2019-08-27 10:57:41',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 9,
                'order' => 0,
                'title' => '用户管理',
                'icon' => 'fa-bars',
                'uri' => 'userInfo',
                'permission' => 'userInfo',
                'created_at' => '2019-08-17 18:22:21',
                'updated_at' => '2019-08-27 10:57:48',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 9,
                'order' => 0,
                'title' => '系统设置',
                'icon' => 'fa-gear',
                'uri' => 'setting/create',
                'permission' => 'auth.setting',
                'created_at' => '2019-08-17 18:23:16',
                'updated_at' => '2019-08-27 10:57:59',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 0,
                'order' => 8,
                'title' => '异常记录',
                'icon' => 'fa-bug',
                'uri' => 'exceptions',
                'permission' => 'ext.reporter',
                'created_at' => '2019-08-20 15:20:39',
                'updated_at' => '2019-08-27 10:55:39',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 0,
                'order' => 9,
                'title' => 'ENV参数设置',
                'icon' => 'fa-gears',
                'uri' => 'env-manager',
                'permission' => 'env-manager',
                'created_at' => '2019-08-20 15:22:46',
                'updated_at' => '2019-08-27 10:56:27',
            ),
        ));
        
        
    }
}