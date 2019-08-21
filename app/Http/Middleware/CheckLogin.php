<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if (!$user){
            return response()->json(['code' => 1001, 'msg'  => '未登录或已失效', 'data' => []]);
        }
        return $next($request);
    }
}
