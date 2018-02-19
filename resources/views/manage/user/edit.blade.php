@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>User</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Manajement Akses</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage.user.index') }}">User</a></li>
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
                            Form Edit User
                        </h3>
                        <div class="box-controls pull-right">
                            <a class="btn btn-sm btn-default" href="{{ route('manage.user.index') }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        </div>
                    </div>
                    <div class="box-body wizard-content">
                    {{--include notification--}}
                    @include('layouts.notification.base_notification')
                    {{--end include notification--}}
                    <!-- form start -->
                    {!! Form::model($user ,['method' => 'PATCH','route' => ['manage.user.update', $user->user_login_id ], 'class' => 'validation-wizard wizard-circle','enctype'=>'multipart/form-data', 'id' => 'edit-user']) !!}
                        @include('manage.user.form',['textButton' => 'Simpan', 'icon' => 'mdi mdi-plus'])
                    {!! Form::close() !!}
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            // init auto complite
            var jabatan = [
                {!! $jabatan !!}
            ];
            $( "#jabatan" ).autocomplete({
                lookup : jabatan
            });
        });
    </script>
@endsection