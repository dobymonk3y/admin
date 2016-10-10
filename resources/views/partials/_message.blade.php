
@if(Session::has('loginfaild'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Faild:</strong>{{  Session::get('loginfaild') }}
    </div>
@endif

@if(Session::has('unlogin'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Faild:</strong>{{  Session::get('unlogin') }}
    </div>
@endif