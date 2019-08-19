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
                'uri' => '',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
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
                'permission' => NULL,
                'created_at' => '2019-08-17 18:17:54',
                'updated_at' => '2019-08-17 18:17:54',
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
                'permission' => NULL,
                'created_at' => '2019-08-17 18:18:48',
                'updated_at' => '2019-08-17 18:18:48',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 8,
                'order' => 0,
                'title' => '评价管理',
                'icon' => 'fa-bell-o',
                'uri' => 'evaluation',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:19:14',
                'updated_at' => '2019-08-17 18:19:14',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 8,
                'order' => 0,
                'title' => '特殊预约管理',
                'icon' => 'fa-bell',
                'uri' => 'special',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:20:26',
                'updated_at' => '2019-08-17 18:20:26',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 8,
                'order' => 0,
                'title' => '菜品管理',
                'icon' => 'fa-bars',
                'uri' => 'food',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:20:55',
                'updated_at' => '2019-08-17 18:20:55',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 8,
                'order' => 0,
                'title' => '供餐管理',
                'icon' => 'fa-bars',
                'uri' => 'server',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:21:29',
                'updated_at' => '2019-08-17 18:21:29',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 8,
                'order' => 0,
                'title' => '违约管理',
                'icon' => 'fa-bars',
                'uri' => 'default',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:22:06',
                'updated_at' => '2019-08-17 18:22:06',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 9,
                'order' => 0,
                'title' => '用户管理',
                'icon' => 'fa-bars',
                'uri' => 'userInfo',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:22:21',
                'updated_at' => '2019-08-17 18:22:21',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 9,
                'order' => 0,
                'title' => '系统设置',
                'icon' => 'fa-gear',
                'uri' => 'setting',
                'permission' => NULL,
                'created_at' => '2019-08-17 18:23:16',
                'updated_at' => '2019-08-17 18:23:16',
            ),
        ));
        
        
    }
}