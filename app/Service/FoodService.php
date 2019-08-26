<?php
namespace App\Service;

use App\Models\AppointLog;
use App\Models\EatLog;
use App\Models\ServerFood;
use App\Traits\Appoint;
use App\Traits\Setting;
use Illuminate\Support\Facades\DB;

class FoodService extends Service
{
    use Setting,Appoint;
    public function getFoodList()
    {
        // 获取现在是什么餐时段
        $server_type = $this->getServerType();
        $date = date('Y-m-d');
        // 判断午餐还是晚餐
        $server_foods = ServerFood::select('id','food_id','server_time','server_type')
            ->with(['food' => function ($query) {
                $query->select('id','name','img_url');
            }])
            ->where('server_time',$date)
            ->where('server_type',$server_type)
            ->get();
        return $server_foods;
    }

    public function getIsEat($user_id)
    {
        // 获取现在是什么餐时段
        $server_type = $this->getServerType();
        return $this->normalReserved($user_id,$server_type);
    }

    public function toEatSet($user_id)
    {
        $server_type = $this->getServerType();
        $is_eat = $this->normalReserved($user_id,$server_type);
        // 未预约
        if($is_eat == 0){
            return self::resultSet(2001,"未查到预约记录");
        }
        $date = date('Y-m-d');
        // 已点击就餐
        $eat_log = EatLog::where('user_id',$user_id)
            ->where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('status',1)
            ->first();
        if($eat_log['appoint_type'] == 2){
            return self::resultSet(2001,"特殊预约无需点击就餐");
        }
        $reservation_num = $this->getNowReservationNum($server_type);
        if($eat_log['is_click'] > 0){
            return self::resultSet(1,"",[
                'start_time' => $eat_log['start_time'],
                'end_time' => $eat_log['end_time'],
                'appoint_num' => $eat_log['appoint_num'],
                'reservation_num' => $reservation_num,
            ]);
        }
        // 最大预约人，批次
        $keys  = ['max_reservation_num','dining_lot','first_lunch_time','first_night_time','eat_interval'];
        $configs = Setting::getParam($keys);
        // 上一个开餐的人的就餐开始时间
        $start_time = EatLog::where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('appoint_type',1)
            ->where('is_click',1)
            ->where('default',1)
            ->where('status',1)
            ->orderBy('id','desc')
            ->value('start_time');
        $first_start_time = $server_type == 1 ? $configs['first_lunch_time'] : $configs['first_night_time'];
        if(!$start_time){
            $start_time = $first_start_time;
        }
        $section_time = $this->getEatSection($server_type, $configs, $start_time);
        // 前面人数
        $click_num = EatLog::where('appoint_date',$date)
            ->where('eat_type',$server_type)
            ->where('appoint_type',1)
            ->where('is_click',1)
            ->where('default',1)
            ->where('status',1)
            ->count();
        $appoint_num = $click_num + 1;

        try{
            DB::beginTransaction();
            $eat_log->start_time = $section_time['start_time'];
            $eat_log->end_time = $section_time['end_time'];
            $eat_log->appoint_num = $appoint_num;
            $eat_log->is_click = 1;
            $eat_log->default = 1;
            $eat_log->save();

            // 更新预约记录中的开餐时间
            if($eat_log->appoint_type == 1){
                AppointLog::where('id',$eat_log->appoint_id)->update([
                    'start_time' => $section_time['start_time'],
                    'end_time' => $section_time['end_time']
                ]);
            }
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return self::resultSet(2001,"就餐失败");
        }

        return self::resultSet(1,"",[
            'start_time' => $section_time['start_time'],
            'end_time' => $section_time['end_time'],
            'appoint_num' => $appoint_num,
            'reservation_num' => $reservation_num,
        ]);
    }
}
