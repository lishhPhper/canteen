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
                    'updated_at' => '2019-01-17 09:53:43',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => '仪表盘访问权限',
                    'slug' => 'dashboard',
                    'http_method' => 'GET',
                    'http_path' => '/',
                    'created_at' => NULL,
                    'updated_at' => '2019-01-17 09:54:48',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => '登录登出权限',
                    'slug' => 'auth.login',
                    'http_method' => '',
                    'http_path' => '/auth/login
/auth/logout',
                    'created_at' => NULL,
                    'updated_at' => '2019-01-17 09:54:18',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => '用户设置权限',
                    'slug' => 'auth.setting',
                    'http_method' => 'GET,PUT',
                    'http_path' => '/auth/setting',
                    'created_at' => NULL,
                    'updated_at' => '2019-01-17 09:54:35',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => '角色权限管理',
                    'slug' => 'auth.management',
                    'http_method' => '',
                    'http_path' => '/auth/roles
/auth/permissions
/auth/menu
/auth/logs',
                    'created_at' => NULL,
                    'updated_at' => '2019-01-17 09:55:02',
                )
        ));


    }
}
