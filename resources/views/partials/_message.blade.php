
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
    <div class="alert alert-success alert-dismissable" id="updateSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('updateSuccess') }}
    </div>
@endif

@if(Session::has('changePwdFaild'))
    <div class="alert alert-warning alert-dismissable" id="updateSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Faild:</strong>{{  Session::get('changePwdFaild') }}
    </div>
@endif

@if(Session::has('changePwdSuccess'))
    <div class="alert alert-success alert-dismissable" id="updateSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('changePwdSuccess') }}
    </div>
@endif

@if(Session::has('orderAssignSuccess'))
    <div class="alert alert-success alert-dismissable" id="orderAssignSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('orderAssignSuccess') }}
    </div>
@endif

@if(Session::has('orderUpdataSuccess'))
    <div class="alert alert-success alert-dismissable" id="orderUpdataSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('orderUpdataSuccess') }}
    </div>
@endif

@if(Session::has('customerRecordAddSuccess'))
    <div class="alert alert-success alert-dismissable" id="customerRecordAddSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('customerRecordAddSuccess') }}
    </div>
@endif

@if(Session::has('customerRecordAddFail'))
    <div class="alert alert-danger alert-dismissable" id="customerRecordAddFail">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Faild:</strong>{{  Session::get('customerRecordAddFail') }}
    </div>
@endif

@if(Session::has('orderCancelSuccess'))
    <div class="alert alert-success alert-dismissable" id="orderCancelSuccess">
        <button type="button" class="close" data-dismiss="alert"
                aria-hidden="true">
            &times;
        </button>
        <strong>Success:</strong>{{  Session::get('orderCancelSuccess') }}
    </div>
@endif




@if(isset($orders) && count($orders) == 0)
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissable" id="emptySearch">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                &times;
            </button>
            <strong>Errors:</strong><p>糟糕, 好像并没有查找到相关的数据! 要不, 看看别的?</p>
        </div>
    </div>
@endif