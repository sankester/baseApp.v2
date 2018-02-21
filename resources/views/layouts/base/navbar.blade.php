<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('base.manage.home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <b class="logo-mini">
            <span class="light-logo"><img src="{{asset('themes/base/images/logo-light.png')}}" alt="logo"></span>
            <span class="dark-logo"><img src="{{ asset('themes/base/images/logo-dark.png') }}" alt="logo"></span>
        </b>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
              <img src="{{asset('themes/base/images/logo-light-text.png')}}" alt="logo" class="light-logo">
              <img src="{{asset('themes/base/images/logo-dark-text.png')}}" alt="logo" class="dark-logo">
        </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 14px">
                        {{ Auth::user()->userData->nama_lengkap }}
                        {{--<img src="{{  ! empty(Auth::user()->userData->foto) ?  asset('images/avatar/thumbnail/'.Auth::user()->userData->foto) : asset('themes/base/images/user5-128x128.jpg') }}" class="user-image rounded-circle" alt="User Image">--}}
                    </a>
                    <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{  ! empty(Auth::user()->userData->foto) ?  asset('images/avatar/thumbnail/'.Auth::user()->userData->foto) : asset('themes/base/images/user5-128x128.jpg') }}" class="float-left rounded-circle" alt="User Image">
                            <p>
                                {{ Auth::user()->userData->jabatan}}
                                <small class="mb-5">{{ Auth::user()->email }}</small>
                                <small class="mb-5 text-success">Role : {{ session()->get('role_active')->role_nm }}</small>

                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row no-gutters">
                                <div class="col-12 text-left">
                                    <a href="{{ route('base.user.profile') }}"><i class="ion ion-person"></i>Profile Saya</a>
                                </div>
                                <div role="separator" class="divider col-12"></div>
                                <div class="col-12 text-left">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                    </ul>
                </li>
                {{--<li>--}}
                    {{--<a href="#" data-toggle="control-sidebar"><i class="fa fa-cog fa-spin"></i></a>--}}
                {{--</li>--}}
            </ul>
        </div>
    </nav>
</header>