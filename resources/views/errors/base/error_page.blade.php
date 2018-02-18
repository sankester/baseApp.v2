@extends('layouts.base.app')
@section('content')
    <div class="text-center content-group">
        <h1 class="error-title">{!! $data['code'] !!}</h1>
        <h5>{!! $data['message'] !!}</h5>
    </div>
    <div class="row">
        <div class="col-lg-4 col-lg-offset-4 col-sm-6 col-sm-offset-3">

            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ url(session()->get('role_active')->default_page) }}" class="btn btn-primary btn-block content-group"><i class="icon-circle-left2 position-left"></i> Kembali ke halaman utama.</a>
                </div>
            </div>
        </div>
    </div>
@endsection