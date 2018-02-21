@extends('layouts.base.auth')
@section('content')
    <p class="login-box-msg text-uppercase">Reset Password</p>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form action="{{ route('password.email') }}" method="post" class="form-element">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $email or old('email') }}" required autofocus>
            <span class="ion ion-email form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('captcha') ? ' has-error' : '' }}">
            <div class="row">
                <div class="col-md-6">
                    {!! captcha_img('flat')  !!}
                </div>
                <div class="col-md-6">
                    <input type="text" name="captcha" class="form-control control-input" placeholder="Captcha">
                </div>
            </div>
            @if ($errors->has('captcha'))
                <span class="help-block">
                    <strong>{{ $errors->first('captcha') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block text-uppercase">Kirim Link Reset</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
