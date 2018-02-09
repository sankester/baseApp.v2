<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('themes/base/images/favicon.ico') }}">

    <title>Login Base Aplication - Log in </title>

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('themes/base/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Bootstrap 4.0-->
    <link rel="stylesheet" href="{{ asset('themes/base/assets/vendor_components/bootstrap/dist/css/bootstrap-extend.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('themes/base/css/master_style_custom.css')}}">

    <!-- Alfa_admin Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('themes/base/css/skins/_all-skins.css')}}">

    {{--helper--}}
    <link rel="stylesheet" href="{{ asset('css/margin_padding.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index.html"><b>Base </b>App</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        @yield('content')
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->


<!-- jQuery 3 -->
<script src="{{ asset('themes/base/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>

<!-- popper -->
    <script src="{{ asset('themes/base/assets/vendor_components/popper/dist/popper.min.js') }}"></script>

<!-- Bootstrap 4.0-->
<script src="{{ asset('themes/base/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</body>
</html>
