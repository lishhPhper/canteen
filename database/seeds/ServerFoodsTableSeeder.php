<?php

use Illuminate\Database\Seeder;

class ServerFoodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('server_foods')->delete();
        
        \DB::table('server_foods')->insert(array (
            0 => 
            array (
                'id' => 2,
                'server_time' => '2019-08-02',
                'food_id' => 3,
                'food_num' => 2,
                'server_type' => 1,
                'created_at' => '2019-08-19 16:23:41',
                'updated_at' => '2019-08-19 16:23:41',
            ),
            1 => 
            array (
                'id' => 6,
                'server_time' => '2019-08-14',
                'food_id' => 4,
                'food_num' => 22,
                'server_type' => 1,
                'created_at' => '2019-08-19 17:01:45',
                'updated_at' => '2019-08-19 17:01:45',
            ),
            2 => 
            array (
                'id' => 11,
                'server_time' => '2019-08-21',
                'food_id' => 3,
                'food_num' => 22,
                'server_type' => 1,
                'created_at' => '2019-08-20 10:50:46',
                'updated_at' => '2019-08-20 10:50:46',
            ),
            3 => 
            array (
                'id' => 14,
                'server_time' => '2019-08-21',
                'food_id' => 4,
                'food_num' => 22,
                'server_type' => 1,
                'created_at' => '2019-08-20 10:58:15',
                'updated_at' => '2019-08-20 10:58:15',
            ),
        ));
        
        
    }
}