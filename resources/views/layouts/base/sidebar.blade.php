<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="user-profile treeview">
                <a href="index.html">
                    <img src="{{ asset('themes/base/images/user5-128x128.jpg') }}" alt="user">
                    <span>{{ Auth::user()->userData->nama_lengkap }}</span>
                    <span class="pull-right-container">
                          <i class="fa fa-angle-right pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('base.user.profile') }}">My Profile </a></li>
                    <li><a href="javascript:void()">Account Setting</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </li>
            <li class="nav-devider"></li>
            {{--{!! $menu->generateMenu($activeMenu) !!}--}}
            {!! session()->get('list_menu') !!}
        </ul>
    </section>
</aside>