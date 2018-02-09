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
                    <li><a href="javascript:void()">My Profile </a></li>>
                    <li><a href="javascript:void()">Account Setting</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                </ul>
            </li>
            <li class="nav-devider"></li>
            <li>
                <a href="{{ route('base.manage.home') }}">
                    <i class="mdi mdi-view-dashboard mr-5"></i> <span>Home</span>
                </a>
            </li>
            <li class="header "> Manajemen User</li>
            <li>
                <a href="#">
                    <i class="mdi mdi-account mr-5"></i> <span>User</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="mdi mdi-account-settings-variant mr-5"></i><span> Role & Permission</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="mdi mdi-menu mr-5"></i><span>Menu</span>
                </a>
            </li>
            <li>
                <a href="{{ route('manage.portal.index') }}">
                    <i class="mdi mdi-web mr-5"></i><span> Portal</span>
                </a>
            </li>
        </ul>
    </section>
</aside>