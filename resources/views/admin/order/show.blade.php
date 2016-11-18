@extends('main')

@section('title','! 大管家管理系统')

@section('content')
@include('partials._message')
@if(Session::has('showOrderFaild'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Warnning:</strong>{{  Session::get('showOrderFaild') }}　<label for=""><a href="/orders">查看所有订单信息</a></label>
    </div>
@endif
@if($order != null)
<div class="col-md-12">
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">订单信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">订单编号：</label>
            </div>
            <div class="col-md-8" style="color: green">
                <label for="o_num">{{$order->o_num}}</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">搬家城市：</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_city}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">订单状态：</label>
            </div>
            <div class="col-md-8">
                <button class="btn btn-xs btn-warning">{{$order->o_custom_state}}</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">客户：</label>
            </div>
            <div class="col-md-8">
                <label for="o_num" style="color: green">{{$order->o_linkman}}</label><span>  {{$order->o_user_sex == 1 ? "先生" : "女士"}}</span>{{--　　用户名: {{$order->o_user}}--}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">下单时间：</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_time}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">预约时间：</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_remover_date}} {{$order->o_remover_clock}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">电话：</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_linkman_tel}}</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-2">
                <label for="ordernum">备注：</label>
            </div>
            <div class="col-md-10">
                <p>{{$order->o_remark}}</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">搬家公司信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">搬家车组：</label>
            </div>
            <div class="col-md-8">
                <p>车牌号：{{$order->o_plate_num}}   负责人：{{$order->o_worker_name}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">搬家状态：	</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_remover_state}}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <p>评价状态：</p>
            </div>
            <div class="col-md-8">
                <p>未评价 / 已评价</p>
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-6"><label for="ordernum">搬家时间记录：</label></div>
            <div class="col-md-6"><label for="o_num">搬出开始：</label>{{$order->o_out_begin_time}}</div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6"><label for="o_num">搬出结束：</label>{{$order->o_out_end_time}}</div>
            <div class="col-md-6"><label for="o_num">搬入开始：</label>{{$order->o_in_begin_time}}</div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6"><label for="o_num">搬入结束：</label>{{$order->o_in_end_time}}</div>
        </div>
    </div>

    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">价格信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">人工/时间价格：</label>
            </div>
            @if($order->o_state < 7)
                <div class="col-md-8">
                    <label for="o_num" style="color:red;">{{$order->o_start_price}}元</label>
                </div>
            @else
                <div class="col-md-8">
                    <label for="o_num" style="color:red;">{{$order->o_time_price}}元</label>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">里程价格：</label>
            </div>
            <div class="col-md-8">
                <label for="o_num" style="color:red;">{{$order->o_mileage_price != null ? $order->o_mileage_price : "0.00"}}元</label> {{$order->o_mileage_intro}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">特殊时段费：</label>
            </div>
            <div class="col-md-8">
                <label for="o_num" style="color:red;">{{$order->o_special_time_price != null ? $order->o_special_time_price : "0.00" }}元</label>　{{$order->o_special_time_price_intro}}
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">总价(无附加费)：</label>
            </div>
            <div class="col-md-8">
                <label for="o_num" style="color:red;">{{$order->o_price != null ? $order->o_price :"0.00"}}元</label> ( 没有折扣的原始价格 )
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">折扣价格：</label>
            </div>
            <div class="col-md-8">
                <label for="o_num" style="color:red;">{{$order->o_activity_price != null ? $order->o_activity_price : "0.00"}}元</label>　{{$order->o_activity}} 折(无附加费)
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">应付金额：</label>
            </div>
            <div class="col-md-8">
                @if($order->o_state < 7)
                        <label for="o_num" style="color:red;">{{$order->o_estimate_price}}元</label>
                @else
                        <label for="o_num" style="color:red;">{{$order->o_final_price}}元</label> ( 含附加费{{$order->o_other_charge}}元 )
                @endif
            </div>
        </div>
    </div>
    @if($othercharge != null)
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-12">
            <div class="col-md-2"><label for="">计费项目：</label></div>
            <div class="col-md-1">过路费</div>
            <div class="col-md-1">停车费</div>
            <div class="col-md-1">钢琴搬运费</div>
            <div class="col-md-1">中途卸装费</div>
            <div class="col-md-1">等待时间费</div>
            <div class="col-md-1">空调移机费</div>
            <div class="col-md-1">1.5~1.8鱼缸</div>
            <div class="col-md-1">贵重物品保险</div>
            <div class="col-md-1">其他费用</div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-12">
            <div class="col-md-2"><label for="">费用详情：</label></div>
            <div class="col-md-1">{{$othercharge->c_road}}元</div>
            <div class="col-md-1">{{$othercharge->c_parking}}元</div>
            <div class="col-md-1">{{$othercharge->c_piano}}元</div>
            <div class="col-md-1">{{$othercharge->c_reload}}元</div>
            <div class="col-md-1">{{$othercharge->c_waiting}}元</div>
            <div class="col-md-1">{{$othercharge->c_kongtiao}}元</div>
            <div class="col-md-1">{{$othercharge->c_yugang1}}元</div>
            <div class="col-md-1">{{$othercharge->c_valuable}}元</div>
            <div class="col-md-1">{{$othercharge->c_other}}元</div>
        </div>
    </div>
    @endif

    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">地点和车辆信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-8">
            <div class="col-md-2">
                <label for="ordernum">起点-终点：</label>
            </div>
            <div class="col-md-10">
                <label for="o_num" style="color:blue;">{{$order->o_begin_poi_address}}</label>　到　<label for="o_num" style="color:blue;">{{$order->o_end_poi_address}}</label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">里程数：</label>
            </div>
            <div class="col-md-8">
                <p style="color:green;">{{$order->o_mileage}}KM</p>
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">套餐：</label>
            </div>
            <div class="col-md-8">
                @if($carinfo != null)
                    <p>{{$carinfo->car_name}}</p>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-4">
                <label for="ordernum">搬运工人数：</label>
            </div>
            <div class="col-md-8">
                <p>{{$order->o_worker_count}}</p>
            </div></div>
        <div class="col-md-4"></div>
    </div>
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">其它信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">跟单客服：</label>
        </div>
        <div class="col-md-4">
            <p>{{$order->customService}}</p>
        </div>
        <div class="col-md-2">
            <label for="ordernum">下单客户端：</label>
        </div>
        <div class="col-md-4">
            <p>{{$order->o_and_state == 1 ? "安卓" : ""}}{{$order->o_ios_state == 1 ? "iOS" : ""}}</p>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">支付途径：</label>
        </div>
        @if($payinfo != null)
        <div class="col-md-4">
            {{$payinfo->p_class}}  [订单编号：<p>{{$payinfo->p_num}}</p>]
        </div>
        @endif
    </div>

    <div class="col-md-12 custom-margin-top-15">
        @if($order->o_state >= 8)
            <div class="col-md-offset-9 col-md-3"><a href="#" class="btn btn-block btn-warning btn-lg disabled">订单已完成</a></div>
        @else
            <div class="col-md-offset-9 col-md-3"><a href="/orders/edit/{{$order->o_num}}" class="btn btn-block btn-success btn-lg">编辑此订单</a></div>
        @endif
    </div>
</div>
@endif
@endsection