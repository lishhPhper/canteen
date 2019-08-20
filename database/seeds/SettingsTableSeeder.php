<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '平台预约最大人数',
                'form_type' => 'number',
                'key' => 'max_reservation_num',
                'value' => '160',
                'created_at' => '2019-08-20 14:36:31',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '午餐预约开启时间',
                'form_type' => 'time',
                'key' => 'lunch_reservation_start_time',
                'value' => '10:00:00',
                'created_at' => '2019-08-20 14:36:34',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => '晚餐预约开启时间',
                'form_type' => 'time',
                'key' => 'night_reservation_start_time',
                'value' => '16:00:00',
                'created_at' => '2019-08-20 14:36:36',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => '就餐时间批次',
                'form_type' => 'number',
                'key' => 'dining_lot',
                'value' => '4',
                'created_at' => '2019-08-20 14:36:38',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => '午餐首批用餐时间',
                'form_type' => 'time',
                'key' => 'first_lunch_time',
                'value' => '11:30:00',
                'created_at' => '2019-08-20 14:36:41',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => '晚餐首批用餐时间',
                'form_type' => 'time',
                'key' => 'first_night_time',
                'value' => '16:30:00',
                'created_at' => '2019-08-20 14:36:45',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => '批次间隔时间',
                'form_type' => 'number',
                'key' => 'eat_interval',
                'value' => '30',
                'created_at' => '2019-08-20 14:36:48',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => '特殊就餐自动审核',
                'form_type' => 'radio',
                'key' => 'special_eat',
                'value' => '0',
                'created_at' => '2019-08-20 14:36:50',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => '午餐预约结束时间',
                'form_type' => 'time',
                'key' => 'lunch_reservation_end_time',
                'value' => '13:00:00',
                'created_at' => '2019-08-20 14:36:52',
                'updated_at' => '2019-08-20 14:36:04',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => '晚餐预约结束时间',
                'form_type' => 'time',
                'key' => 'night_reservation_end_time',
                'value' => '18:00:00',
                'created_at' => '2019-08-20 14:36:55',
                'updated_at' => '2019-08-20 14:36:04',
            ),
        ));
        
        
    }
}