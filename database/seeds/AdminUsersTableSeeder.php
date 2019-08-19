<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admin_users')->delete();

        \DB::table('admin_users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'username' => 'admin0817',
                    'password' => '$2y$10$AWSycUlc2x37espIAUcJXeQe2zgbUVtqAqIbi/MzaE6PPi7YtN3QK',
                    'name' => 'Administrator',
                    'avatar' => NULL,
                    'remember_token' => 'wUQcuNepmFsHmfhaJCOqNvul6k1wdFOVu5bYqIhCt1lw0Iv4qEWSB8nZXCAt',
                    'created_at' => '2019-01-17 09:30:49',
                    'updated_at' => '2019-01-17 09:30:49',
                ),
        ));
    }
}
