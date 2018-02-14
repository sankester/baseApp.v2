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
            <li class="breadcrumb-item active">Tambah Data</li>
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
                            Form Tambah Permission
                        </h3>
                        <div class="box-controls pull-right">
                            <a class="btn btn-sm btn-default" href="{{ route('manage.permission.index') }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        </div>
                    </div>
                {{--include notification--}}
                @include('layouts.notification.base_notification')
                {{--end include notification--}}
                <!-- form start -->
                    {!! Form::model($permission = new \App\Model\Manage\Permission(),['route' => 'manage.permission.store', 'class' => 'form-horizontal form-element', 'id' => 'tambah-permission']) !!}
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
                        <div class="form-group row {{ $errors->has('permission_type') ? ' has-error' : '' }}">
                            {!! Form::label('permission_type','Tipe Permission',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::radio('permission_type', 'basic', true, ['class'=>'radio-col-teal', 'id' => 'is-resource', 'v-model' => 'permissionType']) !!}
                                <label for="is-resource">Basic</label>
                                {!! Form::radio('permission_type', 'crud', false , ['class'=>'radio-col-teal', 'id' => 'no-resource', 'v-model' => 'permissionType']) !!}
                                <label for="no-resource">Crud</label>
                                @if ($errors->has('permission_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('permission_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('permission_nm') ? ' has-error' : '' }}" v-if="permissionType == 'basic'">
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
                        <div class="form-group row {{ $errors->has('permission_slug') ? ' has-error' : '' }}" v-if="permissionType == 'basic'">
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
                        <div class="form-group row {{ $errors->has('permission_desc') ? ' has-error' : '' }}" v-if="permissionType == 'basic'">
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
                        <div class="form-group row {{ $errors->has('resource') ? ' has-error' : '' }}" v-if="permissionType == 'crud'">
                            {!! Form::label('resource','Resource',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('resource',null,['class' => 'form-control ' , 'required' =>'true', 'v-model'=>"resource"]) !!}
                                @if ($errors->has('resource'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('resource') }}</strong>
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
                        <div class="form-group row" v-if="permissionType == 'crud'">
                            <input type="hidden" name="crud_selected" :value="crudSelected">
                            <label for="permission_desc" class="col-sm-3 control-label" v-if="resource.length >= 3">Permission</label>
                            <div class="col-sm-9" v-if="resource.length >= 3">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::checkbox('crud_checkbox', 'create', false, ['class'=>'chk-col-teal', 'id' => 'create', 'v-model' => 'crudSelected']) !!}
                                        {!! Form::label('create','Create', ['class'=>'mr-10']) !!}
                                        {!! Form::checkbox('crud_checkbox', 'read', false, ['class'=>'chk-col-teal', 'id' => 'read', 'v-model' => 'crudSelected']) !!}
                                        {!! Form::label('create','Read', ['class'=>'mr-10']) !!}
                                        {!! Form::checkbox('crud_checkbox', 'update', false, ['class'=>'chk-col-teal', 'id' => 'update', 'v-model' => 'crudSelected']) !!}
                                        {!! Form::label('update','Ureate', ['class'=>'mr-10']) !!}
                                        {!! Form::checkbox('crud_checkbox', 'delete', false, ['class'=>'chk-col-teal', 'id' => 'delete', 'v-model' => 'crudSelected']) !!}
                                        {!! Form::label('delete','Delete', ['class'=>'mr-10']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table table-striped table-responsive pull-right">
                                            <tbody>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Slug</th>
                                                    <th>Description</th>
                                                </tr>
                                                <tr v-for="item in crudSelected">
                                                    <td v-text="crudName(item)"></td>
                                                    <td v-text="crudSlug(item)"></td>
                                                    <td v-text="crudDescription(item)"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row {{ $errors->has('is_assign_menu') ? ' has-error' : '' }}">
                            {!! Form::label('is_assign_menu','Tambahkan ke menu',['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::radio('is_assign_menu', 'iya', false, ['class'=>'radio-col-teal', 'id' => 'is-assign-menu', 'data-url' => route('manage.menu.getlistmenu'), 'data-token' => csrf_token() ]) !!}
                                <label for="is-assign-menu">Iya</label>
                                {!! Form::radio('is_assign_menu', 'tidak', true, ['class'=>'radio-col-teal', 'id' => 'no-assign-menu', 'data-url' => route('manage.menu.getlistmenu'), 'data-token' => csrf_token()]) !!}
                                <label for="no-assign-menu">Tidak</label>
                                @if ($errors->has('is_assign_menu'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('is_assign_menu') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div id="form-select-menu">

                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix col-md-12">
                        <button type="submit" class="btn btn-success pull-right"><i class="mdi mdi-plus mr-5"></i> Simpan</button>
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
            setFormValidation('#tambah-permission');
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

        var app = new Vue({
            el: '#app',
            data: {
                permissionType: 'basic',
                resource: '',
                crudSelected: ['create', 'read', 'update', 'delete']
            },
            methods: {
                crudName: function(item) {
                    return item.substr(0,1).toUpperCase() + item.substr(1) + " " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
                },
                crudSlug: function(item) {
                    return item.toLowerCase() + "-" + app.resource.toLowerCase();
                },
                crudDescription: function(item) {
                    return "Memperbolehkan user untuk " + item.toUpperCase() + " a " + app.resource.substr(0,1).toUpperCase() + app.resource.substr(1);
                }
            }
        });
    </script>
@endsection