@extends('main')

@section('title','! 大管家管理系统')

@section('content')
    <div class="col-md-12">
        <ol class="breadcrumb">
            <li><a href="/">大管家系统</a></li>
            <li>报表日志</li>
            @if(Request::is('log/login'))
                <li class="active">登陆日志</li>
            @elseif(Request::is('orders/cancel'))
                <li class="active">已取消</li>
            @endif
        </ol>
    </div>
    <div class="col-md-12">
        <div class="col-md-4 "><input class="form-control" type="text" value="123"></div>
        <div class="col-md-4"><input class="form-control" type="text" value="321"></div>
    </div>
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
@endsection