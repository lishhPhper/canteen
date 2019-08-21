<?php
namespace App\Service;

use App\Traits\Setting;

class AppointService extends Service
{
    use Setting;
    public static function getReservationInfo()
    {
        $reservation_time = Setting::getReservationTime();
        dd($reservation_time);
    }

    public function confirm($type)
    {
        if(!in_array($type,[1,2])){
            return self::statusSet(false,'请选择预约类型');
        }

    }
}
