<?php
namespace App\Service;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class SettingService extends Service
{
    public static function settParam($params)
    {
        $all_key_data = Setting::select('id','key','value')
            ->get()->toArray();
        $all_keys = array_column($all_key_data,'key','id');
        if($params['max_reservation_num'] <= 0){
            return self::statusSet(false,'人数需要大于0');
        }
        if($params['lunch_reservation_end_time'] <= $params['lunch_reservation_start_time']){
            return self::statusSet(false,'午餐预约结束时间要大于开始时间');
        }
        if($params['night_reservation_end_time'] <= $params['night_reservation_start_time']){
            return self::statusSet(false,'晚餐预约结束时间要大于开始时间');
        }
        if($params['dining_lot'] <= 0){
            return self::statusSet(false,'就餐批次需要大于0');
        }
        if($params['first_night_time'] <= $params['first_lunch_time']){
            return self::statusSet(false,'晚餐就餐时间要大于午餐就餐时间');
        }
        if($params['eat_interval'] <= 0){
            return self::statusSet(false,'批次间隔时间需要大于0');
        }
        foreach ($params as $key => $value) {
            if(in_array($key,$all_keys)) {
                Setting::where('key',$key)->update(['value' => $value]);
            }
        }
        return self::statusSet(true,'设置成功');
    }
}
