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
            <li class="dropdown {{ Request::is('personnel') || Request::is('personnel/*') ? "active" : "" }}">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    人事管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/personnel">员工资料浏览</a></li>
                    <li><a href="#">人事操作记录</a></li>
                </ul>
            </li>
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
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    个人订单管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">我跟踪的订单</a></li>
                    <li><a href="#">支付查询</a></li>
                    <li><a href="#">纠纷查询</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    退款管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">新退款申请列表</a></li>
                    <li><a href="#">我处理的退款</a></li>
                    <li><a href="#">退款管理</a></li>
                    <li><a href="#">退款记录</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    派单记录
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">派单记录</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    商户管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">搬家公司管理</a></li>
                    <li><a href="#">搬家司机管理</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    优惠券管理
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">搬家公司管理</a></li>
                    <li><a href="#">搬家司机管理</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    报表与日志
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="/log/login">登陆日志</a></li>
                    <li><a href="/log/report">操作记录</a></li>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">欢迎回来：张若愚<strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="/userprofiles">个人资料</a>
                    </li>
                    <li>
                        <a href="/userprofiles">修改密码</a>
                    </li>
                    <li>
                        <a href="/auth/logout">退出登陆</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>