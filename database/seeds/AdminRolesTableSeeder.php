<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_roles')->delete();
        
        \DB::table('admin_roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrator',
                'slug' => 'administrator',
                'created_at' => '2019-08-17 18:00:09',
                'updated_at' => '2019-08-17 18:00:09',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '功能',
                'slug' => '功能权限',
                'created_at' => '2019-08-17 18:17:18',
                'updated_at' => '2019-08-17 18:17:18',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '测试',
                'slug' => '测试权限',
                'created_at' => '2019-08-27 10:49:58',
                'updated_at' => '2019-08-27 10:49:58',
            ),
        ));
        
        
    }
}