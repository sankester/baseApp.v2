<div class="box-body">
    <div class="form-group row {{ $errors->has('portal_nm') ? ' has-error' : '' }}">
        {!! Form::label('portal_nm','Nama Portal',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('portal_nm',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has('portal_nm'))
                <span class="help-block">
                    <strong>{{ $errors->first('portal_nm') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('site_title') ? ' has-error' : '' }}">
        {!! Form::label('site_title','Judul Situs',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('site_title',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has('site_title'))
                <span class="help-block">
                    <strong>{{ $errors->first('site_title') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('site_name') ? ' has-error' : '' }}">
        {!! Form::label('site_name','Nama Situs',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('site_name',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('site_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('site_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('site_desc') ? ' has-error' : '' }}">
        {!! Form::label('site_desc','Deskripsi Situs',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('site_desc',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('site_desc'))
                <span class="help-block">
                    <strong>{{ $errors->first('site_desc') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('site_favicon') ? ' has-error' : '' }}">
        {!! Form::label('site_favicon','Favicon ',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            @if(! empty($portal->site_favicon))
                <div class="col-md-4 ml-0 pl-0 mb-10">
                    Image saat ini  : <img class="img-responsive" src="{{ asset('images/portal/thumbnail/'.$portal->site_favicon) }}" alt="Card image cap">
                </div>
            @endif
            {!! Form::file('site_favicon',['class' => 'form-control file-styled']) !!}
            @if ($errors->has('site_favicon'))
                <span class="help-block">
                    <strong>{{ $errors->first('site_favicon') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('site_logo') ? ' has-error' : '' }}">
        {!! Form::label('site_logo','Logo ',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            @if(! empty($portal->site_logo))
                <div class="col-md-4 ml-0 pl-0 mb-10">
                    Image saat ini  : <img class="img-responsive" src="{{ asset('images/portal/thumbnail/'.$portal->site_logo) }}" alt="Card image cap">
                </div>
            @endif
            {!! Form::file('site_logo',['class' => 'form-control file-styled']) !!}
            @if ($errors->has('site_logo'))
                <span class="help-block">
                    <strong>{{ $errors->first('site_logo') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('meta_keyword') ? ' has-error' : '' }}">
        {!! Form::label('meta_keyword','Meta Keyword',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('meta_keyword',null,['class' => 'form-control ','required' =>'true']) !!}
            @if ($errors->has('meta_keyword'))
                <span class="help-block">
                    <strong>{{ $errors->first('meta_keyword') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('meta_desc') ? ' has-error' : '' }}">
        {!! Form::label('meta_desc','Meta Deskripsi',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('meta_desc',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('meta_desc'))
                <span class="help-block">
                    <strong>{{ $errors->first('meta_desc') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<!-- /.box-body -->
<div class="box-footer clearfix col-md-12">
    <button type="submit" class="btn btn-success pull-right"><i class="{{ $icon }} mr-5"></i> {{ $textButton }}</button>
    <button type="reset" class="btn btn-default pull-right mr-10"><i class="mdi mdi-refresh mr-5"></i> Reset</button>
</div>
<!-- /.box-footer -->