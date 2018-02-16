@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Home</a></li>
            <li class="breadcrumb-item"><a href="#">Manage</a></li>
            <li class="breadcrumb-item active">User</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List User
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.user.create') }}"><i class="mdi mdi-plus mr-5"></i> Tambah Data</a>
                    </div>
                </h3>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h5 class="box-title">Cari User</h5>
                    </div>
                    {!!  Form::open(['route' => 'manage.user.search']) !!}
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row mb-0 pb-0">
                                    <div class="form-group col-md-3 mb-0 pb-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {!! Form::text('nama_lengkap', isset($search['nama_lengkap']) ? $search['nama_lengkap'] : '', ['class' => 'form-control search-form-control','placeholder' => 'Nama user'] ); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-0 pb-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {!! Form::select('role_id', $listRole , isset($search['role_id']) ? $search['role_id'] : '', ['class' => 'form-control search-form-control select2 select2-hidden-accessible', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 mb-0 pb-0">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                {!! Form::select('status', [''=> 'Pilih Status', 'aktif' => 'Aktif', 'unaktif' => 'Unaktif'] , isset($search['status']) ? $search['status'] : '', ['class' => 'form-control search-form-control select2 select2-hidden-accessible', 'style' => 'width: 100%', "tabindex" => "-1" , "aria-hidden" => "true"] ); !!}
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
                        <!-- /.row -->
                    </div>
                    {!! Form::close() !!}
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        @if($listUser->isEmpty())
            <div class="error-page empty-data">
                <div class="error-content">
                    <div class="container text-center">
                        <h2 class="headline text-muted"><i class="mdi mdi-account "></i></h2>
                        <h3 class="margin-top-0">Belum ada user !</h3>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($listUser as $user)
                    <div class="col-6 col-md-6 col-lg-4 col-xl-3" id="{{ $user->id }}">
                        <div class="box box-body">
                            <div class="flexbox align-items-center">
                                <label class="toggler {{ $user->status == 'aktif' ? 'text-success' : 'text-muted'}}">
                                    <i class="fa fa-check-circle"></i>
                                </label>
                                <div class="dropdown">
                                    <a data-toggle="dropdown" href="#" aria-expanded="false"><i class="ion-android-more-vertical"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item detail-user" href="#"  data-url ="{{ route('manage.user.show',$user->id) }}" data-token="{{ csrf_token() }}"><i class="fa fa-fw fa-user"></i> Detail</a>
                                        <a class="dropdown-item" href="{{ route('manage.user.edit', $user->id ) }}"><i class="fa fa-fw fa-pencil"></i> Edit</a>
                                        <a class="dropdown-item delete-user" href="#"  data-url ="{{ route('manage.user.destroy',$user->id) }}" data-token="{{ csrf_token() }}"><i class="fa fa-fw fa-remove"></i> Hapus</a>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center pt-3">
                                <a href="#">
                                    <img class="avatar avatar-xxl" src="{{ ! empty($user->userData->foto) ?  asset('images/avatar/thumbnail/'.$user->userData->foto) : asset('themes/base/images/avatar/1.jpg') }}">
                                </a>
                                <h5 class="mt-15 mb-0"><a href="#">{{ $user->userData->nama_lengkap }}</a></h5>
                                <span>@foreach($user->role as $key => $role) {{$role->role_nm}} @if($key+1 != $user->role->count()) - @endif @endforeach</span>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>
            @if ($listUser->hasPages())
                <div class="row">
                    <div class="col-md-6">
                        <div class="pull-left">
                            <p>
                                Halaman {{ $listUser->currentPage() }} dari {{ $listUser->lastPage() }} Halaman
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        {{ $listUser->links('layouts.base.pagination') }}
                    </div>
                </div>
            @endif
        @endif
    </section>
    {{--include modal--}}
    @include('layouts.base.modal')
    {{--end include modal--}}
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>
@endsection