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
            <li class="breadcrumb-item active">Menu</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Portal
                </h3>
            </div>
        </div>
        @if(empty($portals))
            <div class="error-page empty-data">
                <div class="error-content">
                    <div class="container text-center">
                        <h2 class="headline text-muted"><i class="mdi mdi-web "></i></h2>
                        <h3 class="margin-top-0">Menu Belum Tersedia !</h3>
                    </div>
                </div>
            </div>
        @else
            <div class="row fx-element-overlay">
                @foreach($portals as $portal)
                <div class="col-md-12 col-lg-4" id="{{ $portal->id }}">
                    <div class="box box-default">
                        <div class="fx-card-item">
                            <div class="box-body fx-overlay-1">
                                <h3 class="text-left">{{ $portal->portal_nm }}</h3>
                                <p class="box-text text-left">{{ $portal->site_desc }}</p>
                                <div class="fx-overlay scrl-up">
                                    <ul class="fx-info">
                                        <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ route('manage.menu.show', $portal->id ) }}"><i class="mdi mdi-eye"></i></a></li>
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