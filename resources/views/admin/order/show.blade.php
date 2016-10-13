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
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">订单信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">订单编号：</label>
        </div>
        <div class="col-md-10" style="color: green">
            <label for="o_num">R14763335609228</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬家城市：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">北京市</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">客户：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color: green">张三 先生  </label>　　用户名: zhangsan
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">订单状态：</label>
        </div>
        <div class="col-md-10">
            <button class="btn btn-xs btn-warning">待支付</button>
        </div>
    </div><div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">下单时间：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">2016-10-13 15:32:03</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">预约时间：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">2016-10-13 15:32:10</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">电话：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">18001163632</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">备注：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉</label>
        </div>
    </div>
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">价格信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">人工/时间价格(预估):</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color:red;">19999.00元</label>　　3人
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">里程价格：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color:red;">19999.00元</label>　　39.00KM
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">预估总价：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color:red;">19999.00元</label>　　预估总价：387,商家折扣:无折扣
        </div>
    </div>
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">地点和车辆信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">起点-终点：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color:blue;">朝庭公寓（北京市朝阳区阜荣街8号</label>　到　<label for="o_num" style="color:blue;">朝庭公寓（北京市朝阳区阜荣街8号</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">里程数：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num" style="color:green;">39.0KM</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">套餐：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">4.2米厢车</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬运工人数：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">3</label>
        </div>
    </div>
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">其它信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">跟踪客服：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">李四</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">下单客户端：</label>
        </div>
        <div class="col-md-4">
            <label for="o_num">IOS</label>
        </div>
        <div class="col-md-2">
            <label for="ordernum">支付途径：</label>
        </div>
        <div class="col-md-4">
            <label for="o_num">还未生成支付流水</label>
        </div>
    </div>
    <div class="col-md-12 bg-info" style="height: 40px; line-height: 40px;font-size: 16px;">
        <label for="">搬家公司信息</label>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬家公司编号：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">14314012123602 ( 北京大兵搬家服务有限公司 )</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬家车组：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">车牌号：京QH8J78   负责人：王冰   电话：13520884511</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">状态：</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">已接受</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬家状态：	</label>
        </div>
        <div class="col-md-10">
            <label for="o_num">未开始</label>
        </div>
    </div>
    <div class="col-md-12 custom-border-bottom">
        <div class="col-md-2">
            <label for="ordernum">搬家时间记录：</label>
        </div>
        <div class="col-md-2">
            <label for="o_num">搬出开始：</label>2016-10-13 16:06:36
        </div>
        <div class="col-md-2">
            <label for="o_num">搬出结束：</label>2016-10-13 16:06:36
        </div>
        <div class="col-md-2">
            <label for="o_num">搬入开始：</label>2016-10-13 16:06:36
        </div>
        <div class="col-md-2">
            <label for="o_num">搬入结束：</label>2016-10-13 16:06:36
        </div>
    </div>
</div>
@else
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            &times;
        </button>
        <strong>Errors:</strong><p>糟糕, 好像并没有查找到相关的数据! 要不, 找管理员说一下?</p>
    </div>
@endif
@endsection