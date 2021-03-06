@extends('main')

@section('title','! 大管家管理系统')

@section('content')
@include('partials._message')
<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="/">大管家系统</a></li>
        <li><a href="/orders">订单管理</a></li>
        @if(Request::is('orders'))
            <li class="active">所有订单</li>
        @elseif(Request::is('orders/new'))
            <li class="active">新订单</li>
        @elseif(Request::is('orders/wait'))
            <li class="active">待服务</li>
        @elseif(Request::is('orders/remove'))
            <li class="active">服务中</li>
        @elseif(Request::is('orders/unpay'))
            <li class="active">未支付</li>
        @elseif(Request::is('orders/pay'))
            <li class="active">已支付</li>
        @elseif(Request::is('orders/cancel'))
            <li class="active">已删除</li>
        @elseif(Request::is('orders/myfollow'))
            <li class="active">我跟踪的订单</li>
        @elseif(Request::is('orders/unfollow'))
            <li class="active">待跟踪的订单</li>
        @endif
        <li><span onclick="history.go(-1)">返回上一页</span></li>
    </ol>
</div>
<div class="col-md-12" style="padding-bottom:10px">
    <ul class="nav nav-pills">
        <li role="presentation" class="<?php if(Request::is('orders')){echo 'active';} ?>"><a href="/orders">所有订单</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/new')){echo 'active';} ?>"><a href="/orders/new">新订单</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/wait')){echo 'active';} ?>"><a href="/orders/wait">待服务</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/remove')){echo 'active';} ?>"><a href="/orders/remove">服务中</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/unpay')){echo 'active';} ?>"><a href="/orders/unpay">未支付</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/pay')){echo 'active';} ?>"><a href="/orders/pay">已支付</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/cancel')){echo 'active';} ?>"><a href="/orders/cancel">已删除</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/myfollow')){echo 'active';} ?>"><a href="/orders/myfollow">我跟踪的订单</a></li>
        <li role="presentation" class="<?php if(Request::is('orders/unfollow')){echo 'active';} ?>"><a href="/orders/unfollow">待跟踪的订单</a></li>
    </ul>
</div>
<div class="col-md-12">
    <form action="/orders/search" method="get">
        <div class="col-md-4">
            <div class="col-md-6">
                <input type="text" class="form-control" name="usermobile" id="usermobile" placeholder="请填写要搜索的客户手机号码">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="ordernumber" id="ordernumber" placeholder="请填写要搜索的订单号码">
            </div>
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <input type="submit" class="btn btn-primary" value="搜索订单">
        </div>
    </form>
</div>
<div class="col-md-12 column">
    <div class="tabbable" id="tabs-788804">
        <div class="tab-content">
            <div class="tab-pane active" id="panel-118431">
                @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="col-md-12 column">
                    <div class="col-md-6 bg-pray" style="border-top-left-radius:5px; border-bottom-left-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;">
                        <div class="col-md-4">
                            <label>订单编号</label>：<span>{{$order['o_num']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>服务城市</label>：<span>{{$order['o_city']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>预约搬家时间</label>：<span>{{$order['o_remover_date']}} {{$order['o_remover_clock']}}</span>
                        </div>
                    </div>
                    <div class="col-md-6 bg-pray" style="border-top-right-radius:5px; border-bottom-right-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;">
                        <div class="col-md-4">
                            <label>订单状态</label>：<span class="btn btn-xs btn-danger">{{$order['o_custom_state']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>订单性质</label>：
                            @if($order['o_driver_grab'] == 0)
                                <span class="btn btn-xs btn-danger">待指派</span>
                            @elseif($order['o_driver_grab'] == 1)
                                <span class="btn btn-xs btn-warning">抢单</span>
                            @elseif($order['o_driver_grab'] == 2)
                                <span class="btn btn-xs btn-info">派单</span>
                            @endif
                        </div>
                        <div class="col-md-4" style="text-align: center">
                            <a href="/orders/show/{{$order['o_num']}}" class="btn btn-info">详情</a>
                            <a href="/orders/edit/{{$order['o_num']}}" class="btn <?php if($order['o_state']>=8 || $order['o_state']<0){echo "disabled btn-danger";}else{echo "btn-success";} ?>">编辑</a>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            <label>客户姓名</label>：<span>{{$order['o_linkman']}} </span>
                        </div>
                        <div class="col-md-4">
                            <label>联系电话</label>：<span>{{$order['o_linkman_tel']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>紧急电话</label>：<span>{{$order['o_urgent_tel']}}</span>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            <label>订单起点</label>：<span>{{$order['o_begin_address']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>订单终点</label>：<span>{{$order['o_end_address']}}</span>
                        </div>
                        <div class="col-md-4">
                            <label>提交订单时间</label>：<span>{{$order['o_time']}}</span>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            <label>订单里程</label>：<span>{{$order['o_mileage']}}KM</span>
                        </div>
                        <div class="col-md-4">
                            <label>里程费用</label>：<span>{{$order['o_mileage_price'] != null ? $order['o_mileage_price']  : "0.00"}}元</span>
                        </div>
                        <div class="col-md-4">
                            @if($order['o_state'] <7)
                            <label>人工费用</label>：<span>{{$order['o_start_price']}}元</span>
                            @else
                            <label>人工费用</label>：<span>{{$order['o_time_price']}}元</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        @if($order['o_state'] <7)
                        <div class="col-md-4">
                            <label>预估总价</label>：<span>{{$order['o_estimate_price'] != null ? $order['o_estimate_price'] :"0.00"}}元</span>
                        </div>
                        @else
                        <div class="col-md-4">
                            <label>预估总价</label>：<span>{{$order['o_price'] != null ? $order['o_price'] :"0.00"}}元</span>
                        </div>
                        @endif
                        @if($order['o_state'] == 8)
                            <div class="col-md-4">
                            @if(empty($order['o_final_price']))
                                <label>应付金额</label>：<span>{{$order['o_activity_price']}}</span>
                            @else
                                <label>应付金额</label>：<span>{{$order['o_activity_price']}}</span>
                            @endif
                            </div>
                            @else
                            <div class="col-md-4">
                                <label>应付金额</label>：<span>{{$order['o_activity_price']}}</span>
                            </div>
                        @endif
                        @if(!empty($order['customService']))
                        <div class="col-md-4">
                            <label>跟单客服</label>：<span class="btn btn-xs btn-info">{{$order['customService']}}</span>
                        </div>
                        @elseif($order->o_state < 8 && $order['o_state'] > 0)
                        <div class="col-md-4" style="text-align: right;">
                            <a class="btn btn-xs btn-warning" href="/orders/follow?ordernumber={{$order['o_num']}}">点此跟踪该订单</a>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            <label>订单司机</label>：<span>{{$order['o_worker_name']}}</span>
                        </div>
                        {{--<div class="col-md-4">
                            <label>搬家开始时间</label>：<span>{{$order['o_out_begin_time']}}</span>
                        </div>--}}
                        <div class="col-md-4">
                            <label>支付订单时间</label>：<span>{{$order['payTime']}}</span>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-9" style="overflow:hidden;">
                            <label>备注</label>：<span for="o_remark">{{mb_substr($order['o_remark'],0,30)}}</span>
                        </div>
                        @if($order['o_state'] < 5 && $order['o_state'] >0)
                        <div class="col-md-3"  style="text-align: right;">
                            <a class="btn btn-info" href="/orders/drivers?num={{$order['o_num']}}">指派订单给司机</a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
                    <div class="text-center">
                        {!! $orders->render() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection