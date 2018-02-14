@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Menu
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage.menu.index') }}">Menu</a></li>
            <li class="breadcrumb-item"><a href="{{ route('manage.menu.show', $portal->id ) }}">{{ $portal->portal_nm }}</a></li>
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
                            Form Edit Menu
                        </h3>
                        <div class="box-controls pull-right">
                            <a class="btn btn-sm btn-default" href="{{ route('manage.menu.show', $portal->id) }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        </div>
                    </div>
                    {{--include notification--}}
                    @include('layouts.notification.base_notification')
                    {{--end include notification--}}
                    <!-- form start -->
                    {!! Form::model($menu ,['method' => 'PATCH', 'route' => ['manage.menu.update', $menu->id ], 'class' => 'form-horizontal form-element', 'id' => 'form-menu']) !!}
                    @include('manage.menu.form',['textButton' => 'Simpan', 'iconButton' => 'mdi mdi-pencil'])
                    {!! Form::close() !!}
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
