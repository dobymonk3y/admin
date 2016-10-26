@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            <li>人事管理</li>
            @if(Request::is('personnel') || Request::is('personnel/index'))
                <li class="active">员工资料浏览</li>
            @elseif(Request::is('orders/cancel'))
                <li class="active">已取消</li>
            @endif
        </ol>
    </div>
    <div class="col-md-12" style="text-align: center;">
        <div class="col-md-12" ></div>
        <div class="col-md-12 custom-line-height bg-primary" style=" border-radius: 5px;">
            <div class="col-md-1"><label>序号</label></div>
            <div class="col-md-2"><label>唯一ID</label></div>
            <div class="col-md-2"><label>姓名</label></div>
            <div class="col-md-2"><label>所属部门</label></div>
            <div class="col-md-2"><label>工作岗位</label></div>
            <div class="col-md-1"><label>状态</label></div>
            <div class="col-md-2"><label>操作</label></div>
        </div>
    </div>
@endsection