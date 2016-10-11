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
<div class="col-md-12 column">
    <div class="tabbable" id="tabs-788804">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#panel-118431" data-toggle="tab">所有订单</a>
            </li>
            <li>
                <a href="#panel-309110" data-toggle="tab">未处理</a>
            </li>
            <li>
                <a href="#panel-309110" data-toggle="tab">搬家中</a>
            </li>
            <li>
                <a href="#panel-309110" data-toggle="tab">未支付</a>
            </li>
            <li>
                <a href="#panel-309110" data-toggle="tab">已完成</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="panel-118431">
                @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="col-md-12 column">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                        <tr class="bg-primary">
                            <th>
                                订单编号：{{$order['orderNum']}}
                            </th>
                            <th>
                                服务城市：{{$order['city']}}
                            </th>
                            <th>
                                预约搬家时间：{{$order['removeTime']}}
                            </th>
                            <th>
                                订单状态：<label class="btn btn-xs btn-success">{{$order['status']}}</label>
                            </th>
                            <th>
                                订单性质：<label class="btn btn-xs btn-success">{{$order['driverGrab']}}</label>
                            </th>
                            <th style="text-align: center;">
                                <a href="" class="btn btn-xs btn-default">详情</a>
                                <a href="" class="btn btn-xs btn-default">编辑</a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>客户姓名：{{$order['name']}}</td>
                            <td>联系电话：{{$order['linkmanTel']}}</td>
                            <td>紧急电话：{{$order['urgentTel']}}</td>
                            <td>订单起点：{{$order['beginAddress']}}</td>
                            <td>订单终点：{{$order['endAddress']}}</td>
                            <td>提交订单时间：{{$order['orderTime']}}</td>
                        </tr>
                        <tr>
                            <td>订单里程：{{$order['milage']}}KM</td>
                            <td>里程费用：{{$order['milageCost']}}元</td>
                            <td>人工费用：{{$order['singleCost']}}元</td>
                            <td>预估总价：{{$order['estimateCost']}}元</td>
                            <td>实付金额：{{$order['orderCost']}}</td>
                            <td>跟单客服：<label class="btn btn-xs btn-info">{{$order['customService']}}</label></td>
                        </tr>
                        <tr>
                            <td>订单司机：{{$order['driver']}}</td>
                            <td>搬家开始时间：{{$order['beginTime']}}</td>
                            <td>支付订单时间：{{$order['payTime']}}</td>
                            <td colspan="3">备注：</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
                @else
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            &times;
                        </button>
                        <strong>Errors:</strong><p>糟糕, 好像并没有查找到相关的数据! 要不, 看看别的?</p>
                    </div>
                @endif
            </div>
            <div class="tab-pane" id="panel-309110">
                <p>
                    Howdy, I'm in Section 2.
                </p>
            </div>
        </div>
    </div>
</div>

{{--<div class="col-md-12 column custom-border">
    <div class="bg-primary col-md-12">
        <div>订单编号：R14760899972362</div>
        <div>服务城市：北京市</div>
        <div>预约搬家时间：2016-10-11 11:40</div>
        <div>订单状态：<label class="btn btn-xs btn-info">未支付</label></div>
        <div>订单性质：<label class="btn btn-xs btn-success">抢单</label></div>
    </div>
    <div>
        <div>客户姓名：张若愚</div>
        <div>联系电话：13800138000</div>
        <div>紧急电话：13800138000</div>
        <div>订单起点：新潮嘉园三期</div>
        <div>订单终点：物资学院</div>
    </div>
    <div>
        <div>订单里程：10.03KM</div>
        <div>里程费用：123.45元</div>
        <div>人工费用：123.45元</div>
        <div>预估总价：246.90元</div>
        <div>实付金额：246.90元</div>
    </div>
    <div>
        <div>订单司机：李四(13800138000)</div>
        <div>提交订单时间：2016-10-11 11:41:57</div>
        <div>搬家开始时间：2016-10-11 11:42:02</div>
        <div>支付订单时间：2016-10-11 11:42:04</div>
        <div>跟单客服：<label class="btn btn-xs btn-info">张若愚</label></div>
    </div>
</div>--}}
{{--<div class="col-md-12 column" style="padding-left: 15px;padding-right: 5px;">
    --}}{{--列头--}}{{--
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
    --}}{{--表单--}}{{--
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
</div>--}}
<div>

</div>

@endsection