@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Portal
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item active">Portal</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Portal
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.portal.create') }}"><i class="mdi mdi-plus mr-5"></i> Tambah Data</a>
                    </div>
                </h3>
            </div>

        </div>
        <div class="row fx-element-overlay">
            <div class="col-md-12 col-lg-3">
                <div class="box box-default">
                    <div class="fx-card-item">
                        <div class="box-body fx-overlay-1">
                            <h3 class="text-left">Portal Base</h3>
                            <p class="box-text text-left">Portal untuk developer, khusus untuk manajemen aplikasi base (inti).</p>
                            <div class="fx-overlay scrl-up">
                                <ul class="fx-info">
                                    <li><a class="btn default btn-outline image-popup-vertical-fit" href="javascript:void(0);"><i class="mdi mdi-pencil"></i></a></li>
                                    <li><a class="btn default btn-outline" href="javascript:void(0);"><i class="mdi mdi-delete"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
@endsection