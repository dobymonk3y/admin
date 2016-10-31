<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginReport;
use App\Models\Process;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;

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
        $name = trim($request->input('username'));
        $stime = strtotime($request->input('timestart'));
        $etime = strtotime($request->input('timeend'));
        $logins = LoginReport::where('act_people','=',$name)->whereBetween('act_time', [$stime,$etime])->orderBy('act_time','DESC')->paginate(15);
        if (count($logins) <1){
            Session::flash('loginsEmpty',"Oops, 并没有找到你想要的结果哟,~");
        }
        return view('admin.log.login')->withLogins($logins);
    }
    public function process( ){
        $processes = Process::orderBy('Id','DESC')->paginate(10);
        return view('admin.log.process')->withProcesses($processes);
    }
    public function processcheck(Request $request){

    }
}
