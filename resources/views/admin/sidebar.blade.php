<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a class="brand-link">
        <img src="/assets/image/logo-transparent.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Dopecut Hair Studio</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/assets/image/admin.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->username }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link {{ $page == 'Dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/admin/service" class="nav-link {{ $page == 'Service' || $page == 'Update Service' ? 'active' : '' }}">
                                <i class="fas fa-th-large nav-icon"></i>
                                <p>Service</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="/admin/branch" class="nav-link {{ $page == 'Outlet' ? 'active' : '' }}">
                                <i class="fab fa-buffer nav-icon"></i>
                                <p>Outlet</p>
                            </a>
                        </li> --}}
                        {{-- <li class="nav-item">
                            <a href="/admin/branch-service" class="nav-link {{ $page == 'Service Outlet' ? 'active' : '' }}">
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <p>Service Outlet</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="/admin/time-operation" class="nav-link {{ $page == 'Jam Operasional' ? 'active' : '' }}">
                                <i class="fas fa-clock nav-icon"></i>
                                <p>Jam Operasional</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/hair-artist" class="nav-link {{ $page == 'Hair Artist' ? 'active' : '' }}">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Hair Artist</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/ha-schedule/day-off" class="nav-link {{ $page == 'Day Off' ? 'active' : '' }}">
                                <i class="fas fa-edit nav-icon"></i>
                                <p>Day Off</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/user" class="nav-link {{ $page == 'User' ? 'active' : '' }}">
                                <i class="fas fa-user-tie nav-icon"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="/admin/book" class="nav-link {{ $page == 'Booking Data' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Booking Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/ha-schedule" class="nav-link {{ $page == 'Schedule' ? 'active' : '' }}">
                        <i class="fas fa-calendar nav-icon"></i>
                        <p>Schedule</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/article" class="nav-link {{ $page == 'Article' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>Artikel</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
