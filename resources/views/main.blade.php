<!DOCTYPE html>
<html>
<head>
@include('head')
</head>
<body>

{{--主页公共部分--}}
@include('nav')

<div class="container-custom">
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="row clearfix">
                <div class="col-md-1 column custom-border">
                    <ul class="nav nav-pills nav-stacked">
                        <li class="{{ Request::is('/') ? "active" : "" }}" ><a href="">Home</a></li>
                        <li class="{{ Request::is('/1') ? "active" : "" }}" ><a href="#">SVN</a></li>
                        <li class="{{ Request::is('/2') ? "active" : "" }}" ><a href="#">iOS</a></li>
                        <li class="{{ Request::is('/3') ? "active" : "" }}" ><a href="#">VB.Net</a></li>
                        <li class="{{ Request::is('/4') ? "active" : "" }}" ><a href="#">Java</a></li>
                        <li class="{{ Request::is('/5') ? "active" : "" }}" ><a href="#">PHP</a></li>
                    </ul>
                </div>
                <div class="col-md-11 column">
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