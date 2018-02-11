<div class="box-body">
    <div class="form-group row {{ $errors->has('portal_id') ? ' has-error' : '' }}">
        {!! Form::label('portal_id','Nama Portal',['class' => 'col-md-3 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::select('portal_id', $portals , null, ['class' => 'form-control select2 select2-hidden-accessible pr-0', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
            @if ($errors->has('portal_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('portal_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="box-body">
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
</div>
<div class="box-body">
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
</div>
<div class="box-body">
    <div class="form-group row {{ $errors->has('default_page') ? ' has-error' : '' }}">
        {!! Form::label('default_page','Defautl Page',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('default_page',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('default_page'))
                <span class="help-block">
                    <strong>{{ $errors->first('default_page') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.box-body -->
<div class="box-footer clearfix pull-right">
    <button type="reset" class="btn btn-default"><i class="mdi mdi-refresh mr-5"></i> Reset</button>
    <button type="submit" class="btn btn-success"><i class="{{ $icon }} mr-5"></i> {{ $textButton }}</button>
</div>
<!-- /.box-footer -->