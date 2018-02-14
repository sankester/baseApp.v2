@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permission
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item active">Permission</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Permission
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.permission.create') }}"><i class="mdi mdi-plus mr-5"></i> Tambah Data</a>
                    </div>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h5 class="box-title">Cari Permission</h5>
                    </div>
                    {!!  Form::open(['route' => 'manage.permission.search']) !!}
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row ">
                                    <div class="form-group col-md-4 ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! Form::text('permission_nm', isset($search['permission_nm']) ? $search['permission_nm'] : '', ['class' => 'form-control', 'placeholder' => 'nama permission'] ); !!}
                                            </div>
                                       </div>
                                    </div>
                                    <div class="form-group col-md-4 ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! Form::select('portal_id', $listPortal, $search['portal_id'] , ['class' => 'form-control select2 select2-hidden-accessible', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-0 pb-0">
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
                        <div class="row">
                            <div class="col-md-12">
                                @if(count($listPermission) == 0)
                                    <div class="error-page empty-data">
                                        <div class="error-content">
                                            <div class="container text-center">
                                                <h2 class="headline text-muted"><i class="mdi mdi-key"></i></h2>
                                                <h3 class="margin-top-0">Permission Belum Tersedia !</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <table class="table table-responsive">
                                        <tbody>
                                        <tr>
                                            <th width="10%" class="text-center">#</th>
                                            <th width="30%" class="text-center">Nama</th>
                                            <th width="15%" class="text-center">Group</th>
                                            <th width="30%" class="text-center">Slug</th>
                                            <th width="15%%"></th>
                                        </tr>
                                        @foreach($listPermission as $key => $permission)
                                            <tr>
                                                <td class="text-center">{!! (( ($listPermission->currentPage())  - 1 ) * $listPermission->perPage() ) + ($key+1) !!} </td>
                                                <td>{{ $permission->permission_nm }}</td>
                                                <td>{{ $permission->permission_group }}</td>
                                                <td>{{ $permission->permission_slug }}</td>
                                                <td>
                                                    <a href="{{ route('manage.permission.edit', $permission->id) }}" class="btn btn-info btn-sm mr-5"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm delete-permission"  data-url="{{ route('manage.permission.destroy', $permission->id) }}" data-token="{{ csrf_token() }}"><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @if ($listPermission->hasPages())
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pull-left">
                                                    <p>
                                                        Halaman {{ $listPermission->currentPage() }} dari {{ $listPermission->lastPage() }} Halaman
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $listPermission->links('layouts.base.pagination') }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    {!! Form::close() !!}
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>
@endsection