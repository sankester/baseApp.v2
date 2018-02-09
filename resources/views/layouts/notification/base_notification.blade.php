@if( Session::has('notification'))
    <div class="col-md-12">
        @if(Session::get('notification')['status'] ==  'success')
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('notification')['message'] }}
        </div>
        @endif
        @if(Session::get('notification')['status'] ==  'info')
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('notification')['message'] }}
        </div>
        @endif
        @if(Session::get('notification')['status'] ==  'warning')
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('notification')['message'] }}
        </div>
        @endif
        @if(Session::get('notification')['status'] ==  'danger')
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ Session::get('notification')['message'] }}
        </div>
        @endif
    </div>
@endif