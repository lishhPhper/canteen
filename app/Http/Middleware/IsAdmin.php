<?php

namespace App\Http\Middleware;

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
        $user = auth()->user();
        // TODO 手机号判断
        if($user->phone != 'li'){
            return response()->json(['code' => 1002, 'msg'  => '权限不足', 'data' => []]);
        }
        return $next($request);
    }
}
