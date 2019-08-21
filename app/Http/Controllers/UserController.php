<?php

namespace App\Http\Controllers;


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
        if (! $token = auth()->login($user['data'])) {
            return $this->failure('登录失败',[],1001);
        }
        // TODO 身份识别  手机号码？？？？
        $token = $this->respondWithToken($token);
        $is_admin = 0;
        return $this->success('登录成功',['user' => $user, 'token' => $token, 'is_admin' => $is_admin]);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return $this->success('已登出');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->success('Token已刷新',[
            'token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function respondWithToken($token)
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function test()
    {
        $user = auth()->user();
        dd($user);
    }
}
