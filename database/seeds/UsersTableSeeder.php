<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'phone' => '18779174645',
                'password' => '$2y$10$NsDewsonIxNdpKgNNefJtuqOVk2aG2MnrFoFXUOsTDoG0cj9aaAtG',
                'name' => '尼采',
                'avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJnicGKFxI7sf9ZTkqcsH7nkrVw7L2WhGgw4GQ7ib1gDxXAuVjfcCAofJodnicErjIt23jjWzEmdNWCA/132',
                'department' => '技术部',
                'type' => 1,
                'face_id' => '',
                'remember_token' => '5cef0d83-40a4-4f4c-8bfa-049f4e70ff62',
                'created_at' => NULL,
                'updated_at' => '2019-08-26 15:56:49',
                'openid' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'phone' => 'admin',
                'password' => '$2y$10$NsDewsonIxNdpKgNNefJtuqOVk2aG2MnrFoFXUOsTDoG0cj9aaAtG',
                'name' => 'admin',
                'avatar' => 'https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJnicGKFxI7sf9ZTkqcsH7nkrVw7L2WhGgw4GQ7ib1gDxXAuVjfcCAofJodnicErjIt23jjWzEmdNWCA/132',
                'department' => '技术部',
                'type' => 1,
                'face_id' => '',
                'remember_token' => '9d2f65be-d68c-42c2-a351-97cdf280d2a5',
                'created_at' => NULL,
                'updated_at' => '2019-08-26 10:54:42',
                'openid' => NULL,
            ),
        ));
        
        
    }
}