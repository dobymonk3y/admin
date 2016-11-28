<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginReport;
use App\Models\Process;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Models\Assignlog;

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
        $starttime = $request->input('timestart');
        $endtime = $request->input('timeend');
        $stime = strtotime($starttime);
        $etime = strtotime($endtime);
        $logins = LoginReport::where('act_people','=',$name)->whereBetween('act_time', [$stime,$etime])->orderBy('act_time','DESC')->paginate(15);
        if (count($logins) <1){
            Session::flash('loginsEmpty',"Oops, 并没有找到你想要的结果哟,~");
        }
        return view('admin.log.login')->withLogins($logins)->withName($name)->withStarttime($starttime)->withEndtime($endtime);
    }

    public function process( ){
        $processes = Process::orderBy('Id','DESC')->paginate(15);
        return view('admin.log.process')->withProcesses($processes);
    }

    public function processcheck(Request $request){
        $name = trim($request->input('username'));
        $stime = date("Y-m-d",(strtotime($request->input('timestart'))));
        $etime = date("Y-m-d",(strtotime($request->input('timeend'))));
        $state = $request->input('state');
        if($state == 9){
            $processes = Process::where('act_people','=',$name)->whereBetween('act_time',[$stime,$etime])->orderBy('Id','DESC')->paginate(15);
        }else{
            $processes = Process::where('act_people','=',$name)->whereBetween('act_time',[$stime,$etime])->where('act_stat','=',$state)->orderBy('Id','DESC')->paginate(15);
        }
        return view('admin.log.processcheck')->withProcesses($processes)->withName($name)->withStime($stime)->withEtime($etime)->withState($state);
    }

    public function assignlog()
    {
        $assignlogs = Assignlog::orderBy('o_time','DESC')->paginate(15);
        
        return view('admin.log.assignlog')->withAssignlogs($assignlogs);
    }
}
