<!DOCTYPE html>
<html>
<head>
@include('head')
</head>
<body style="font-family:Microsoft YaHei;">

{{--主页公共部分--}}
@include('nav')

<div class="container-custom">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row clearfix">
                {{--左侧导航--}}
                {{--<div class="col-md-1 column custom-border">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="{{ Request::is('/') || Request::is('index') ? "active" : "" }}" ><a href="/index">数据统计</a></li>
                        <li class="{{ Request::is('orders') || Request::is('orders/*') ? "active" : "" }}" ><a href="/orders">订单管理</a></li>
                    </ul>
                </div>--}}
                <div class="col-md-12 column">
                    {{--<div class="col-md-12 column custom-border">
                        @yield('content')
                    </div>--}}
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

@include('foot')

</body>
</html>