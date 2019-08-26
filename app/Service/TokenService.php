<?php
namespace App\Service;

class TokenService extends Service
{
    public static function set($token, $user)
    {
        $user->remember_token = $token;
        $user->save();
    }
}
