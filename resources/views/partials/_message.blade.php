
@if(Session::has('loginfaild'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Faild:</strong>{{  Session::get('loginfaild') }}
    </div>
@endif

@if(Session::has('logout'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('logout') }}
    </div>
@endif