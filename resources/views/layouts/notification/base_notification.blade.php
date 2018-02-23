@if( Session::has('app_notification'))
    <div class="col-md-12">
        <div class="alert alert-{!! Session::get('app_notification')->getType() !!} alert-dismissable">
            @if(!Session::get('app_notification')->isImportant())
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            @endif
            {{ Session::get('app_notification')->getMessage() }}
        </div>
    </div>
@endif