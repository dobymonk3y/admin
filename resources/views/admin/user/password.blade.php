@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            @if(Request::is('user/password'))
                <li class="active">修改密码</li>
            @endif
        </ol>
    </div>
    <div class="col-md-4 col-md-offset-4">
        <form action="/user/changepwd" class="form-horizontal" role="form" method="post"  onsubmit="return passwordCheck()">
            {{csrf_field()}}
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">原始密码:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="password" id="password" placeholder="请输入原始密码" />
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">设定密码:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="请输入新密码" />
                </div>
            </div>
            <div class="form-group">
                <label for="confirmpassword" class="col-sm-2 control-label">重复密码:</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="请重复输入新密码" />
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-8 col-md-4">
                    <button type="submit" class="btn btn-success btn-block">修改密码</button>
                </div>
            </div>
        </form>
    </div>
@endsection