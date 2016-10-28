<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginReport;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class LogController extends Controller
{
    public function login()
    {
        $logins = LoginReport::orderBy('act_time','desc')->paginate(15);
        return view('admin.log.login')->withLogins($logins);
    }

    public function mylogin()
    {
        $logins = LoginReport::where('act_people_id','=',Auth::user()->name)->orderBy('act_time','desc')->paginate(15);
        return view('admin.log.login')->withLogins($logins);
    }

    public function logincheck(Request $request)
    {
        $name = $request->input('username');

        return 123;
    }
}
