@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')

<div class="row">
    <form action="/orders/drivers/search" method="get">
        <input type="hidden" value="{{$ordernum}}" name="ordernum">
        {{csrf_field()}}
        <div class="col-md-3"></div>
        @if($citys)
        <div class="col-md-1">
            <select class="form-control" name="city" id="city">
                <option value="nocity">请选择城市</option>
                @foreach($citys as $city)
                    <option value="{{$city->c_id}}">{{$city->c_name}}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if($cartypes)
        <div class="col-md-1">
            <select class="form-control" name="cartype" id="cartype">
                <option value="nocartype">请选择车型</option>
            @foreach($cartypes as $cartype)
                <option value="{{$cartype->Id}}">{{$cartype->car_name}}</option>
            @endforeach
            </select>
        </div>
        @endif
        <div class="col-md-1">
            <input type="text" class="form-control" name="mobilenumber" placeholder="请输入手机号码">
        </div>
        <div class="col-md-1">
            <input type="text" class="form-control" name="drivername" placeholder="请输入司机姓名">
        </div>
        <div class="col-md-1">
            <input type="submit" class="btn btn-primary form-control" value="点此查找">
        </div>
        <div class="col-md-1">
            <input type="submit" class="btn btn-success form-control" value="返回前一页" onclick="history.go(-1)">
        </div>
    </form>
</div>

@if($drivers)
    <div class="col-md-8 col-md-offset-2 column">
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="text-center">
                    序号
                </th>
                <th class="text-center">
                    姓名
                </th>
                <th class="text-center">
                    电话
                </th>
                <th class="text-center">
                    车牌号码
                </th>
                <th class="text-center">
                    操作
                </th>
            </tr>
            </thead>
            <tbody class="text-center">
            <?php $num = 1; ?>
            @foreach($drivers as $driver)
                <tr>
                    <td>
                        {{$num+($drivers->currentPage()-1) * 15}}
                    </td>
                    <td>
                        {{$driver->w_name}}
                    </td>
                    <td>
                        {{$driver->w_tel}}
                    </td>
                    <td>
                        {{$driver->w_car_plate}}
                    </td>
                    <td>
                        <a href="/orders/assign?num={{$ordernum}}&mobile={{$driver->w_tel}}" class="btn btn-primary">指派订单给司机</a>
                    </td>
                </tr>
                <?php $num++; ?>
            @endforeach
            </tbody>
        </table>
        <div class="col-md-12 text-center">
            {!! $drivers->render() !!}
        </div>
    </div>
@endif
@endsection