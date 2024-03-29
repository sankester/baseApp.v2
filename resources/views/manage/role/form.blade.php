<!-- Step 1 -->
<h6>Role Data</h6>
<section>
    <div class="form-group row {{ $errors->has('portal_id') ? ' has-error' : '' }}">
        {!! Form::label('portal_id','Nama Portal',['class' => 'col-md-3 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('portal_id', $listPortal , null, ['class' => 'form-control select2 select2-hidden-accessible pr-0', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true", 'data-url' => route('manage.menu.getlistmenu'), 'data-url-permission' => route('manage.role.getPermission'),'data-token' => csrf_token() ] ); !!}
            @if ($errors->has('portal_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('portal_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('role_nm') ? ' has-error' : '' }}">
        {!! Form::label('role_nm','Nama Role',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('role_nm',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has('role_nm'))
                <span class="help-block">
                    <strong>{{ $errors->first('role_nm') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('role_desc') ? ' has-error' : '' }}">
        {!! Form::label('role_desc','Deskripsi Role',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('role_desc',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('role_desc'))
                <span class="help-block">
                    <strong>{{ $errors->first('role_desc') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('default_page') ? ' has-error' : '' }}">
        {!! Form::label('default_page','Default Page',['class' => 'col-md-3 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('default_page', $listMenu , null, ['class' => 'form-control select2 select2-hidden-accessible pr-0', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
            @if ($errors->has('default_page'))
                <span class="help-block">
                    <strong>{{ $errors->first('default_page') }}</strong>
                </span>
            @endif
        </div>
    </div>
</section>
<!-- Step 2 -->
<h6>Role Permission</h6>
<section>
    <div class="row" id="list-permission">
        <table class="table table-responsive">
            <tbody>
            <tr>
                <th width="5%" class="text-center">
                    <div class="checkbox">
                        <input type="checkbox" id="checked-all-menu" class="chk-col-green checked-all-menu">
                        <label for="checked-all-menu"></label>
                    </div>
                </th>
                <th width="20%" class="text-center">Menu</th>
                <th width="80%" class="text-center">Permission</th>
            </tr>
            {!!  $permissionMenuHtml !!}
            </tbody>
        </table>
    </div>
</section>