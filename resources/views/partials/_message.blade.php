
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

@if(Session::has('logout'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('logout') }}
    </div>
@endif

@if(Session::has('noordernum'))
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Error:</strong>{{  Session::get('noordernum') }}
    </div>
@endif

@if(Session::has('followSuccess'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('followSuccess') }}
    </div>
@endif

@if(Session::has('updateSuccess'))
    <div class="alert alert-success alert-dismissable">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('updateSuccess') }}
    </div>
@endif