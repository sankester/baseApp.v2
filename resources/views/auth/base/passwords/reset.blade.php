@extends('layouts.base.auth')
@section('content')
    <p class="login-box-msg">Atur ulang password.</p>
    <form action="{{ route('password.request') }}" method="post" class="form-element">
        {{ csrf_field() }}
        
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
            <input type="email" name="email" class="form-control control-input" placeholder="email" value="{{ old('email') }}">
            <span class="ion ion-email form-control-feedback"></span>
            @if ($errors->has('email'))
                <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password" class="form-control control-input" placeholder="Password">
            <span class="ion ion-locked form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <input type="password" name="password_confirmation" class="form-control control-input" placeholder="Konfirmasi Password">
            <span class="ion ion-locked form-control-feedback"></span>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
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
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block margin-top-10">Reset Password</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-20">
                <p class="text-center">
                    <a href="{{ route('password.request') }}"><i class="ion ion-locked mr-5"></i> Lupa Password ?</a>
                </p>
            </div>
        </div>
    </form>
@endsection
