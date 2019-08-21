<?php
namespace App\Service;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public static function checkLoginParam($params)
    {
        if(empty($params['phone']) || empty($params['password'])) {
            return self::resultSet(false, '请输入手机和密码');
        }
        // 已登入
        $user = auth()->user();
        if($user){
            // 如有头像信息 进行完善
            if(!empty($params['avatar'])){
                $user->avatar = $params['avatar'];
                $user->save();
            }
            return self::resultSet(true, '已登录',$user);
        }

        $user = User::where('phone',$params['phone'])
            ->first();

        if(!$user) return self::resultSet(false, '未录入');

        if (!Hash::check($params['password'], $user->password)) {
            return self::resultSet(false, '密码错误');
        };
        if(!empty($params['avatar'])){
            $user->avatar = $params['avatar'];
            $user->save();
        }
        return self::resultSet(true, '登录成功',$user);
    }
}
