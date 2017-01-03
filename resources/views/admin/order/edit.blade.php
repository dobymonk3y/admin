@extends('main')

@section('title','! 大管家管理系统')

@section('content')

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
            <li class="active">编辑订单 / <span>{{$order->o_num}}</span></li>
            <li><span onclick="history.go(-1)">返回上一页</span></li>
        </ol>
    </div>

    <form action="/orders/update/{{$order->o_num}}" method="post">
        {{csrf_field()}}
        <div class="col-md-12">
            <div class="col-md-12 bg-pray" style="height: 40px; line-height: 40px;font-size: 16px;border-top-left-radius:5px; border-bottom-left-radius:5px;">
                <label for="">订单信息</label>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-2">
                    <label for="ordernum">订单编号：</label>
                </div>
                <div class="col-md-4" style="color: green">
                    <label for="o_num">{{$order->o_num}}</label>
                </div>
                <div class="col-md-2">
                    <label for="ordernum">搬家城市：</label>
                </div>
                <div class="col-md-4">
                    <label for="o_num">{{$order->o_city}}</label>
                </div>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-2">
                    <label for="ordernum">客户：</label>
                </div>
                <div class="col-md-4">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="o_linkman" name="o_linkman" value="{{$order->o_linkman}}">
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="o_user_sex" name="o_user_sex">
                            <option value="1" {{$order->o_user_sex == 1 ? "selected" : ""}}>先生</option>
                            <option value="2" {{$order->o_user_sex == 2 ? "selected" : ""}}>女士</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="o_num" style="color: green">用户名: {{$order->o_user}}</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="ordernum">订单状态：</label>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-xs btn-warning">{{$order->o_custom_state}}</button>
                    {{--<select name="orderstatus" id="orderstatus" class="form-control">
                        <option value="1" {{$order->o_state == 1? "selected='selected'" : ''}}>新订单</option>
                        <option value="2" {{$order->o_state == 2? "selected='selected'" : ''}}>待确认</option>
                        <option value="3" {{$order->o_state == 3? "selected='selected'" : ''}}>已接受</option>
                        <option value="4" {{$order->o_state == 4? "selected='selected'" : ''}}>已确认</option>
                        <option value="5" {{$order->o_state == 5? "selected='selected'" : ''}}>已出发</option>
                        <option value="6" {{$order->o_state == 6? "selected='selected'" : ''}}>搬家中</option>
                        <option value="7" {{$order->o_state == 7? "selected='selected'" : ''}}>未支付</option>
                        <option value="8" {{$order->o_state == 8? "selected='selected'" : ''}}>已支付</option>
                        <option value="9" {{$order->o_state == 9? "selected='selected'" : ''}}>已结束</option>
                    </select>--}}
                </div>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-2">
                    <label for="ordernum">下单时间：</label>
                </div>
                <div class="col-md-4">
                    <label for="o_num">{{$order->o_time}}</label>
                </div>
                <div class="col-md-2">
                    <label for="ordernum">预约时间：</label>
                </div>
                <div class="col-md-4">
                    <div class="col-md-4">
                        <div class="layui-inline">
                            <input class="form_datetime form-control" size="16" type="text" id="removetime" name="removetime" value="{{$order->removetime}}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="timewarning" style="color: red;"> * 请选择当前时间3小时后的预定时间</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-2">
                    <label for="ordernum">电话：</label>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="o_linkman_tel" value="{{$order->o_linkman_tel}}">
                </div>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-2">
                    <label for="ordernum">备注：</label>
                </div>
                <div class="col-md-10">
                    <input type="text" class="form-control" name="o_remark" value="{{$order->o_remark}}">
                </div>
            </div>
            {{--价格信息开始--}}
            <div class="col-md-12 bg-pray" style="height: 40px; line-height: 40px;font-size: 16px;border-top-left-radius:5px; border-bottom-left-radius:5px;">
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
                        <label for="o_num" style="color:red;">{{$order->o_special_time_price != null ? $order->o_special_time_price : "0.00" }}元</label>{{--　{{$order->o_special_time_price_intro}}--}}
                    </div>
                    <div class="col-md-6">
                        <label for="ordernum">总价(无附加费)：</label>
                        <label for="o_num" style="color:red;">{{$order->o_price != null ? $order->o_price :"0.00"}}元</label> (无折扣)
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="ordernum">折扣价格：</label>
                        </div>
                        <div class="col-md-7">
                            @if($order->o_state == 7)
                            <input type="text" class="form-control" id="activityprice" name="activityprice" onblur="javascript:CheckInputIntFloat(this)" value="{{$order->o_activity_price != null ? $order->o_activity_price : $order->o_estimate_price}}">
                            @else
                            <span>{{$order->o_activity_price != null ? $order->o_activity_price : $order->o_estimate_price}}</span>
                            <input type="hidden" id="activityprice" name="activityprice" onblur="javascript:CheckInputIntFloat(this)" value="{{$order->o_activity_price != null ? $order->o_activity_price : $order->o_estimate_price}}">
                            @endif
                        </div>
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
            {{--地点和车辆信息开始--}}
            <div class="col-md-6">
                <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px; border-top-right-radius:5px; border-bottom-right-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
                    <label for="">地点和车辆信息</label>
                </div>
                <div class="col-md-12">
                    @if($order->o_state <4 && $order->o_state >0)
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-2">
                            <label for="ordernum">起点-终点：</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="startpoi" class="form-control" onblur="searchStartPoi()" value="{{$order->o_begin_poi_address}}" placeholder="{{$order->o_begin_poi_address}}">
                            <input type="hidden" class="form-control" value="" id="beginAddressPoi">
                        </div>
                        <div class="col-md-1"><span>到</span></div>
                        <div class="col-md-4">
                            <input type="text" id="endpoi" class="form-control"  onblur="searchEndPoi()" value="{{$order->o_end_poi_address}}" placeholder="{{$order->o_end_poi_address}}">
                            <input type="hidden" class="form-control" value="" id="endAddressPoi">
                        </div>
                    </div>
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-2">
                            <label for="ordernum">里程数：</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="mileage" value="{{$order->o_mileage}}">
                        </div>
                    </div>
                    @else
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-2">
                            <label for="ordernum">起点-终点：</label>
                        </div>
                        <div class="col-md-4">
                            <span>{{$order->o_begin_poi_address}}</span>
                        </div>
                        <div class="col-md-1"><span>到</span></div>
                        <div class="col-md-4">
                            <span>{{$order->o_end_poi_address}}</span>
                        </div>
                    </div>
                    <div class="col-md-12 custom-border-bottom">
                        <div class="col-md-2">
                            <label for="ordernum">里程数：</label>
                        </div>
                        <div class="col-md-2">
                            <span>{{$order->o_mileage}} KM</span>
                        </div>
                    </div>
                    @endif
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
                            <p>车牌号：{{$order->o_plate_num}}   负责人：{{$order->o_worker_name}}</p>
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
                            <p>评价状态：</p>
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

            <!-- 地图开始 -->
            <div class="col-md-6">
                <div class="col-md-12" style="border-top-left-radius:5px; border-bottom-left-radius:5px;border-top-right-radius:5px; border-bottom-right-radius:5px; height: 40px;line-height: 36px;margin-top: 10px;background-color: #e9e9e9;">
                    <label for="">搬家路线</label>
                </div>
                <div id="allmap" class="col-md-12" style="height:535px;"></div>
            </div>
            <!-- 地图结束 -->

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

            <div class="col-md-12 bg-pray" style="height: 40px; line-height: 40px;font-size: 16px;border-top-left-radius:5px; border-bottom-left-radius:5px;">
                <label for="">其它信息</label>
            </div>
            <div class="col-md-12 custom-border-bottom">
                <div class="col-md-4">
                    <div class="col-md-4">
                        <label for="ordernum">跟踪客服：</label>
                    </div>
                    <div class=2"col-md-8">
                        @if($order->customService != '')
                            <label for="o_num">{{$order->customService}}</label>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-4">
                        <label for="ordernum">下单客户端：</label>
                    </div>
                    <div class="col-md-8">
                        <label  for="o_num">{{$order->o_and_state == 1 ? "" : "安卓"}}{{$order->o_ios_state == 1 ? "iOS" : ""}}</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-4">
                        <label for="ordernum">支付途径：</label>
                    </div>
                    @if($payinfo != null)
                        <div class="col-md-8">
                            {{$payinfo->p_class}}  [订单编号：<label for="o_num">{{$payinfo->p_num}}</label>]
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-4 col-md-offset-8 custom-margin-top-15">
                @if($order->o_state < 8 )
                    <div class="col-md-4"><button type="submit" class="btn btn-block btn-success btn-lg">提交修改</button></div>
                    <div class="col-md-4"><a href="/orders/show/{{$order->o_num}}" class="btn btn-block btn-warning btn-lg">撤销修改</a></div>
                    <div class="col-md-4"><button type="submit" class="btn btn-block btn-info btn-lg" onclick="history.go(-1)">返回上一页</button></div>
                @else
                    <div class="col-md-4 col-md-offset-6"><a class="btn btn-block btn-warning btn-lg disabled">订单已完成</a></div>
                @endif
            </div>
        </div>
    </form>
    <!-- startPositionModal start -->
    <div class="modal fade" id="startPositionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div id="l-map"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- startPositionModal end -->
    @endif
    <input type="hidden" id="start1" value="{{$order->start1}}">
    <input type="hidden" id="start2" value="{{$order->start2}}">
    <input type="hidden" id="end1" value="{{$order->end1}}">
    <input type="hidden" id="end2" value="{{$order->end2}}">
<script type="text/javascript">


    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

    function CheckInputIntFloat(oInput)
    {
        var num = document.getElementById("activityprice").value;
        if (num==""){
            alert("请输入折扣后价格");return false;
        }
        if(num < 0 ){
            alert("请输入正确的价格");return false;
        }
        if (!(/(^[1-9]\d*$)/).test(num) && !(/(^(-?\d+)(\.\d+)?$)/).test(num) ){
            alert("请输入正确的价格");return false;
        }
    }

    function check() {
        var remarkcontent = document.getElementById('remarkcontent').value;
        if(remarkcontent == null ||remarkcontent == ''){
            alert('跟进内容不能为空，请填写跟进记录！');
            return false;
        }
    }
</script>
<script>
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
    var startaddress = document.getElementById('startpoi').value;
    var endaddress = document.getElementById('endpoi').value;
    var driving = new BMap.DrivingRoute(map, {renderOptions: {map: map}});
    driving.search(p1, p2);

    changeMapStyle('grayscale');
    function changeMapStyle(style){
        map.setMapStyle({style:style});
        $('#desc').html(mapstyles[style].desc);
    }

    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
            {"input" : "startpoi"
                ,"location" : map
            });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("startpoi").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("startpoi").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
            onSearchComplete: myFun
        });
        local.search(myValue);
        var poi = searchResult.getPoi(0);
        document.getElementById("result_").value = p;
    }

    // 百度地图API功能
    function E(id) {
        return document.getElementById(id);
    }

    var ep = new BMap.Autocomplete(    //建立一个自动完成的对象
            {"input" : "endpoi"
                ,"location" : map
            });

    ep.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        E("endpoi").innerHTML = str;
    });

    var endValue;
    ep.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        endValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        E("endpoi").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + endValue;
        setEndPlace();
    });

    function setEndPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function endPoi(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
            onSearchComplete: endPoi
        });
        local.search(endValue);
    }

    var localSearch = new BMap.LocalSearch(map);
    function searchStartPoi() {
        var keyword = document.getElementById("startpoi").value;
        localSearch.setSearchCompleteCallback(function (searchResult) {
            var poi = searchResult.getPoi(0);
            document.getElementById('beginAddressPoi').value = poi.point.lng + "," + poi.point.lat;
            document.getElementById('start1').value = poi.point.lng;
            document.getElementById('start2').value = poi.point.lat;
            var end1 = document.getElementById('end1').value;
            var end2 = document.getElementById('end2').value;
            var start = new BMap.Point(poi.point.lng,poi.point.lat);
            var end = new BMap.Point(end1,end2);
            var mile = '';
            var searchComplete = function (results){
                if (driving.getStatus() != BMAP_STATUS_SUCCESS){
                    return ;
                }
                var plan = results.getPlan(0);
                mile = plan.getDistance(true);
                document.getElementById('mileage').value = mile;
            }
            var driving = new BMap.DrivingRoute(map, {renderOptions: {map: map},onSearchComplete: searchComplete});
            driving.search(start, end);
        });
        localSearch.search(keyword);
    }
    function searchEndPoi() {
        var keyword = document.getElementById("endpoi").value;
        localSearch.setSearchCompleteCallback(function (searchResult) {
            var poi = searchResult.getPoi(0);
            document.getElementById('endAddressPoi').value = poi.point.lng + "," + poi.point.lat;
            document.getElementById('end1').value = poi.point.lng;
            document.getElementById('end2').value = poi.point.lat;
            var start1 = document.getElementById('start1').value;
            var start2 = document.getElementById('start2').value;
            var p1 = new BMap.Point(start1,start2);
            var p2 = new BMap.Point(poi.point.lng,poi.point.lat);
            var mile = '';
            var searchComplete = function (results){
                if (routing.getStatus() != BMAP_STATUS_SUCCESS){
                    return ;
                }
                var plan = results.getPlan(0);
                mile = plan.getDistance(true);
                document.getElementById('mileage').value = mile;
            }
            var routing = new BMap.DrivingRoute(map, {renderOptions: {map: map},onSearchComplete: searchComplete});
            routing.search(p1, p2);
        });
        localSearch.search(keyword);
    }
</script>
@endsection
