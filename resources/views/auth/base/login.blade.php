@extends('layouts.base.auth')
@section('content')
    <p class="login-box-msg">Login untuk memulai aplikasi</p>
    <form action="{{ route('login') }}" method="post" class="form-element">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('username') ? ' has-error' : '' }}">
            <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
            <span class="ion ion-email form-control-feedback"></span>
            @if ($errors->has('username'))
                <span class="help-block">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="ion ion-locked form-control-feedback"></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        <div class="row">
            <div class="col-6">
                <div class="checkbox">
                    <input type="checkbox" id="remember_me" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember_me">Ingat saya.</label>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-info btn-block margin-top-10">Login</button>
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
