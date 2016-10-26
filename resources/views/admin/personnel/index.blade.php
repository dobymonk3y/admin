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
        @if($humaninfo)
            @foreach($humaninfo as $k => $v)
            <div class="col-md-12 custom-border-bottom" style="padding-bottom: 15px;">
                <div class="col-md-1"><button class="btn btn-info">{{$v->Id}}</button></div>
                <div class="col-md-2">{{$v->human_username}}</div>
                <div class="col-md-2">{{$v->human_name}}</div>
                <div class="col-md-2">{{$v->human_purview}}</div>
                <div class="col-md-2">{{$v->human_work}}</div>
                @if($v->human_stat=='在职')
                <div class="col-md-1"><a href="/personnel/onthejob" class="btn btn-success">{{$v->human_stat}}</a></div>
                @elseif($v->human_stat=='离职')
                <div class="col-md-1"><a href="/personnel/leaving" class="btn btn-danger">{{$v->human_stat}}</a></div>
                @elseif($v->human_stat=='请假')
                <div class="col-md-1"><a href="/personnel/holiday" class="btn btn-warning">{{$v->human_stat}}</a></div>
                @endif
                <div class="col-md-2">
                    <a href="#" class="btn btn-warning">查看</a>
                    <a href="#" class="btn btn-primary">编辑</a>
                    @if($v->human_stat=='在职' || $v->human_stat=='请假')
                    <a href="#" class="btn btn-danger">设为离职</a>
                    @else
                    <a href="#" class="btn btn-success">设为复职</a>
                    @endif
                </div>
            </div>
            @endforeach
            <div style="text-align: center">
                {!! $humaninfo->render() !!}
            </div>
        @else
        @endif
</div>
@endsection