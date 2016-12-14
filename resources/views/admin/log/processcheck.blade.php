@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    @if(Session::has('processEmpty'))
        <div class="alert alert-warning alert-dismissable" id="processEmpty" onload="autohide()">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            <strong>Errors:</strong>{{  Session::get('processEmpty') }}
        </div>
    @endif
    <div class="col-md-12" id="namenotice" style="display: none;">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>出错啦！</strong>确定不给我个搜索条件么?
        </div>
    </div>
    <div class="col-md-12" id="timenotice" style="display: none;">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>出错啦！</strong>请选择完整的查询时间段。
        </div>
    </div>
    <div class="col-md-12" id="checkresult" style="display: none;">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>查询完毕！</strong>
        </div>
    </div>
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            <li>报表与日志</li>
            @if(Request::is('log/login'))
                <li class="active"><a href="/log/login">系统登录日志</a></li>
            @elseif(Request::is('log/mylogin'))
                <li class="active"><a href="/log/mylogin">个人登录日志</a></li>
            @elseif(Request::is('log/process'))
                <li class="active"><a href="/log/process">操作记录</a></li>
            @endif
        </ol>
    </div>
    @if(Request::is('log/process') || Request::is('log/processcheck'))
        <div class="col-md-12">
            <form action="/log/processcheck" method="get"  onsubmit="return searchLog()">
                <div class="col-md-2 ">
                    <input class="form-control" type="text" id="username" name="username" placeholder="请输入操作者姓名" value="{{  $_GET['username'] != '' ? trim($_GET['username']) :'' }}">
                </div>
                <div class="col-md-3">
                    <div class="col-md-6">
                        <div class="layui-inline">
                            <input class="form-control" placeholder="选择起始时间" id="timestart" name="timestart" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})" value="{{  $_GET['timestart'] != '' ? $_GET['timestart'] :'' }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="layui-inline">
                            <input class="form-control" placeholder="选择结束时间" id="timeend" name="timeend" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})" value="{{  $_GET['timeend'] != '' ? $_GET['timeend'] :'' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="col-md-6">
                        <select class="form-control" name="state">
                            <option value="9" selected="{{  $_GET['state'] == 9 ? 'selected' :'' }}">所有</option>
                            <option value="1" selected="{{  $_GET['state'] == 1 ? 'selected' :'' }}">增加员工资料</option>
                            <option value="2" selected="{{  $_GET['state'] == 2 ? 'selected' :'' }}">编辑员工资料</option>
                            <option value="3" selected="{{  $_GET['state'] == 3 ? 'selected' :'' }}">删除员工资料</option>
                            <option value="4" selected="{{  $_GET['state'] == 4 ? 'selected' :'' }}">员工离职</option>
                            <option value="5" selected="{{  $_GET['state'] == 5 ? 'selected' :'' }}">员工复职</option>
                            <option value="6" selected="{{  $_GET['state'] == 6 ? 'selected' :'' }}">员工请假</option>
                            <option value="7" selected="{{  $_GET['state'] == 7 ? 'selected' :'' }}">还原密码</option>
                            <option value="8" selected="{{  $_GET['state'] == 8 ? 'selected' :'' }}">变更工作</option>
                        </select>
                    </div>
                    <div class="col-md-6"><button type="submit" class="btn btn-primary">搜索记录</button></div>
                </div>
            </form>
        </div>
    @endif
    <div class="col-md-12 custom-margin-top-15">
        <table class="table table-hover">
            <thead class="bg-primary">
            <tr>
                <th>ID</th>
                <th>操作者</th>
                <th>操作者用户名</th>
                <th>操作时间</th>
                <th>对象姓名</th>
                <th>对象用户名</th>
                <th>操作内容</th>
            </tr>
            </thead>
            <tbody>
            @foreach($processes as $process)
                <tr>
                    <td>
                        {{$process->Id}}
                    </td>
                    <td>
                        {{$process->act_people}}
                    </td>
                    <td>
                        {{$process->act_people_id}}
                    </td>
                    <td>
                        {{$process->act_date,$process->act_time}}
                    </td>
                    <td>
                        {{$process->obj_people}}
                    </td>
                    <td>
                        {{$process->obj_people_id}}
                    </td>
                    <td>
                        {!! $process->act_remark !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-md-12 text-center">{!! $processes->render() !!}</div>
    </div>

@endsection