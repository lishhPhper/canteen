<?php
namespace App\Service;

use App\Models\ServerFood;
use App\Traits\Setting;

class FoodService extends Service
{
    use Setting;
    public static function getFoodList()
    {
        // 获取现在是什么餐时段
        $server_type = self::getServerType();
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

    public static function getIsEat()
    {
//        $server_type = self::getServerType();
        return 1;
    }
}
