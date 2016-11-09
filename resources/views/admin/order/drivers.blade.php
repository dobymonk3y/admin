@extends('main')
@section('title','! 大管家管理系统')
@section('content')
@include('partials._message')

<div class="col-md-12 column">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>
                编号
            </th>
            <th>
                产品
            </th>
            <th>
                交付时间
            </th>
            <th>
                状态
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                1
            </td>
            <td>
                TB - Monthly
            </td>
            <td>
                01/04/2012
            </td>
            <td>
                Default
            </td>
        </tr>
        </tbody>
    </table>
</div>

@endsection