<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Auth;
use App\Models\LoginReport;

class AdminMiddleware
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
        if(!Auth::check()){
            Session::flash('unlogin','您还没有登录，请登录！');
            return redirect("auth/login");
        }else{
            $login = new LoginReport;
            $login->act_people = Auth::user()->realname;
            $login->act_people_id = Auth::user()->name;
            $login->act_time = time();
            $login->act_loginip = $_SERVER['REMOTE_ADDR'];
            $login->save();
        }
        return $next($request);
    }
}
