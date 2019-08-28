<?php

namespace App\Http\Controllers;


use App\Service\TokenService;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $params = $request->all();
        $user = UserService::checkLoginParam($params);
        if(!$user['result']){
            return $this->failure($user['msg'],[],1001);
        }
        $token = $this->uuid();
        TokenService::set($token, $user['data']);

        $is_admin = $user['data']['type'] == 3 ? 1 : 0;

        return $this->success('登录成功',['user' => $user['data'], 'token' => $token, 'is_admin' => $is_admin]);
    }


//    /**
//     * Log the user out (Invalidate the token).
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function logout()
//    {
//        auth()->logout();
//        return $this->success('已登出');
//    }
//
//    /**
//     * Refresh a token.
//     *
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function refresh()
//    {
//        return $this->success('Token已刷新',[
//            'token' => auth()->refresh(),
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
//        ]);
//    }
//
//    public function respondWithToken($token)
//    {
//        return [
//            'token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => auth()->factory()->getTTL() * 60
//        ];
//    }
//
//    public function test()
//    {
//        $user = auth()->user();
//        dd($user);
//    }
}
