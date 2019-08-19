<?php

use Illuminate\Database\Seeder;

class AdminRoleMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_role_menu')->delete();

        \DB::table('admin_role_menu')->insert(array (
            0 =>
                array (
                    'role_id' => 1,
                    'menu_id' => 2,
                    'created_at' => '2019-01-17 10:24:39',
                    'updated_at' => '2019-01-17 10:24:39',
                )
        ));
    }
}
