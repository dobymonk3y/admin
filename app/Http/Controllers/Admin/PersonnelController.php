<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Human;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $humaninfo = Human::select(['Id','human_username','human_name','human_work','human_purview','human_stat'])->paginate(10);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
