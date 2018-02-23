@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Preference
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-dashboard"></i> Manajement Aplikasi</a></li>
            <li class="breadcrumb-item active">Preference</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <h3 class="page-header">
                    List Preference
                    <div class="box-controls pull-right">
                        <a class="btn btn-sm btn-primary" href="{{ route('manage.preference.create') }}"><i class="mdi mdi-plus mr-5"></i> Tambah Data</a>
                    </div>
                </h3>
            </div>
            {{--include notification--}}
            @include('layouts.notification.base_notification')
            {{--end include notification--}}
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if(count($preference) == 0)
                                    <div class="error-page empty-data">
                                        <div class="error-content">
                                            <div class="container text-center">
                                                <h2 class="headline text-muted"><i class="mdi mdi-pencil-lock"></i></h2>
                                                <h3 class="margin-top-0">Preference Belum Tersedia !</h3>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <table class="table table-responsive">
                                        <tbody>
                                        <tr>
                                            <th width="10%" class="text-center">#</th>
                                            <th width="15%" class="text-center">Group</th>
                                            <th width="30%" class="text-center">Nama</th>
                                            <th width="30%" class="text-center">Isi</th>
                                            <th width="15%%"></th>
                                        </tr>
                                        @foreach($preference as $key => $pref)
                                            <tr>
                                                <td class="text-center">{!! (( ($preference->currentPage())  - 1 ) * $preference->perPage() ) + ($key+1) !!} </td>
                                                <td>{{ $pref->pref_group }}</td>
                                                <td>{{ $pref->pref_name }}</td>
                                                <td>{{ $pref->pref_value}}</td>
                                                <td>
                                                    <a href="{{ route('manage.preference.edit', $pref->id) }}" class="btn btn-info btn-sm mr-5"><i class="mdi mdi-pencil"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm delete-preference"  data-url="{{ route('manage.preference.destroy', $pref->id) }}"><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    @if ($preference->hasPages())
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="pull-left">
                                                    <p>
                                                        Halaman {{ $preference->currentPage() }} dari {{ $preference->lastPage() }} Halaman
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                {{ $preference->links('layouts.base.pagination') }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    {{--include modal--}}
    @include('layouts.base.modal')
    {{--end include modal--}}
@endsection