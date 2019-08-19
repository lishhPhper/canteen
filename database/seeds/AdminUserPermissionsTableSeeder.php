<?php

use Illuminate\Database\Seeder;

class AdminUserPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_user_permissions')->delete();
    }
}
