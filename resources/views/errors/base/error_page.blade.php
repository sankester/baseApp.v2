@extends('layouts.base.app')
@section('content')
    <div class="error-body-content">
        <div class="error-page">

            <div class="error-content">
                <div class="container">

                    <h2 class="headline text-red">{!! $data['code'] !!}</h2>

                    <h3 class="margin-top-0"><i class="fa fa-warning text-red"></i> {!! $data['message'] !!}</h3>

                    <div class="text-center">
                        <a href="{{ url(session()->get('role_active')->default_page) }}" class="btn btn-info btn-block margin-top-10">Kembali ke halaman utama.</a>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.error-page -->
    </div>
@endsection