<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('token') ? $request->header('token') : $request->input('token');
        if(empty($token)){
            return response()->json(['code' => 1001, 'msg'  => '未登录或已失效', 'data' => []]);
        }
        $user = User::where('remember_token',$token)->first();
        if (!$user){
            return response()->json(['code' => 1001, 'msg'  => '未登录或已失效', 'data' => []]);
        }
        // TODO 手机号判断
        if($user->phone != '18779174645'){
            return response()->json(['code' => 1002, 'msg'  => '权限不足', 'data' => []]);
        }
        $request->user = $user;
        return $next($request);
    }
}
