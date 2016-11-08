@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')

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
        <form action="/user/update" class="form-horizontal" role="form" method="post" onsubmit="return updateCheck()">
            {{csrf_field()}}
            <div class="form-group">
                <label for="realname" class="col-sm-2 control-label">用户姓名:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="realname" id="realname" value="{{Auth::user()->realname}}"/>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">用户账号:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" id="name" readonly value="{{Auth::user()->name}}"/>
                </div>
            </div>
            <div class="form-group">
                <label for="position" class="col-sm-2 control-label">选择职位:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="position" id="position">
                        <option value="" selected disabled>请选择职位</option>
                        <option value="1" <?php if(Auth::user()->groupid == 1) {echo "selected";} else{ echo "disabled";}?>>管理员</option>
                        <option value="2" <?php if(Auth::user()->groupid == 2) {echo "selected";} else{ echo "disabled";}?>>客服经理</option>
                        <option value="3" <?php if(Auth::user()->groupid == 3) {echo "selected";} else{ echo "disabled";}?>>客服人员</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-8 col-md-4">
                    <button type="submit" class="btn btn-primary btn-block">修改资料</button>
                </div>
            </div>
        </form>
    </div>
@endsection