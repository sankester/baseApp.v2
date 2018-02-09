@extends('layouts.base.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Blank page
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-view-dashboard mr-5"></i> Home</a></li>
        <li class="breadcrumb-item"><a href="#">Examples</a></li>
        <li class="breadcrumb-item active">Blank page</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Title</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <p class="text-center">
                You are logged in<!doctype html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport"
                          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>Document</title>
                </head>
                <body>
                
                </body>
                </html>
            </p>
            <pre>
                {!! print_r($user) !!}
            </pre>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            Footer
        </div>
        <!-- /.box-footer-->
    </div>
    <!-- /.box -->

</section>
<!-- /.content -->
@endsection