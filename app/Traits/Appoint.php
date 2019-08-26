<?php
namespace App\Traits;

use App\Models\AppointLog;
use App\Models\EatLog;

trait Appoint
{
    /**
     * 获取明天已预约人数
     * @param $server_type
     * @return mixed
     */
    public function getReservationNum($server_type)
    {
        $date = date('Y-m-d',strtotime("+1 day"));
        return AppointLog::where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->count();
    }

    /**
     * 获取当天已预约人数
     * @param $server_type
     * @return mixed
     */
    public function getNowReservationNum($server_type)
    {
        $date = date('Y-m-d');
        return AppointLog::where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->count();
    }

    /**
     * 获取用户违约次数
     * @param $user_id
     * @return mixed
     */
    public function getDefaultNum($user_id)
    {
        $date = date('Y-m-d');
        $month_start = date("Y-m-01", time());
        $month_end =  date('Y-m-t', time());
        $ahead_num =  EatLog::where('user_id',$user_id)
            ->whereBetween('appoint_date', [$month_start, $month_end])
            ->where('appoint_date','<',$date)
            ->where('default',1)
            ->where('status',1)
            ->where(function ($query) {
                $query->where(function ($que){
                    $que->where('appoint_type', 1)
                        ->where(function ($q) {
                            $q->where('is_face', 0)
                                ->orWhere('is_click', 0);
                        });
                    })
                    ->orWhere(function ($query){
                        $query->where('appoint_type',2)
                            ->where('is_face',0);
                    });
            })
            ->count();
        // 今天有没有比现在时间早的违约记录
        $now_num =  EatLog::where('user_id',$user_id)
            ->where('appoint_date',$date)
            ->where('default',1)
            ->where('status',1)
            ->where(function ($query) {
                $query->where(function ($que){
                    $que->where('appoint_type', 1)
                        ->where(function ($q) {
                            $q->where('is_face', 0)
                                ->orWhere('is_click', 0);
                        });
                })
                    ->orWhere(function ($query){
                        $query->where('appoint_type',2)
                            ->where('is_face',0);
                    });
            })
            ->count();
        return $ahead_num + $now_num;
    }

    /**
     * 获取用户是否预约明天用餐(包含特殊预约)
     * @param $user_id
     * @param $type
     * @return mixed
     */
    public function reserved($user_id, $reservation_type)
    {
        $date = date('Y-m-d',strtotime("+1 day"));
        return AppointLog::where('user_id',$user_id)
            ->where('appoint_date',$date)
            ->where('eat_type',$reservation_type)
            ->where('status',1)
            ->where(function ($query){
                $query->where('appoint_type',1)
                    ->whereOr(function ($query){
                        $query->where('appoint_type',2)
                            ->where('verify_status',1);
                    });
            })
            ->count();
    }

    /**
     * 获取用户是否预约当天用餐
     * @param $user_id
     * @param $reservation_type
     * @return mixed
     */
    public function normalReserved($user_id, $reservation_type)
    {
        $date = date('Y-m-d');
        return AppointLog::where('user_id',$user_id)
            ->where('appoint_date',$date)
            ->where('eat_type',$reservation_type)
            ->where('appoint_type',1)
            ->where('status',1)
            ->count();
    }

    public function getEatSection($server_type,$configs,$start_time)
    {
        $date = date('Y-m-d');
        // 开始区间的人数
        $start_num = EatLog::where('start_time',$start_time)
            ->where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('appoint_type',1)
            ->where('default',1)
            ->where('status',1)
            ->count();
        $batch_num = $configs['max_reservation_num'] / $configs['dining_lot'];
        // 区间不够
        if($start_num >= $batch_num){
            // 下一个区间
            $start_time = date("H:i:s",strtotime($start_time) + $configs['eat_interval'] * 60);
            $end_time = date("H:i:s",strtotime($start_time) + $configs['eat_interval'] * 2 * 60);
        }else{
            $end_time = date("H:i:s",strtotime($start_time) + $configs['eat_interval'] * 60);
        }
        $region_time = $this->getRegionTime($server_type, $configs, $start_time, $end_time);
        return $region_time;
    }

    public function getRegionTime($server_type, $configs, $start_time, $end_time)
    {
        $time = date('H:i:s');
        // 现在时间和开始时间对比
        if($time < $start_time){
            return ['start_time' => $start_time, 'end_time' => $end_time];
        }
        // 如超过开始时间，找最近
        $lot = $configs['dining_lot'] * $configs['eat_interval'] * 60;
        if($server_type == 1){
            $last_start_time = date("H:i:s",strtotime($configs['first_lunch_time']) + $lot);
        }else{
            $last_start_time = date("H:i:s",strtotime($configs['first_night_time']) + $lot);
        }
        for ($i = $start_time; $i < $last_start_time; $i = date("H:i:s",strtotime($i) + $configs['eat_interval'] * 60)){
            $new_end_time = date("H:i:s",strtotime($i) + $configs['eat_interval'] * 60);
            if($i >= $start_time){
                if($time >= $i && $new_end_time > $i){
                    $start_time = $i;
                    $end_time = $new_end_time;
                }
            }
        }
        return ['start_time' => $start_time, 'end_time' => $end_time];
    }
}
