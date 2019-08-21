<?php
namespace App\Traits;

trait Setting
{
    /**
     * 获取当天在哪个用餐时段
     * @return int
     */
    public static function getServerType()
    {
        $Setting = new \App\Models\Setting();
        $dinner_data = $Setting
            ->whereIn('key',[
                'first_lunch_time',
                'first_night_time',
                'eat_interval',
                'dining_lot'
            ])
            ->pluck('value','key');
        $time = date('H:i:s');
        $lot = $dinner_data['dining_lot'] * $dinner_data['eat_interval'] * 60;
        $lunch_end_time = date("H:i:s",strtotime($dinner_data['first_lunch_time']) + $lot);
        $server_type = 2;
        if($time < $lunch_end_time){
            $server_type = 1;
        }
        return $server_type;
    }

    /**
     * 获取预约时间
     * @return mixed
     */
    public static function getReservationTime()
    {
        $Setting = new \App\Models\Setting();
        $reservation_time = $Setting
            ->whereIn('key',[
                'lunch_reservation_start_time',
                'lunch_reservation_end_time',
                'night_reservation_start_time',
                'night_reservation_end_time'
            ])
            ->pluck('value','key');
        return $reservation_time;
    }
}
