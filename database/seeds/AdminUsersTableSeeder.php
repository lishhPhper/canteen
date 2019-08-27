<?php

use Illuminate\Database\Seeder;

class AdminUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
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
                'username' => 'admin',
                'password' => '$2y$10$NsDewsonIxNdpKgNNefJtuqOVk2aG2MnrFoFXUOsTDoG0cj9aaAtG',
                'name' => 'Administrator',
                'avatar' => NULL,
                'remember_token' => 'JL2NRPJbhGITe4VweOZU47D3uUkqmpYLTUNXWQTSXGue4g9bLK7njzMEdcKd',
                'created_at' => '2019-08-17 18:00:09',
                'updated_at' => '2019-08-17 18:00:09',
            ),
            1 => 
            array (
                'id' => 2,
                'username' => 'test',
                'password' => '$2y$10$CAMCq5iExDaRdAIATokcd.AsaRQulGpFnIkxx29ro5/eZo/4q4ZIa',
                'name' => '测试',
                'avatar' => 'images/鱼香肉丝.jpg',
                'remember_token' => 'bLW5mLhdTZY6SF8w2bW0Le6GXHObJkT6xMYsn6pf0WtouhxtGTm7GM9UtI1U',
                'created_at' => '2019-08-27 10:50:35',
                'updated_at' => '2019-08-27 10:50:35',
            ),
        ));
        
        
    }
}