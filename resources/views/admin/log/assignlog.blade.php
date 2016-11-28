@extends('main')

@section('title','! 大管家管理系统')

@section('content')

<div class="col-md-12">
    <ol class="breadcrumb">
        <li><a href="/">大管家系统</a></li>
        <li>报表与日志</li>
        @if(Request::is('log/login'))
            <li class="active"><a href="/log/login">系统登录日志</a></li>
        @elseif(Request::is('log/mylogin'))
            <li class="active"><a href="/log/mylogin">个人登录日志</a></li>
        @elseif(Request::is('log/assign'))
            <li class="active"><a href="/log/assign">客服派单记录</a></li>
        @endif
    </ol>
</div>
<div class="container col-md-12">
    <div class="col-md-12 column">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>
                    序号
                </th>
                <th>
                    订单编号
                </th>
                <th>
                    派单时间
                </th>
                <th>
                    操作客服
                </th>
                <th>
                    操作记录
                </th>
                <th>
                    搬家公司
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $num = 1; ?>
            @foreach($assignlogs as $log)
            <tr>
                <td>
                    {{$num+($assignlogs->currentPage()-1)*15}}
                </td>
                <td>
                    {{$log->o_num}}
                </td>
                <td>
                    {{date('Y-m-d H:i:s',$log->o_time)}}
                </td>
                <td>
                    {{$log->o_user}}
                </td>
                <td>
                    {{$log->o_action}}
                </td>
                <td>
                    {{$log->o_remover_name}}
                </td>
            </tr>
            <?php $num++;?>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12 text-center">{!! $assignlogs->render() !!}</div>
</div>

@endsection