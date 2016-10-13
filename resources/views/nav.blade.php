{{--导航栏--}}
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="padding-left: 15px;padding-right: 15px;">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="/">掌上大管家</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li  class="{{ Request::is('/') || Request::is('index') ? "active" : "" }}">
                <a href="/">数据统计</a>
            </li>
            {{--<li class="{{ Request::is('orders') || Request::is('orders/*') ? "active" : "" }}">
                <a href="orders">订单管理</a>
            </li>--}}
            <li class="dropdown {{ Request::is('orders') || Request::is('orders/*') ? "active" : "" }}">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    订单管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/orders">所有订单</a></li>
                    <li><a href="/orders/new">新订单</a></li>
                    <li><a href="/orders/wait">待搬家</a></li>
                    <li><a href="/orders/remove">搬家中</a></li>
                    <li><a href="/orders/unpay">未支付</a></li>
                    <li><a href="/orders/pay">已支付</a></li>
                    <li><a href="/orders/cancel">已取消</a></li>
                </ul>
            </li>
            {{--<li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#">Action</a>
                    </li>
                    <li>
                        <a href="#">Another action</a>
                    </li>
                    <li>
                        <a href="#">Something else here</a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="#">Separated link</a>
                    </li>
                    <li class="divider">
                    </li>
                    <li>
                        <a href="#">One more separated link</a>
                    </li>
                </ul>
            </li>--}}
        </ul>
        {{--<form class="navbar-form navbar-left" role="search">
            <div class="form-group">
                <input type="text" class="form-control" />
            </div> <button type="submit" class="btn btn-default">Submit</button>
        </form>--}}
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">欢迎回来：{{Auth::user()->name}}<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/userprofiles">个人资料</a>
                    </li>
                    <li>
                        <a href="/auth/logout">退出登陆</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>