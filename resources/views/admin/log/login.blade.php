@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    @if(Session::has('loginsEmpty'))
        <div class="alert alert-warning alert-dismissable" id="loginsEmpty" onload="autohide()">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            <strong>Errors:</strong>{{  Session::get('loginsEmpty') }}
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
    @if(Request::is('log/login'))
    <div class="col-md-12">
        <form action="/log/logincheck" method="get"  onsubmit="return searchLog()">
            <div class="col-md-2 ">
                <input class="form-control" type="text" id="username" name="username" placeholder="请输入用户姓名( 非帐号 )">
            </div>
            <div class="col-md-3">
                <div class="col-md-6">
                    <div class="layui-inline">
                        <input class="form-control" placeholder="选择起始时间" id="timestart" name="timestart" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="layui-inline">
                        <input class="form-control" placeholder="选择结束时间" id="timeend" name="timeend" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">搜索记录</button>
            </div>
        </form>
    </div>
    @endif
    <div class="col-md-12 custom-margin-top-15">
        <table class="table table-hover">
            <thead class="bg-primary">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    登陆用户
                </th>
                <th>
                    登陆用户名
                </th>
                <th>
                    登陆时间
                </th>
                <th>
                    登陆IP
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($logins as $login)
            <tr>
                <td>
                    {{$login->Id}}
                </td>
                <td>
                    {{$login->act_people}}
                </td>
                <td>
                    {{$login->act_people_id}}
                </td>
                <td>
                    {{date("Y-m-d H:i:s",$login->act_time)}}
                </td>
                <td>
                    {{$login->act_loginip}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-md-12 text-center">{!! $logins->render() !!}</div>
    </div>

@endsection