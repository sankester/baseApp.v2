@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage.permission.index') }}">Permission</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-12 col-md-12 col-lg-12">
                <!-- Horizontal Form -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Form Edit Permission
                        </h3>
                        <div class="box-controls pull-right">
                            <a class="btn btn-sm btn-default" href="{{ route('manage.permission.index') }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        </div>
                    </div>
                    {{--include notification--}}
                    @include('layouts.notification.base_notification')
                    {{--end include notification--}}
                    <!-- form start -->
                    {!! Form::model($permission ,['method' => 'PATCH','route' => ['manage.permission.update', $permission->id ], 'class' => 'form-horizontal form-element', 'id' => 'edit-permission']) !!}
                    <div class="box-body">
                        <div class="form-group row {{ $errors->has('portal_id') ? ' has-error' : '' }}">
                            {!! Form::label('portal_id','Nama Portal',['class' => 'col-md-3 control-label']) !!}
                            <div class="col-sm-8">
                               <label class="control-label">{{ $permission->portal->portal_nm }}</label>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('permission_nm') ? ' has-error' : '' }}">
                            {!! Form::label('permission_nm','Nama Permission',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('permission_nm',null,['class' => 'form-control ' , 'required' =>'true']) !!}
                                @if ($errors->has('permission_nm'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_nm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('permission_slug') ? ' has-error' : '' }}" >
                            {!! Form::label('permission_slug','Slug Permission',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('permission_slug',null,['class' => 'form-control ' , 'required' =>'true']) !!}
                                @if ($errors->has('permission_slug'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('permission_desc') ? ' has-error' : '' }}" >
                            <label for="permission_desc" class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-9">
                                {!! Form::text('permission_desc',null,['class' => 'form-control ' , 'required' =>'true']) !!}
                                @if ($errors->has('permission_desc'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_desc') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('permission_group') ? ' has-error' : '' }}">
                            {!! Form::label('permission_group','Group Permission',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('permission_group',null,['class' => 'form-control ' , 'required' =>'true']) !!}
                                @if ($errors->has('permission_group'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_group') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('is_assign_menu') ? ' has-error' : '' }}">
                            {!! Form::label('is_assign_menu','Tambahkan ke menu',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::radio('is_assign_menu', 'iya', (isset($selectedMenu)) ? true : false , ['class'=>'radio-col-teal', 'id' => 'is-assign-menu', 'data-url' => route('manage.menu.getlistmenu'), 'data-token' => csrf_token(), 'portal-id' => $permission->portal->id]) !!}
                                <label for="is-assign-menu">Iya</label>
                                {!! Form::radio('is_assign_menu', 'tidak', (!isset($selectedMenu)) ? true : false  , ['class'=>'radio-col-teal', 'id' => 'no-assign-menu', 'data-url' => route('manage.menu.getlistmenu'), 'data-token' => csrf_token(), 'portal-id' => $permission->portal->id]) !!}
                                <label for="no-assign-menu">Tidak</label>
                                @if ($errors->has('is_assign_menu'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_assign_menu') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="form-select-menu">
                            @if( isset($selectedMenu) )
                            <div class="form-group row {{ $errors->has('menu_id') ? ' has-error' : '' }}">
                                {!! Form::label('menu_id','List Menu',['class' => 'col-md-3 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::select('menu_id[]', $listMenu , $selectedMenu, ['class' => 'form-control select2 select2-hidden-accessible pr-0', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true", 'multiple'] ); !!}
                                    @if ($errors->has('menu_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('menu_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix col-md-12">
                        <button type="submit" class="btn btn-success pull-right"><i class="mdi mdi-pencil mr-5"></i> Simpan</button>
                        <button type="reset" class="btn btn-default pull-right mr-10"><i class="mdi mdi-refresh mr-5"></i> Reset</button>
                    </div>
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            // config jquery validator
            $.extend($.validator.messages, {
                required: "tidak boleh kosong.",
                equalTo: 'harus sama.',
                email: 'format email tidak valid.'
            });
            // set function validation
            function setFormValidation(id) {
                $(id).validate({
                    errorPlacement: function (error, element) {
                        $(element).parent().parent('div').addClass('has-error');
                        error.insertAfter(element);
                    }
                });
            }
            // call function validation
            setFormValidation('#edit-permission');
            // init select 2
            $('.select2').select2();
            // init auto complite
            var availableGroup = [
                {!! $groupOutput !!}
            ];
            $( "#permission_group" ).autocomplete({
                lookup : availableGroup
            });
        });
    </script>
@endsection