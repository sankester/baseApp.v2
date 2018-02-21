<div class="box-body">
    <div class="form-group row {{ $errors->has('pref_group') ? ' has-error' : '' }}">
        {!! Form::label('pref_group','Group Preference',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pref_group',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has('pref_group'))
                <span class="help-block">
                    <strong>{{ $errors->first('pref_group') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('pref_name') ? ' has-error' : '' }}">
        {!! Form::label('pref_name','Nama Preference',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pref_name',null,['class' => 'form-control ' , 'required' =>'true']) !!}
            @if ($errors->has(''))
                <span class="help-block">
                    <strong>{{ $errors->first('pref_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row {{ $errors->has('pref_value') ? ' has-error' : '' }}">
        {!! Form::label('pref_value','Isi Preference',['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-9">
            {!! Form::text('pref_value',null,['class' => 'form-control ' ,'required' =>'true']) !!}
            @if ($errors->has('pref_value'))
                <span class="help-block">
                    <strong>{{ $errors->first('pref_value') }}</strong>
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