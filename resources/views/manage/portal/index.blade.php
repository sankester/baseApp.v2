@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Portal
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Manajement Aplikasi</a></li>
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
        @if(empty($portals))
            <div class="error-page empty-data">
                <div class="error-content">
                    <div class="container text-center">
                        <h2 class="headline text-muted"><i class="mdi mdi-web"></i></h2>
                        <h3 class="margin-top-0">Portal Belum Tersedia !</h3>
                    </div>
                </div>
            </div>
        @else
            <div class="row fx-element-overlay">
                @foreach($portals as $portal)
                <div class="col-md-12 col-lg-4" id="{{ $portal->id }}">
                    <div class="box box-default">
                        <div class="fx-card-item bl-3 border-success h-30">
                            <div class="box-body fx-overlay-1">
                                <h3 class="text-left">{{ $portal->portal_nm }}</h3>
                                <p class="box-text text-left">{{ $portal->site_desc }}</p>
                                <div class="fx-overlay scrl-up">
                                    <ul class="fx-info">
                                        <li><a class="btn default btn-outline image-popup-vertical-fit detail-portal" href="#" data-url ="{{ route('manage.portal.show',$portal->id) }}" data-token="{{ csrf_token() }}"><i class="mdi mdi-eye"></i></a></li>
                                        <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{ route('manage.portal.edit', $portal->id ) }}"><i class="mdi mdi-pencil"></i></a></li>
                                        <li><a class="btn default btn-outline delete-portal" data-id="{{$portal->id}}" href="#" data-url ="{{ route('manage.portal.destroy',$portal->id) }}" data-token="{{ csrf_token() }}"><i class="mdi mdi-delete"></i></a></li>
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
    {{--include modal--}}
    @include('layouts.base.modal')
    {{--end include modal--}}
@endsection