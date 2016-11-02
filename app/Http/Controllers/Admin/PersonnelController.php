<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Human;
use Session;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $humaninfo = Human::select(['Id','human_username','human_name','human_work','human_purview','human_stat'])->orderBy('Id','DESC')->paginate(15);
        foreach($humaninfo as $k =>$v){
            if($v->human_purview == "guanliyuan"){
                $v->human_purview = "管理员";
            }elseif($v->human_purview == "kefubu"){
                $v->human_purview = "客服部";
            }
            if($v->human_work == "guanliyuan"){
                $v->human_work = "管理员";
            }elseif($v->human_work == "kefurenyuan"){
                $v->human_work = "客服人员";
            }elseif($v->human_work == "kefujingli"){
                $v->human_work = "客服经理";
            }
            if($v->human_stat == 1){
                $v->human_stat = '在职';
            }elseif($v->human_stat == 2){
                $v->human_stat = '请假';
            }elseif($v->human_stat == 3){
                $v->human_stat = '离职';
            }
        }
        return view('admin.personnel.index')->withHumaninfo($humaninfo);
    }

    public function onthejob()
    {
        $humaninfo = Human::select(['Id','human_username','human_name','human_work','human_purview','human_stat'])->where('human_stat','=',1)->paginate(15);
        foreach($humaninfo as $k =>$v){
            if($v->human_purview == "guanliyuan"){
                $v->human_purview = "管理员";
            }elseif($v->human_purview == "kefubu"){
                $v->human_purview = "客服部";
            }
            if($v->human_work == "guanliyuan"){
                $v->human_work = "管理员";
            }elseif($v->human_work == "kefurenyuan"){
                $v->human_work = "客服人员";
            }elseif($v->human_work == "kefujingli"){
                $v->human_work = "客服经理";
            }
            if($v->human_stat == 1){
                $v->human_stat = '在职';
            }elseif($v->human_stat == 2){
                $v->human_stat = '请假';
            }elseif($v->human_stat == 3){
                $v->human_stat = '离职';
            }
        }
        return view('admin.personnel.index')->withHumaninfo($humaninfo);
    }

    public function leaving()
    {
        $humaninfo = Human::select(['Id','human_username','human_name','human_work','human_purview','human_stat'])->where('human_stat','=',3)->paginate(15);
        foreach($humaninfo as $k =>$v){
            if($v->human_purview == "guanliyuan"){
                $v->human_purview = "管理员";
            }elseif($v->human_purview == "kefubu"){
                $v->human_purview = "客服部";
            }
            if($v->human_work == "guanliyuan"){
                $v->human_work = "管理员";
            }elseif($v->human_work == "kefurenyuan"){
                $v->human_work = "客服人员";
            }elseif($v->human_work == "kefujingli"){
                $v->human_work = "客服经理";
            }
            if($v->human_stat == 1){
                $v->human_stat = '在职';
            }elseif($v->human_stat == 2){
                $v->human_stat = '请假';
            }elseif($v->human_stat == 3){
                $v->human_stat = '离职';
            }
        }
        return view('admin.personnel.index')->withHumaninfo($humaninfo);
    }

    public function holiday()
    {
        $humaninfo = Human::select(['Id','human_username','human_name','human_work','human_purview','human_stat'])->where('human_stat','=',2)->paginate(15);
        foreach($humaninfo as $k =>$v){
            if($v->human_purview == "guanliyuan"){
                $v->human_purview = "管理员";
            }elseif($v->human_purview == "kefubu"){
                $v->human_purview = "客服部";
            }
            if($v->human_work == "guanliyuan"){
                $v->human_work = "管理员";
            }elseif($v->human_work == "kefurenyuan"){
                $v->human_work = "客服人员";
            }elseif($v->human_work == "kefujingli"){
                $v->human_work = "客服经理";
            }
            if($v->human_stat == 1){
                $v->human_stat = '在职';
            }elseif($v->human_stat == 2){
                $v->human_stat = '请假';
            }elseif($v->human_stat == 3){
                $v->human_stat = '离职';
            }
        }
        return view('admin.personnel.index')->withHumaninfo($humaninfo);
    }

    public function addNew()
    {
        return view('admin.personnel.addnew');
    }

    public function saveNew(Request $request)
    {
        $name = $request->input('name');
        $realname = $request->input('realname');
        $password = $request->input('password');
        $confirmpassword = $request->input('confirmpassword');
        $groupid = $request->input('position');
        if ($name =='' || $realname =='' || $password =='' || $confirmpassword =='' || $groupid ==''){
            Session::flash('personnelAddError','请检查必填项是否完全填写, 如果确定填写仍报错, 请联系管理员!');
            return view('admin.personnel.add');
        }
        $user =  new User();
        $user->name = $name;
        $user->realname = $realname;
        $user->password = bcrypt($password);
        $user->groupid = $groupid;
        $res = $user->save();
        if($res < 0){
            Session::flash('personnelAddFaild','新用户填加失败! 请重新填加, 或联系管理员!');
            return view('admin.personnel.add');
        }else{
            Session::flash('personnelAddSuccess','新用户填加功!');
        }
        return redirect('/personnel/index');
    }
}
