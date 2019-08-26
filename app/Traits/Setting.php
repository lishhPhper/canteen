<?php
namespace App\Traits;

trait Setting
{
    /**
     * 获取当天在哪个用餐时段
     * @return int
     */
    public function getServerType()
    {
        $Setting = new \App\Models\Setting();
        $dinner_data = $Setting
            ->whereIn('key',[
                'first_lunch_time',
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
     * 获取当天在哪个预约时段
     * @return int
     */
    public function getReservationType()
    {
        $Setting = new \App\Models\Setting();
        $dinner_data = $Setting
            ->whereIn('key',[
                'lunch_reservation_start_time',
                'lunch_reservation_end_time',
                'night_reservation_start_time',
                'night_reservation_end_time'
            ])
            ->pluck('value','key');
        $time = date('H:i:s');
        $reservation_type = 0;
        if($time >= $dinner_data['lunch_reservation_start_time'] && $time <= $dinner_data['lunch_reservation_end_time']){
            $reservation_type = 1;
        }elseif ($time >= $dinner_data['night_reservation_start_time'] && $time <= $dinner_data['night_reservation_end_time']) {
            $reservation_type = 2;
        }
        return $reservation_type;
    }

    /**
     * 获取预约时间
     * @return mixed
     */
    public function getReservationTime()
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

        $reservation_time['lunch_reservation_start_time'] = $this->timeFormat($reservation_time['lunch_reservation_start_time']);
        $reservation_time['lunch_reservation_end_time'] = $this->timeFormat($reservation_time['lunch_reservation_end_time']);
        $reservation_time['night_reservation_start_time'] = $this->timeFormat($reservation_time['night_reservation_start_time']);
        $reservation_time['night_reservation_end_time'] = $this->timeFormat($reservation_time['night_reservation_end_time']);
        return $reservation_time;
    }

    public static function getParam($keys = [])
    {
        $Setting = new \App\Models\Setting();
        $data = $Setting
            ->whereIn('key',$keys)
            ->pluck('value','key');
        return $data;
    }

    public function getReservationSuccess($reservation_type)
    {
        $Setting = new \App\Models\Setting();
        // 午餐
        if($reservation_type == 1){
            $dinner_data = $Setting
                ->whereIn('key',[
                    'first_lunch_time',
                    'eat_interval',
                    'dining_lot',
                    'lunch_reservation_end_time'
                ])
                ->pluck('value','key');
            $lot = $dinner_data['dining_lot'] * $dinner_data['eat_interval'] * 60;
            $lunch_end_time = date("H:i",strtotime($dinner_data['first_lunch_time']) + $lot);
            return [
                'start_eat_time' => substr($dinner_data['first_lunch_time'],0,5),
                'end_eat_time' => $lunch_end_time,
                'cancel_reservation_time' => substr($dinner_data['lunch_reservation_end_time'],0,5),
            ];
        }else{
            $dinner_data = $Setting
                ->whereIn('key',[
                    'first_night_time',
                    'eat_interval',
                    'dining_lot',
                    'night_reservation_end_time'
                ])
                ->pluck('value','key');
            $lot = $dinner_data['dining_lot'] * $dinner_data['eat_interval'] * 60;
            $night_end_time = date("H:i",strtotime($dinner_data['first_night_time']) + $lot);
            return [
                'start_eat_time' => substr($dinner_data['first_night_time'],0,5),
                'end_eat_time' => $night_end_time,
                'cancel_reservation_time' => substr($dinner_data['night_reservation_end_time'],0,5),
            ];
        }
    }
}
