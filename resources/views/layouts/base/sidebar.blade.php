<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="user-profile treeview">
                <a href="index.html">
                    <img src="{{ asset('themes/base/images/user5-128x128.jpg') }}" alt="user">
                    <span>Juliya Brus</span>
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
                <a href="{{ route('base.home') }}">
                    <i class="fa fa-home"></i> <span>Home</span>
                </a>
            </li>
            <li class="header nav-small-cap">Manajemen User</li>
            <li>
                <a href="#">
                    <i class="fa fa-user"></i> <span>User</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-users"></i><span>Role & Permission</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-bars"></i><span>Menu</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-globe"></i>
                    <span>Portal</span>
                    <span class="pull-right-container"><i class="fa fa-angle-right pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../UI/badges.html">Badges</a></li>
                    <li><a href="../UI/border-utilities.html">Border</a></li>
                    <li><a href="../UI/buttons.html">Buttons</a></li>
                </ul>
            </li>
        </ul>
    </section>
</aside>