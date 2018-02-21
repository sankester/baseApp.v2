@extends('layouts.base.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Home
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active">Home</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="ion ion-person-stalker"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">2,000</span>
                    <span class="info-box-text">User</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="ion ion-ios-people"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number">2,000</span>
                    <span class="info-box-text">Role</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-key"></i></span>
                <div class="info-box-content">
                    <span class="info-box-number">2,000</span>
                    <span class="info-box-text">Permission</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="ion ion-grid"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-number">2,000</span>
                    <span class="info-box-text">Menu</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>

</section>
<!-- /.content -->
@endsection