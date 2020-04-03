<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <img src="{{ asset("assets/img/islaami_logo.png") }}" alt="Islaami Logo" class="brand-image p-3"
         style="opacity: .8;width: 100%;">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                @yield('sidebarContent')
{{--                @if($admin->hasRole("super admin"))--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.manage')  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-user-shield"></i>--}}
{{--                            <p>--}}
{{--                                Manage Admin--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    --}}{{--<li class="nav-item">--}}
{{--                        <a href="{{ route('admin.roles.manage')  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-user-tag"></i>--}}
{{--                            <p>--}}
{{--                                Manage Roles--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--                @if($admin->hasRole("islaami"))--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.users.all') }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-users"></i>--}}
{{--                            <p>--}}
{{--                                Manage Users--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    --}}{{--<li class="nav-item">--}}
{{--                        <a href="{{ route('admin.calendar') }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-calendar-alt"></i>--}}
{{--                            <p>--}}
{{--                                Calendar--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--                @if($admin->hasRole("playmi"))--}}
{{--                    <li class="nav-item has-treeview">--}}
{{--                        <a href="#" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-chart-pie"></i>--}}
{{--                            <p>--}}
{{--                                Playmi--}}
{{--                                <i class="right fas fa-angle-left"></i>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                        <ul class="nav nav-treeview">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('admin.videos.all')  }}" class="nav-link">--}}
{{--                                    <i class="nav-icon fab fa-youtube"></i>--}}
{{--                                    <p>--}}
{{--                                        Videos--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('admin.channels.all')  }}" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-video"></i>--}}
{{--                                    <p>--}}
{{--                                        Channels--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('admin.categories.all')  }}" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-folder-open"></i>--}}
{{--                                    <p>--}}
{{--                                        Categories--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{ route('admin.recommendations.all')  }}" class="nav-link">--}}
{{--                                    <i class="nav-icon fas fa-user-check"></i>--}}
{{--                                    <p>--}}
{{--                                        Recommendation--}}
{{--                                    </p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                @endif--}}
{{--                @if($admin->hasAnyRole(['islaami', 'playmi']))--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.reports.all')  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-flag"></i>--}}
{{--                            <p>--}}
{{--                                Reports--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.insights.all')  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-comment-alt"></i>--}}
{{--                            <p>--}}
{{--                                Insights--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.articleCategories.all')  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-newspaper"></i>--}}
{{--                            <p>--}}
{{--                                Article Categories--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('admin.edit', ['id'=> Auth::user()->id ])  }}" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-id-card"></i>--}}
{{--                            <p>--}}
{{--                                Admin--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endif--}}
                <li class="nav-item">
                    <a href="{{ route('admin.attempt.logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
