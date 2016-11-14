@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')
{{--
    <div class="row">
        <form action="/orders/drivers/search" method="get">
            {{csrf_field()}}
            <div class="col-md-2 col-md-offset-5">
                <div class="input-group">
                    <input type="text" class="form-control" name="mobilenumber" placeholder="请输入手机号码">
                    <input type="hidden" value="{{$ordernum}}" name="num">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Search</button>
                </span>
                </div>
            </div>
        </form>
    </div>--}}
    @if($drivers)
        <div class="col-md-12 column">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>
                        序号
                    </th>
                    <th>
                        姓名
                    </th>
                    <th>
                        电话
                    </th>
                    <th>
                        车牌号码
                    </th>
                    <th>
                        操作
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php $num = 1; ?>
                @foreach($drivers as $driver)
                    <tr>
                        <td>
                            {{$num}}
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
                            <a href="/test?num={{$ordernum}}&mobile={{$driver->w_tel}}" class="btn btn-primary">按钮</a>
                        </td>
                    </tr>
                    <?php $num++; ?>
                @endforeach
                </tbody>
            </table>
            {!! $drivers->appends(['mobilenumber' => $mobile,'num' => $ordernum ])->render() !!}
        </div>
    @endif
@endsection