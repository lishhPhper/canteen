<?php

use Illuminate\Database\Seeder;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                    'name' => '系统管理员',
                    'slug' => 'Administrator',
                    'created_at' => '2019-01-17 09:30:49',
                    'updated_at' => '2019-01-17 10:03:38',
                )
        ));
    }
}
