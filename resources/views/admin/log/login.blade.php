@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    <div class="col-md-12" id="namenotice" style="display: none;">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>出错啦！</strong>搜索的姓名不能为空，请输入要搜索的用户姓名。
        </div>
    </div>
    <div class="col-md-12" id="timestartnotice" style="display: none;">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>出错啦！</strong>是不是起始时间没选定呢？要不你再检查一下？
        </div>
    </div>
    <div class="col-md-12" id="timeendnotice" style="display: none;">
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <strong>出错啦！</strong>是不是结束时间没选定呢？要不你再检查一下？
        </div>
    </div>
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            <li>报表与日志</li>
            @if(Request::is('log/login'))
                <li class="active">系统登录日志</li>
            @elseif(Request::is('log/mylogin'))
                <li class="active">个人登录日志</li>
            @elseif(Request::is('orders/cancel'))
                <li class="active">已取消</li>
            @endif
        </ol>
    </div>
    @if(Request::is('log/login'))
    <div class="col-md-12">
        <div class="col-md-2 ">
            <input class="form-control" type="text" id="username" name="username" placeholder="请输入用户姓名( 非帐号 )">
        </div>
        <div class="col-md-3">
            <div class="col-md-6">
                <div class="layui-inline">
                    <input class="form-control" placeholder="选择起始时间" id="timestart" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})">
                </div>
            </div>
            <div class="col-md-6">
                <div class="layui-inline">
                    <input class="form-control" placeholder="选择结束时间" id="timeend" onclick="layui.laydate({elem: this, istime: false, format: 'YYYY-MM-DD hh:mm',  istoday: false,festival: true,issure: true})">
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary" name="searchlog" id="searchLog" onclick="searchLog()">搜索记录</button>
        </div>
    </div>
    @endif
    <div class="col-md-12 custom-margin-top-15">
        <table class="table table-hover">
            <thead class="bg-primary">
            <tr>
                <th>
                    ID
                </th>
                <th>
                    登陆用户
                </th>
                <th>
                    登陆用户名
                </th>
                <th>
                    登陆时间
                </th>
                <th>
                    登陆IP
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($logins as $login)
            <tr>
                <td>
                    {{$login->Id}}
                </td>
                <td>
                    {{$login->act_people}}
                </td>
                <td>
                    {{$login->act_people_id}}
                </td>
                <td>
                    {{date("Y-m-d H:i:s",$login->act_time)}}
                </td>
                <td>
                    {{$login->act_loginip}}
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div class="col-md-12 text-center">{!! $logins->render() !!}</div>
    </div>
    <script>
        function searchLog(){
            try{
                var username = document.getElementById('username').value;
                var timestart = document.getElementById('timestart').value;
                var timeend = document.getElementById('timeend').value;
                if(username == ''){
                    document.getElementById("namenotice").style.display ="block";
                    return;
                }
                if(timestart == ''){
                    document.getElementById("timestartnotice").style.display ="block";
                    return;
                }
                if(timeend == ''){
                    document.getElementById("timeendnotice").style.display ="block";
                    return;
                }
                $.ajax({
                    type: 'GET',
                    url: '/test',
                    data: { username:username, timestart:timestart,timeend:timeend},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        console.log(data.data);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }
                });
            }catch(err){
                alert(err);
            }
        }
    </script>
@endsection