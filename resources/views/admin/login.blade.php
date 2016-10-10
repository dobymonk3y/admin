@extends('main')

@section('content')
    <div class="container" id="logindev">
        <div class="row clearfix">
            <div class="col-md-3 column">
            </div>
            <div class="col-md-6 column">
                @include('partials._message')
                <h3 class="text-center">
                    霖德科技 &copy; 掌上大管家管理平台
                </h3>
                <form class="form-horizontal" role="form" method="post" action="login">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="account" class="col-sm-2 control-label">Account</label>
                        <div class="col-sm-10">
                            <input type="name" class="form-control" id="name" name="name"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success btn-block btn-lg">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3 column">
            </div>
        </div>
    </div>
@endsection