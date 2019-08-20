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
        foreach ($params as $key => $value) {
            if(in_array($key,$all_keys)) {
                Setting::where('key',$key)->update(['value' => $value]);
            }
        }
        return self::statusSet(true,'设置成功');
    }
}
