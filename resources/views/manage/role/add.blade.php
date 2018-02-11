@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Role
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage.role.index') }}">Role</a></li>
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
                            Form Tambah Role
                        </h3>
                        <div class="box-controls pull-right">
                            <a class="btn btn-sm btn-default" href="{{ route('manage.role.index') }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        </div>
                    </div>
                    {{--include notification--}}
                    @include('layouts.notification.base_notification')
                    {{--end include notification--}}
                    <!-- form start -->
                    {!! Form::model($portal = new \App\Model\Manage\Role(),['route' => 'manage.role.store', 'class' => 'form-horizontal form-element','enctype'=>"multipart/form-data", 'id' => 'tambah-role']) !!}
                        @include('manage.role.form',['textButton' => 'Simpan', 'icon' => 'mdi mdi-plus'])
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
            setFormValidation('#tambah-role');
            // init select 2
            $('.select2').select2();
        });
    </script>
@endsection