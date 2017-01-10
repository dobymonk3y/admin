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
    <ol class="breadcrumb">
        <li><a href="/">大管家系统</a></li>
        <li><a href="/orders">订单管理</a></li>
        <li class="active">订单详情 / <a href="/orders/show/{{$order->o_num}}">{{$order->o_num}}</a></li>
        <li><span onclick="history.go(-1)">返回上一页</span></li>
    </ol>
</div>

<div class="col-md-12">
    {{--订单信息开始--}}
    <div class="col-md-12">
        @if($order->o_state > 5 || $order['o_state'] < 0)
            <div class="col-md-1"></div>
        @endif
        @if($order->o_state >= 8 || $order['o_state'] < 0)
            <div class="col-md-offset-9 col-md-1"><a href="#" class="btn btn-block btn-success btn-lg disabled">订单已完成</a></div>
        @else
            <div class="col-md-offset-9 col-md-1"><a href="/orders/edit/{{$order->o_num}}" class="btn btn-block btn-success btn-lg">编辑此订单</a></div>
        @endif
        <div class="col-md-1"><button type="submit" class="btn btn-block btn-info btn-lg" onclick="history.go(-1)">返回上一页</button></div>
        @if($order->o_state <6 && $order['o_state'] >0)
            <div class="col-md-1"><a href="/orders/cancelorder/{{$order->o_num}}" class="btn btn-block btn-lg btn-danger">取消该订单</a></div>
        @endif
    </div>
    <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
        <label for="">订单信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">订单编号：</label>
                <span for="o_num" style="color: green">{{$order->o_num}}</span>
            </div>
            <div class="col-md-6">
                <label for="ordernum">预约时间：</label>
                <span>{{$order->o_remover_date}} {{$order->o_remover_clock}}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">客户：</label>
                <span for="o_num" style="color: green">{{$order->o_linkman}}</span><span>  {{$order->o_user_sex == 1 ? "先生" : "女士"}}</span>
            </div>
            <div class="col-md-6">
                <label for="ordernum">电话：</label>
                <span class="">{{$order->o_linkman_tel}}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6">
                <label>紧急电话</label>：<span>{{$order['o_urgent_tel']}}</span>
            </div>
            <div class="col-md-6">
                <label for="ordernum">订单状态：</label>
                <button class="btn btn-xs btn-warning">{{$order->o_custom_state}}</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">搬家城市：</label>
                <span>{{$order->o_city}}</span>
            </div>
            <div class="col-md-6">
                <label for="ordernum">下单时间：</label>
                <span>{{$order->o_time}}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">跟单客服：</label>
                @if($order->customService != null)
                    <span class='btn btn-xs btn-info'>{{$order->customService}}</span>
                @elseif($order->o_state < 8 && $order['o_state'] > 0)
                <a class="btn btn-xs btn-warning" href="/orders/follow?ordernumber={{$order['o_num']}}">点此跟踪该订单</a>
                @endif
            </div>
            <div class="col-md-6">
                <label for="ordernum">下单客户端：</label>
                <span class="btn btn-xs btn-warning">{{$order->o_and_state == 1 ? "安卓" : ""}}{{$order->o_ios_state == 1 ? "iOS" : ""}}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <label for="ordernum">支付途径：</label>
                @if($payinfo != null)
                    <span class="btn btn-xs btn-info">{{$payinfo->p_class}}</span>  [订单编号：<span>{{$payinfo->p_num}}</span>]
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-12">
            <div class="col-md-12">
                <label for="ordernum">备注：</label>
                <span>{{$order->o_remark}}</span>
            </div>
        </div>
    </div>
    {{--订单信息结束--}}

    {{--价格信息开始--}}
    <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
        <label for="">价格信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">人工/时间价格：</label>

                @if($order->o_state < 7)
                    <span for="o_num" style="color:red;">{{$order->o_start_price}}元</span>
                @else
                    <span for="o_num" style="color:red;">{{$order->o_time_price}}元</span>
                @endif
            </div>
            <div class="col-md-6">
                <label for="ordernum">里程价格：</label>
                <label for="o_num" style="color:red;">{{$order->o_mileage_price != null ? $order->o_mileage_price : "0.00"}}元</label> {{$order->o_mileage_intro}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">特殊时段费：</label>
                <label for="o_num" style="color:red;">{{$order->o_special_time_price != null ? $order->o_special_time_price : "0.00" }}元</label>　{{--{{$order->o_special_time_price_intro}}--}}
            </div>
            <div class="col-md-6">
                <label for="ordernum">总价(无附加费)：</label>
                <label for="o_num" style="color:red;">{{$order->o_price != null ? $order->o_price :"0.00"}}元</label> (无折扣)
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-6">
                <label for="ordernum">折扣价格：</label>
                <label for="o_num" style="color:red;">{{$order->o_activity_price != null ? $order->o_activity_price : $order->o_estimate_price}}元</label>　{{$order->o_activity}} 折(无附加费)
            </div>
            <div class="col-md-6">
                <label for="ordernum">应付金额：</label>
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
    {{--价格信息结束--}}



    <!-- 地图开始 -->
    <div class="col-md-6">
        <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px;border-top-right-radius:5px; border-bottom-right-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
            <label for="">搬家路线</label>
        </div>
        <div id="allmap" class="col-md-12" style="height:535px;"></div>
    </div>
    <!-- 地图结束 -->
    {{--地点和车辆信息开始--}}
    <div class="col-md-6">
        <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px; border-top-right-radius:5px; border-bottom-right-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
            <label for="">地点和车辆信息</label>
        </div>
        <div class="col-md-12">
            <div class="col-md-12 custom-border-bottom">
                <label for="ordernum">起点-终点：</label>
                <label for="o_num" style="color:blue;">{{$order->o_begin_address}}</label>　到　<label for="o_num" style="color:blue;">{{$order->o_end_address}}</label>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <label for="ordernum">里程数：</label>
                <span style="color:green;">{{$order->o_mileage}}KM</span>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <label for="ordernum">套餐：</label>
                @if($carinfo != null)
                    <span>{{$carinfo->car_name}}</span>
                @endif
            </div>
            <div class="col-md-12 custom-border-bottom">
                <label for="ordernum">搬运工人数：</label>
                <span>{{$order->o_worker_count}}</span>
            </div>
        </div>

        <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px; border-top-right-radius:5px; border-bottom-right-radius:5px;height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
            <label for="">搬家公司信息</label>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label for="ordernum">搬家车组：</label>
                </div>
                <div class="col-md-6">
                    <p>车牌号：<span class="btn btn-xs btn-primary">{{$order->o_plate_num}}</span>   负责人：<span class="btn btn-xs btn-primary">{{$order->o_worker_name}}</span></p>
                </div>
                <div class="col-md-3">
                    @if($order->state < 5 && $order->state > 0)
                        <a class="btn btn-info" href="/orders/drivers?num={{$order['o_num']}}">指派订单给司机</a>
                    @endif
                </div>
            </div>

        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label for="ordernum">搬家状态：	</label>
                </div>
                <div class="col-md-3">
                    <p>{{$order->o_remover_state}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-12">
                <div class="col-md-3">
                    <label>评价状态：</label>
                </div>
                <div class="col-md-3">
                    <p>未评价 / 已评价</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-3"><label for="ordernum">搬家时间记录：</label></div>
            <div class="col-md-9"><label for="o_num">搬出开始：</label>{{$order->o_out_begin_time}}</div>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-9 col-md-offset-3"><label for="o_num">搬出结束：</label>{{$order->o_out_end_time}}</div>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-9 col-md-offset-3"><label for="o_num">搬入开始：</label>{{$order->o_in_begin_time}}</div>
        </div>
        <div class="col-md-12 custom-border-bottom">
            <div class="col-md-9 col-md-offset-3"><label for="o_num">搬入结束：</label>{{$order->o_in_end_time}}</div>
        </div>
    </div>
    {{--地点和车辆信息结束--}}



    <div class="accordion" id="accordion-316004">
        <div class="accordion-group">
            <div class="accordion-heading col-md-12 custom-border-bottom" style="border-top-left-radius:5px; border-bottom-left-radius:5px;background-color: #e9e9e9;">
                <div class="accordion-toggle" href="#accordion-element-808479 " data-toggle="collapse" data-parent="#accordion-316004">
                    <label for="">客服跟进记录</label>
                </div>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <form action="/customerrecord/store" method="get" onsubmit="return check()">
                    {{csrf_field()}}
                    <input type="hidden" name="ordernum" value="{{$order->o_num}}">
                    <div class="col-md-11"><input type="text" class="form-control" name="remarkcontent" id="remarkcontent" placeholder="在此输入跟进记录"></div>
                    <div class="col-md-1"><input type="submit"class="btn btn-block btn-primary" value="提交跟进"></div>
                </form>
            </div>
            @if(count($records)>0)
                <div class="accordion-body in" id="accordion-element-808479">
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-1 "><span class="btn btn-xs btn-primary">跟进客服</span></div>
                        <div class="col-md-9 "><span class="btn btn-xs btn-primary">跟进记录</span></div>
                        <div class="col-md-2 "><span class="btn btn-xs btn-primary">跟进时间</span></div>
                    </div>
                    <div class="accordion-inner">
                        @foreach($records as $record)
                            <div class="col-md-12 custom-border-bottom">
                                <div class="col-md-1">{{$record->user_id}}</div>
                                <div class="col-md-9">{{$record->customer_record}}</div>
                                <div class="col-md-2">{{$record->created_at}}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{--跟进记录开始--}}
    @if(count($follows)>0)
    <div class="accordion" id="accordion-316002">
        <div class="accordion-group">
            <div class="accordion-heading col-md-12 custom-border-bottom" style="border-top-left-radius:5px; border-bottom-left-radius:5px;background-color: #e9e9e9;">
                <div class="accordion-toggle" href="#accordion-element-808477 " data-toggle="collapse" data-parent="#accordion-316002">
                    <label for="">订单修改记录</label>
                </div>
            </div>
            <div class="accordion-body in" id="accordion-element-808477">
                <div class="col-md-12 custom-border-bottom">
                    <div class="col-md-1 "><span class="btn btn-xs btn-primary">操作客服</span></div>
                    <div class="col-md-9 "><span class="btn btn-xs btn-primary">操作记录</span></div>
                    <div class="col-md-2 "><span class="btn btn-xs btn-primary">派单时间</span></div>
                </div>
                <div class="accordion-inner">
                @foreach($follows as $follow)
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-1">{{$follow->user_id}}</div>
                        <div class="col-md-9">{{$follow->user_action}}</div>
                        <div class="col-md-2">{{$follow->created_at}}</div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif{{--跟进记录结束--}}

    {{--订单派单记录开始--}}
    @if(count($assignlogs)>0)
    <div class="accordion" id="accordion-316003">
        <div class="accordion-group">
            <div class="accordion-heading col-md-12 bg-pray custom-border-bottom" style="border-top-left-radius:5px; border-bottom-left-radius:5px;">
                <div class="accordion-toggle" href="#accordion-element-808478" data-toggle="collapse" data-parent="#accordion-316003">
                    <label for="">订单指派记录</label>
                </div>
            </div>
            <div class="accordion-body in" id="accordion-element-808478">
                <div class="col-md-12 custom-border-bottom">
                    <div class="col-md-1 "><span class="btn btn-xs btn-primary">操作客服</span></div>
                    <div class="col-md-7 "><span class="btn btn-xs btn-primary">操作记录</span></div>
                    <div class="col-md-2 "><span class="btn btn-xs btn-primary">搬家公司</span></div>
                    <div class="col-md-2 "><span class="btn btn-xs btn-primary">派单时间</span></div>
                </div>
                <div class="accordion-inner">
                @foreach($assignlogs as $log)
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-1">{{$log->o_user}}</div>
                        <div class="col-md-7">{{$log->o_action}}</div>
                        <div class="col-md-2">{{$log->o_remover_name}}</div>
                        <div class="col-md-2">{{date('Y-m-d H:i:s',$log->o_time)}}</div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif{{--订单派单记录结束--}}
    
    <input type="hidden" id="start1" value="{{$order->start1}}">
    <input type="hidden" id="start2" value="{{$order->start2}}">
    <input type="hidden" id="end1" value="{{$order->end1}}">
    <input type="hidden" id="end2" value="{{$order->end2}}">
    @endif
    <script type="text/javascript">

        var map = new BMap.Map("allmap");
        map.centerAndZoom(new BMap.Point(116.404, 39.915), 11);
        map.addControl(new BMap.NavigationControl());               // 添加平移缩放控件
        map.addControl(new BMap.ScaleControl());                    // 添加比例尺控件
        map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
        map.enableScrollWheelZoom();                            //启用滚轮放大缩小
        map.addControl(new BMap.MapTypeControl());          //添加地图类型控件
        map.disable3DBuilding();
        var start1 = document.getElementById('start1').value;
        var start2 = document.getElementById('start2').value;
        var end1 = document.getElementById('end1').value;
        var end2 = document.getElementById('end2').value;
        var p1 = new BMap.Point(start1,start2);
        var p2 = new BMap.Point(end1,end2);
        var driving = new BMap.DrivingRoute(map, {renderOptions:{map: map, autoViewport: true}});
        driving.search(p1, p2);

        changeMapStyle('grayscale');
        function changeMapStyle(style){
            map.setMapStyle({style:style});
            $('#desc').html(mapstyles[style].desc);
        }

        function check() {
            var remarkcontent = document.getElementById('remarkcontent').value;
            if(remarkcontent == null ||remarkcontent == ''){
                alert('跟进内容不能为空，请填写跟进记录！');
                return false;
            }
        }
    </script>
@endsection