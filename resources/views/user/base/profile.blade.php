@extends('layouts.base.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            User
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('base.manage.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-xl-4 col-lg-5">

                <!-- Profile Image -->
                <div class="box">
                    <div class="box-body box-profile">
                        <img class="profile-user-img rounded-circle img-fluid mx-auto d-block" src="{{ ! empty($user->userData->foto) ?  asset('images/avatar/thumbnail/'.$user->userData->foto) : asset('themes/base/images/avatar/5.jpg') }}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $user->userData->nama_lengkap }}</h3>

                        <p class="text-muted text-center">{{ $user->userData->jabatan }} </p>

                        {{--<div class="row social-states">--}}
                            {{--<div class="col-6 text-right"><a href="#" class="link"><i class="ion ion-ios-people-outline"></i> 254</a></div>--}}
                            {{--<div class="col-6 text-left"><a href="#" class="link"><i class="ion ion-images"></i> 54</a></div>--}}
                        {{--</div>--}}

                        <div class="row">
                            <div class="col-12">
                                <div class="profile-user-info">
                                    <p>Email </p>
                                    <h6 class="margin-bottom">{{ $user->email }}</h6>
                                    <p>No Telepon</p>
                                    <h6 class="margin-bottom">{{ $user->userData->no_telp }}</h6>
                                    <p>Alamat</p>
                                    <h6 class="margin-bottom">{{  $user->userData->alamat  }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-xl-8 col-lg-7">
                {{--include notification--}}
                @include('layouts.notification.base_notification')
                {{--end include notification--}}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li><a class="@if(!isset($active)) active @endif" href="#timeline" data-toggle="tab" aria-expanded="false">Timeline</a></li>
                        <li><a href="#activity" data-toggle="tab" class="" aria-expanded="true">Activity</a></li>
                        <li><a class="@if(isset($active)) active @endif"  href="#settings" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane @if(!isset($active)) active @endif" id="timeline" aria-expanded="false">
                            <!-- The timeline -->
                            <ul class="timeline">
                                @php
                                    $dateLabel = '';
                                @endphp
                                @forelse($logPortal as $logp)
                                    @if($dateLabel != $logp->created_at->format('d M, Y') )
                                    <li class="time-label">
                                      <span class="bg-timeline">
                                        {{ $logp->created_at->format('d M, Y') }}
                                        @php $dateLabel = $logp->created_at->format('d M, Y') @endphp
                                      </span>
                                    </li>
                                    @endif
                                    <li class="timeline-portal">
                                        <i class="fa fa-@php
                                                                switch (strtolower(strtok($logp->action, " "))){
                                                                    case 'insert' :
                                                                        echo 'plus';
                                                                        break;
                                                                    case 'update' :
                                                                        echo 'pencil';
                                                                        break;
                                                                    case 'delete' :
                                                                        echo 'trash';
                                                                        break;
                                                                    default :
                                                                        echo 'info';
                                                                        break;
                                                                }
                                                            @endphp bg-@php
                                                                        switch (strtolower(strtok($logp->action, " "))){
                                                                            case 'insert' :
                                                                                echo 'success';
                                                                                break;
                                                                            case 'update' :
                                                                                echo 'info';
                                                                                break;
                                                                            case 'delete' :
                                                                                echo 'danger';
                                                                                break;
                                                                            default :
                                                                                echo 'primary';
                                                                                break;
                                                                        }
                                                                    @endphp
                                            text-white "></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $logp->created_at->format('h:i A')}} </span>

                                            <h3 class="timeline-header"><a href="#">{{ $logp->user->userData->nama_lengkap }}</a> ( {{ $logp->action }} )</h3>

                                            <div class="timeline-body">
                                                {{ $logp->description }}
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <div class="colmd-12 text-center">
                                        <i class="fa fa-clock-o mt-10" style="font-size: 20px"></i>
                                        <p class="text-center">
                                            Belum ada aktivitas.
                                        </p>
                                    </div>
                                @endforelse
                                @if($logPortal->isNotEmpty())
                                    <li id="more-timeline">
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                @endif
                            </ul>
                            @if($logPortal->isNotEmpty())
                                <div class="col-md-12 text-center mt-10 mb-10">
                                    <button id="load-logportal" class="btn btn-md btn-success btn-round " data-loading-text="<i class='fa fa-spinner fa-spin' style='font-size:24px'></i>"  data-url="{{ route('base.user.logportal') }}" default-date="{{ $dateLabel }}">Lainnya</button>
                                </div>
                            @endif
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="activity" aria-expanded="true">
                            <div class="list-user-activity">
                                @forelse($logUser as $logu)
                                <!-- Post -->
                                    <div class="post user-activity">
                                        <div class="user-block">
                                            <img class="img-bordered-sm rounded-circle" src="{{ ! empty($user->userData->foto) ?  asset('images/avatar/thumbnail/'.$user->userData->foto) : asset('themes/base/images/avatar/1.jpg') }}" alt="user image">
                                            <span class="username">
                                      <a href="#">{{ $logu->user->userData->nama_lengkap }}</a>
                                    </span>
                                            <span class="description">{{ $logu->created_at->diffForHumans()}}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <div class="activitytimeline">
                                            <p>
                                                {{ $logu->description }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- /.post -->
                                @empty
                                    <div class="colmd-12 text-center">
                                        <i class="fa fa-clock-o mt-10" style="font-size: 20px"></i>
                                        <p class="text-center">
                                            Belum ada aktivitas.
                                        </p>
                                    </div>
                                @endforelse
                            </div>
                            @if($logUser->isNotEmpty())
                                 <div class="col-md-12 text-center mt-10 mb-10">
                                    <button id="load-loguser" class="btn btn-md btn-success btn-round " data-loading-text="<i class='fa fa-spinner fa-spin' style='font-size:24px'></i>"  data-url="{{ route('base.user.loguser') }}">Lainnya </button>
                                 </div>
                            @endif
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="settings">
                            {!! Form::model($user ,['method' => 'PATCH','route' => 'base.user.updatedata', 'class' => 'form-horizontal form-element col-12','enctype'=>'multipart/form-data', 'id' => 'edit-user']) !!}
                            <div class="box">
                                <div class="box-body">
                                    <h4><a href="#">User Data</a></h4>
                                    <div class="col-md-12">
                                        <div class="form-group row {{ $errors->has('role_nm') ? ' has-error' : '' }}">
                                            {!! Form::label('nama_lengkap','Nama ',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('nama_lengkap', (!empty($user->userData->nama_lengkap) ? $user->userData->nama_lengkap : '') ,['class' => 'form-control ' , 'required' =>'true']) !!}
                                                @if ($errors->has('nama_lengkap'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('nama_lengkap') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('tempat_lahir') ? ' has-error' : '' }}">
                                            {!! Form::label('tempat_lahir','Tempat Lahir',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('tempat_lahir',(!empty($user->userData->tempat_lahir) ? $user->userData->tempat_lahir : ''),['class' => 'form-control ' ,'required' =>'true']) !!}
                                                @if ($errors->has('tempat_lahir'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('tempat_lahir') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('tanggal_lahir') ? ' has-error' : '' }}">
                                            {!! Form::label('tanggal_lahir','Tanggal Lahir',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('tanggal_lahir',(!empty($user->userData->tempat_lahir) ? $user->userData->tanggal_lahir : ''),['class' => 'form-control datepicker' ,'required' =>'true']) !!}
                                                @if ($errors->has('tanggal_lahir'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('no_telp') ? ' has-error' : '' }}">
                                            {!! Form::label('no_telp','No Telp',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('no_telp',(!empty($user->userData->no_telp) ? $user->userData->no_telp : ''),['class' => 'form-control ' ,'required' =>'true', 'maxlength' => '16']) !!}
                                                @if ($errors->has('no_telp'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('no_telp') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('jabatan') ? ' has-error' : '' }}">
                                            {!! Form::label('jabatan','Jabatan',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('jabatan',(!empty($user->userData->jabatan) ? $user->userData->jabatan : ''),['class' => 'form-control ' ,'required' =>'true']) !!}
                                                @if ($errors->has('jabatan'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('jabatan') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('alamat') ? ' has-error' : '' }}">
                                            {!! Form::label('alamat','Alamat',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::textarea('alamat',(!empty($user->userData->alamat) ? $user->userData->alamat : ''),['class' => 'form-control ' ,'required' =>'true']) !!}
                                                @if ($errors->has('alamat'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('alamat') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('foto') ? ' has-error' : '' }}">
                                            {!! Form::label('foto','Foto ',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                @if(! empty($user->userData->foto))
                                                    <div class="col-md-4 ml-0 pl-0 mb-10">
                                                        Image saat ini  : <img class="img-responsive" src="{{ asset('images/avatar/thumbnail/'.$user->userData->foto) }}" alt="Foto Profil">
                                                    </div>
                                                @endif
                                                {!! Form::file('foto',['class' => 'form-control file-styled']) !!}
                                                @if ($errors->has('foto'))
                                                    <span class="help-block">
                                                <strong>{{ $errors->first('foto') }}</strong>
                                            </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-body">
                                    <h4><a href="#">User Login</a></h4>
                                    <div class="col-md-12">
                                        <div class="form-group row {{ $errors->has('username') ? ' has-error' : '' }}">
                                            {!! Form::label('username','Username',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('username',null,['class' => 'form-control ' ,'required' =>'true']) !!}
                                                @if ($errors->has('username'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('username') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                                            {!! Form::label('email','E-mail',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::email('email',null,['class' => 'form-control ' ,'required' =>'true']) !!}
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('password') ? ' has-error' : '' }}">
                                            {!! Form::label('password','Password',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::password('password',['class' => 'form-control ' , !empty($user) ? ' ': ['required'=>'true']]) !!}
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group row {{ $errors->has('password_confirm') ? ' has-error' : '' }}">
                                            {!! Form::label('password_confirm','Konfirmasi Password',['class' => 'col-sm-3 control-label']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::password('password_confirm',['class' => 'form-control ' , !empty($user)? '' : ["equalTo" => "#password" ] , !empty($user) ? ' ': ['required'=>'true']]) !!}
                                                @if ($errors->has('password_confirm'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password_confirm') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer clearfix col-md-12">
                                    <button type="submit" class="btn btn-success pull-right"><i class="mdi mdi-pencil mr-5"></i> Simpan</button>
                                    <button type="reset" class="btn btn-default pull-right mr-10"><i class="mdi mdi-refresh mr-5"></i> Reset</button>
                                </div>
                            </div>

                            {!! Form::close() !!}
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
@endsection
@section('custom-js')
    <script type="text/javascript">
        $(document).ready(function () {
            // init auto complite
            var jabatan = [
                {!! $jabatan !!}
            ];
            $( "#jabatan" ).autocomplete({
                lookup : jabatan
            });
        });
    </script>
@endsection