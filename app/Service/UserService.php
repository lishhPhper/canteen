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
        if(empty($params['code'])){
            return self::resultSet(false, '未获取到code');
        }
        $miniProgram = \EasyWeChat::miniProgram(); // 小程序
        $session_data = $miniProgram->auth->session($params['code']);
        $openid = !empty($session_data['openid']) ? $session_data['openid'] : '';

        $user = User::where('phone',$params['phone'])
            ->first();

        if(!$user) return self::resultSet(false, '用户信息不存在');

        if (!Hash::check($params['password'], $user->password)) {
            return self::resultSet(false, '密码错误');
        };
        if(empty($user->avatar) && !empty($params['avatarUrl'])){
            $user->avatar = $params['avatarUrl'];
        }
        if(empty($user->openid) && !empty($openid)){
            $user->openid = $openid;
        }
        $user->save();
        return self::resultSet(true, '登录成功',$user);
    }
}
