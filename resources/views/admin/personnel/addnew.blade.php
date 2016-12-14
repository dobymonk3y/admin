@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    @if(Session::has('personnelAddError'))
        <div class="alert alert-warning alert-dismissable" id="personnelAddError" onload="autohide()">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            <strong>Errors:</strong>{{  Session::get('personnelAddError') }}
        </div>
    @endif
    @if(Session::has('personnelAddFaild'))
        <div class="alert alert-warning alert-dismissable" id="personnelAddFaild" onload="autohide()">
            <button type="button" class="close" data-dismiss="alert"
                    aria-hidden="true">
                &times;
            </button>
            <strong>Errors:</strong>{{  Session::get('personnelAddFaild') }}
        </div>
    @endif
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            <li>人事管理</li>
            @if(Request::is('personnel') || Request::is('personnel/index'))
                <li class="active">员工资料浏览</li>
            @elseif(Request::is('personnel/add'))
                <li class="active">新增员工</li>
            @endif
        </ol>
    </div>
    <div class="col-md-4 col-md-offset-4">
        <form action="/personnel/save" class="form-horizontal" role="form" method="post"  onsubmit="return personnelCheck()">
            {{csrf_field()}}
            <div class="form-group">
                <label for="realname" class="col-sm-2 control-label">用户姓名:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="realname" id="realname" placeholder="请输入使用者姓名" />
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">用户账号:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" placeholder="请输入使用者登录帐号" />
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">设定密码:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="请输入密码" />
                </div>
            </div>
            <div class="form-group">
                <label for="confirmpassword" class="col-sm-2 control-label">重复密码:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="请确定密码" />
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="col-sm-2 control-label">选择职位:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="position" id="position">
                        <option value="" selected disabled>请选择职位</option>
                        <option value="1">管理员</option>
                        <option value="2">客服经理</option>
                        <option value="3">客服人员</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-8 col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">新增员工</button>
                </div>
            </div>
        </form>
    </div>
@endsection