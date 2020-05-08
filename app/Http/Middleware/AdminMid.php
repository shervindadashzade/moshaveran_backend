<?php

namespace App\Http\Middleware;

use Illuminate\Support\Str;

use Closure;
use App\Admin;
class AdminMid
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
        if(Str::length($request->api_token) != 60){
            return response()->json([
                'message' => 'access forbiden'
            ],403);
        }
        $admin = Admin::where(['api_token'=>$request->api_token])->first();

        if($admin == null){
            return response()->json([
                //TODO:: find right message and code
                'message' => 'access forbiden'
            ],403);
        }else{
            $request->user = $admin;
            return $next($request);
        }
    }
}
