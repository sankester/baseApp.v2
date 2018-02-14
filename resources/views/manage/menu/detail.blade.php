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
            <li class="breadcrumb-item active">{{ $portal->portal_nm }}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Menu {{ $portal->portal_nm }}
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-default" href="{{ route('manage.menu.index') }}"><i class="mdi mdi-chevron-left mr-5"></i> Kembali</a>
                        <a class="btn btn-sm btn-primary mr-5" href="{{ route('manage.menu.create', $portal->id ) }}"><i class="mdi mdi-plus mr-5"></i> Tambah Menu</a>
                    </div>
                </h3>
            </div>
            @if(empty($htmlMenu))
                <div class="col-md-12">
                    <div class="error-page empty-data">
                        <div class="error-content">
                            <div class="container text-center">
                                <h2 class="headline text-muted"><i class="mdi mdi-menu "></i></h2>
                                <h3 class="margin-top-0">Menu Belum Tersedia !</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                            <div class="myadmin-dd dd col-md-12" id="nestable" data-url = '{{ route('manage.menu.sortable', $portal->id) }}' data-token="{{ csrf_token() }}">
                                {!! $htmlMenu !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dd').nestable({
                callback: function(l) {
                    var data = $('.dd').nestable('serialize');
                    var datastring = JSON.stringify(data);
                    var data_url =  $('.myadmin-dd').attr('data-url')
                    var data_token =  $('.myadmin-dd').attr('data-token')
                    $.ajax({
                        url: data_url,
                        type: 'PUT',
                        data: {_method: 'PUT', _token: data_token,  list : datastring},
                        success: function (data) {

                        },
                        error:function(data){

                        }
                    });
                }
            });
            $(".dd a").on("mousedown", function(event) { // mousedown prevent nestable click
                event.preventDefault();
                return false;
            });

            $(".dd a").on("click", function(event) { // click event
                event.preventDefault();
                window.location = $(this).attr("href");
                return false;
            });
        });
    </script>
@endsection