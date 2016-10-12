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
                <a href="#panel-118432" data-toggle="tab">新订单</a>
            </li>
            <li>
                <a href="#panel-118433" data-toggle="tab">待搬家</a>
            </li>
            <li>
                <a href="#panel-118434" data-toggle="tab">搬家中</a>
            </li>
            <li>
                <a href="#panel-118435" data-toggle="tab">未支付</a>
            </li>
            <li>
                <a href="#panel-118436" data-toggle="tab">已支付</a>
            </li>
            <li>
                <a href="#panel-118437" data-toggle="tab">已取消</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="panel-118431">
                @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="col-md-12 column">
                    <div class="col-md-6 bg-info" style="height: 40px;line-height: 40px;margin-top: 10px;">
                        <div class="col-md-4">
                            订单编号：<label for="">{{$order['o_num']}}</label>
                        </div>
                        <div class="col-md-4">
                            服务城市：<label for="">{{$order['o_city']}}</label>
                        </div>
                        <div class="col-md-4">
                            预约搬家时间：<label for="">{{$order['o_remover_date']}}</label>
                        </div>
                    </div>
                    <div class="col-md-6 bg-info" style="height: 40px;line-height: 40px;margin-top: 10px;">
                        <div class="col-md-4">
                            订单状态：<label for="o_state" class="btn btn-xs btn-danger">{{$order['o_state']}}</label>
                        </div>
                        <div class="col-md-4">
                            订单性质：
                            @if($order['o_driver_grab'] == "派单")
                                <label for="o_driver_grab" class="btn btn-xs btn-success">{{$order['o_driver_grab']}}</label>
                            @else
                                <label for="o_driver_grab" class="btn btn-xs btn-warning">{{$order['o_driver_grab']}}</label>
                            @endif
                        </div>
                        <div class="col-md-4" style="text-align: center">
                            <a href="" class="btn btn-xs btn-primary">详情</a>
                            <a href="" class="btn btn-xs btn-primary">编辑</a>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            客户姓名：<label for="o_linkman">{{$order['o_linkman']}} </label>
                        </div>
                        <div class="col-md-4">
                            联系电话：<label for="o_linkman_tel">{{$order['o_linkman_tel']}}</label>
                        </div>
                        <div class="col-md-4">
                            紧急电话：<label for="o_urgent_tel">{{$order['o_urgent_tel']}}</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            订单起点：<label for="o_begin_address">{{$order['o_begin_address']}}</label>
                        </div>
                        <div class="col-md-4">
                            订单终点：<label for="o_end_address">{{$order['o_end_address']}}</label>
                        </div>
                        <div class="col-md-4">
                            提交订单时间：<label for="o_time">{{$order['o_time']}}</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            订单里程：<label for="o_mileage"></label>{{$order['o_mileage']}}KM
                        </div>
                        <div class="col-md-4">
                            里程费用：<label for="o_mileage_price">{{$order['o_mileage_price']}}元</label>
                        </div>
                        <div class="col-md-4">
                            人工费用：<label for="o_single_time_price">{{$order['o_single_time_price']}}元</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            预估总价：<label for="o_estimate_price">{{$order['o_estimate_price']}}元</label>
                        </div>
                        <div class="col-md-4">
                            实付金额：<label for="o_final_price">{{$order['o_final_price']}}</label>
                        </div>
                        <div class="col-md-4">
                            跟单客服：<label for="customService" class="btn btn-xs btn-info">{{$order['customService']}}</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-4">
                            订单司机：<label for="o_worker_name">{{$order['o_worker_name']}}</label>
                        </div>
                        <div class="col-md-4">
                            搬家开始时间：<label for="o_out_begin_time">{{$order['o_out_begin_time']}}</label>
                        </div>
                        <div class="col-md-4">
                            支付订单时间：<label for="payTime">{{$order['payTime']}}</label>
                        </div>
                    </div>
                    <div class="col-md-6" style="height: 30px;line-height: 30px;">
                        <div class="col-md-12" style="overflow:hidden;">
                            备注：<label for="o_remark">{{$order['o_remark']}}</label>
                        </div>
                    </div>
                </div>
                @endforeach
                    <div style="text-align: center">
                        {!! $orders->render() !!}
                    </div>
                @else
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            &times;
                        </button>
                        <strong>Errors:</strong><p>糟糕, 好像并没有查找到相关的数据! 要不, 看看别的?</p>
                    </div>
                @endif
            </div>
            <div class="tab-pane" id="panel-118432">
                @if(count($news) > 0)
                    @foreach($news as $new)
                        <div class="col-md-12 column">
                            <div class="col-md-6 bg-info" style="height: 40px;line-height: 40px;margin-top: 10px;">
                                <div class="col-md-4">
                                    订单编号：<label for="">{{$new['o_num']}}</label>
                                </div>
                                <div class="col-md-4">
                                    服务城市：<label for="">{{$new['o_city']}}</label>
                                </div>
                                <div class="col-md-4">
                                    预约搬家时间：<label for="">{{$new['o_remover_date']}}</label>
                                </div>
                            </div>
                            <div class="col-md-6 bg-info" style="height: 40px;line-height: 40px;margin-top: 10px;">
                                <div class="col-md-4">
                                    订单状态：<label for="o_state" class="btn btn-xs btn-danger">{{$new['o_state']}}</label>
                                </div>
                                <div class="col-md-4">
                                    订单性质：
                                    @if($new['o_driver_grab'] == "派单")
                                        <label for="o_driver_grab" class="btn btn-xs btn-success">{{$new['o_driver_grab']}}</label>
                                    @else
                                        <label for="o_driver_grab" class="btn btn-xs btn-warning">{{$new['o_driver_grab']}}</label>
                                    @endif
                                </div>
                                <div class="col-md-4" style="text-align: center">
                                    <a href="" class="btn btn-xs btn-primary">详情</a>
                                    <a href="" class="btn btn-xs btn-primary">编辑</a>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-4">
                                    客户姓名：<label for="o_linkman">{{$new['o_linkman']}} </label>
                                </div>
                                <div class="col-md-4">
                                    联系电话：<label for="o_linkman_tel">{{$new['o_linkman_tel']}}</label>
                                </div>
                                <div class="col-md-4">
                                    紧急电话：<label for="o_urgent_tel">{{$new['o_urgent_tel']}}</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-4">
                                    订单起点：<label for="o_begin_address">{{$new['o_begin_address']}}</label>
                                </div>
                                <div class="col-md-4">
                                    订单终点：<label for="o_end_address">{{$new['o_end_address']}}</label>
                                </div>
                                <div class="col-md-4">
                                    提交订单时间：<label for="o_time">{{$new['o_time']}}</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-4">
                                    订单里程：<label for="o_mileage"></label>{{$new['o_mileage']}}KM
                                </div>
                                <div class="col-md-4">
                                    里程费用：<label for="o_mileage_price">{{$new['o_mileage_price']}}元</label>
                                </div>
                                <div class="col-md-4">
                                    人工费用：<label for="o_single_time_price">{{$new['o_single_time_price']}}元</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-4">
                                    预估总价：<label for="o_estimate_price">{{$new['o_estimate_price']}}元</label>
                                </div>
                                <div class="col-md-4">
                                    实付金额：<label for="o_final_price">{{$new['o_final_price']}}</label>
                                </div>
                                <div class="col-md-4">
                                    跟单客服：<label for="customService" class="btn btn-xs btn-info">{{$new['customService']}}</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-4">
                                    订单司机：<label for="o_worker_name">{{$new['o_worker_name']}}</label>
                                </div>
                                <div class="col-md-4">
                                    搬家开始时间：<label for="o_out_begin_time">{{$new['o_out_begin_time']}}</label>
                                </div>
                                <div class="col-md-4">
                                    支付订单时间：<label for="payTime">{{$new['payTime']}}</label>
                                </div>
                            </div>
                            <div class="col-md-6" style="height: 30px;line-height: 30px;">
                                <div class="col-md-12" style="overflow:hidden;">
                                    备注：<label for="o_remark">{{$new['o_remark']}}</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div style="text-align: center">
                        {!! $news->render() !!}
                    </div>
                @else
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            &times;
                        </button>
                        <strong>Errors:</strong><p>糟糕, 好像并没有查找到相关的数据! 要不, 看看别的?</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection