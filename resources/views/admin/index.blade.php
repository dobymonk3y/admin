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

<div class="col-md-12 column custom-border">
    {{--<div style="background-color: #337ab6;color: white;padding: 8px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
        <label>订单编号:R123456789012345678</label>
    </div>
    <div style="background-color: white;padding: 8px;border-bottom: gray 1px solid;border-left: gray 1px solid;border-right: gray 1px solid;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px;">

    </div>--}}
    <table class="table">
        <thead style="background-color: #337ab6;color:white;">
        <th>订单编号：R1234567890</th>
        <th>服务城市：北京</th>
        <th>预约搬家时间：2016-10-10 16:35:35</th>
        <th>订单状态：<label class="btn btn-info btn-xs">待支付</label></th>
        <th>订单性质：<label class="btn btn-warning btn-xs">指派</label></th>
        </thead>
        <tbody>
            <tr>
                <td>
                    客户姓名：张若愚
                </td>
                <td>
                    联系电话：18001163632
                </td>
                <td>
                    紧急电话：18001163632
                </td>
                <td>
                    订单起点：新潮嘉园三期
                </td>
                <td>
                    订单终点：物资学院新建村
                </td>
            </tr>
            <tr>
                <td>
                    订单里程：9.3km
                </td>
                <td>
                    里程价格：88.0元
                </td>
                <td>
                    人工价格(4人)：512元
                </td>
                <td>
                    预估总价：600元
                </td>
                <td>
                    实际支付金额：512元
                </td>
            </tr>
            <tr>
                <td>
                    订单司机：张全蛋（18513603626）
                </td>
                <td>
                    提交订单时间:2016-10-10 17:07:07
                </td>
                <td>
                    搬家开始时间：2016-10-10 16:40:28
                </td>
                <td>
                    支付订单时间：2016-10-10 16:35:53
                </td>
                <td>
                    跟单客服：<label class="btn btn-info">张若愚</label>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="word-wrap:break-word;word-break:break-all;">
                    备注信息：巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉巴拉
                </td>
                <td></td>
                <td style="text-align: center">
                    <a class="btn btn-primary">详情</a>
                    <a class="btn btn-primary">编辑</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endsection