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
            <li class="breadcrumb-item active">Role</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Role
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.role.create') }}"><i class="mdi mdi-plus mr-5"></i> Tambah Data</a>
                    </div>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h5 class="box-title">Cari Role</h5>
                    </div>
                    {!!  Form::open(['route' => 'manage.role.search']) !!}
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row {{ $errors->has('site_name') ? ' has-error' : '' }} mb-0 pb-0">
                                    <div class="form-group col-md-6 mb-0 pb-0">
                                        <div class="row">
                                            {!! Form::label('portal_id','Nama Portal',['class' => 'col-md-3 control-label']) !!}
                                            <div class="col-sm-8">
                                                {!! Form::select('portal_id', $listPortal, $defaultPortal, ['class' => 'form-control select2 select2-hidden-accessible', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 mb-0 pb-0">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-sm btn-default"><i class="mdi mdi-refresh mr-5"></i> Reset</button>
                                                <button type="submit" class="btn btn-sm btn-github" name="search" value="cari"><i class="mdi mdi-magnify mr-5"></i> Cari</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    {!! Form::close() !!}
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        @if(count($listRole) == 0)
            <div class="error-page empty-data">
                <div class="error-content">
                    <div class="container text-center">
                        <h2 class="headline text-muted"><i class="mdi mdi-account-multiple"></i></h2>
                        <h3 class="margin-top-0">Role Belum Tersedia !</h3>
                    </div>
                </div>
            </div>
        @else
            <div class="row fx-element-overlay">
                @foreach($listRole as $role)
                    <div class="col-md-12 col-lg-3" id="{{ $role->id }}">
                        <div class="box box-default">
                            <div class="fx-card-item">
                                <div class="box-body fx-overlay-1">
                                    <h3 class="text-left">{{ $role->role_nm }}</h3>
                                    <p class="box-text text-left">{{ $role->role_desc }}</p>
                                    <div class="fx-overlay scrl-up">
                                        <ul class="fx-info">
                                            <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ route('manage.role.edit', $role->id ) }}"><i class="mdi mdi-pencil"></i></a></li>
                                            <li><a class="btn default btn-outline delete-role" data-id="{{$role->id}}" href="#" data-url ="{{ route('manage.role.destroy',$role->id) }}" data-token="{{ csrf_token() }}"><i class="mdi mdi-delete"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>
@endsection