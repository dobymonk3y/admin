@extends('main')

@section('title','! 大管家管理系统')

@section('content')

@if(Session::has('loginsuccess'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('loginsuccess') }}
    </div>
@endif

<div class="col-md-12 column" style="padding-left: 15px;padding-right: 5px;">
    {{--列头--}}
    <div class="row bg-primary" style="border-top-left-radius: 5px;border-top-right-radius: 5px;height: 40px;line-height: 40px;text-align: center;">
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-5">订单编号</div>
                <div class="col-xs-2">区域</div>
                <div class="col-xs-2">姓名</div>
                <div class="col-xs-3">订单起点</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-3">订单终点</div>
                <div class="col-xs-3">里程</div>
                <div class="col-xs-3">客户电话</div>
                <div class="col-xs-3">紧急电话</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-4">司机信息</div>
                <div class="col-xs-4">下单时间</div>
                <div class="col-xs-4">搬家时间</div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="row">
                <div class="col-xs-4">支付时间</div>
                <div class="col-xs-2">状态</div>
                <div class="col-xs-2">客服</div>
                <div class="col-xs-4">操作</div>
            </div>
        </div>
    </div>
    {{--表单--}}
    <div class="row" style="height: 20px;line-height: 20px;text-align: center;">
        <div class="col-xs-3 custom-line-height">
            <div class="row custom-line-height">
                <div class="col-xs-5 custom-line-height">R14760899972362</div>
                <div class="col-xs-2 custom-line-height">北京市</div>
                <div class="col-xs-2 custom-line-height">张若愚</div>
                <div class="col-xs-3 custom-line-height">新潮嘉园</div>
            </div>
        </div>
        <div class="col-xs-3 custom-line-height">
            <div class="row custom-line-height">
                <div class="col-xs-3 custom-line-height">物资学院</div>
                <div class="col-xs-3 custom-line-height">101.11km</div>
                <div class="col-xs-3 custom-line-height">18001163632</div>
                <div class="col-xs-3 custom-line-height">18513603626</div>
            </div>
        </div>
        <div class="col-xs-3 custom-line-height">
            <div class="row custom-line-height">
                <div class="col-xs-4 custom-line-height">李四(13800138000)</div>
                <div class="col-xs-4 custom-line-height">2016-10-10 23:00</div>
                <div class="col-xs-4 custom-line-height">2016-10-10 23:31</div>
            </div>
        </div>
        <div class="col-xs-3 custom-line-height">
            <div class="row custom-line-height">
                <div class="col-xs-4 custom-line-height">2016-10-10 23:31</div>
                <div class="col-xs-2 custom-line-height">已支付</div>
                <div class="col-xs-2 custom-line-height">张若愚</div>
                <div class="col-xs-4 custom-line-height">
                    <a href="" class="btn btn-primary">详情</a>
                    <a href="" class="btn btn-primary">编辑</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection