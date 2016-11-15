@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')

<div class="row">
    <form action="/orders/drivers/search" method="get">
        {{csrf_field()}}
        <div class="col-md-2 col-md-offset-5">
            <div class="input-group">
                <input type="text" class="form-control" name="mobilenumber" placeholder="请输入手机号码">
                <input type="hidden" value="{{$ordernum}}" name="ordernum">
                <span class="input-group-btn">
                    <button class="btn btn-info" type="submit">Search</button>
                </span>
            </div>
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