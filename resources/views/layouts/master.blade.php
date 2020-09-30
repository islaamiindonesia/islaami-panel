<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Playmi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
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
                    <li class="nav-item">
                        <a href="{{ route('admin.home')  }}"
                           class="nav-link @if($menu == "dashboard") active @endif">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Beranda
                            </p>
                        </a>
                    </li>
                    {{--
                    If user has "super admin" role
                     --}}
                    @if(Auth::user()->hasRole("super admin"))
                        <li class="nav-item">
                            <a href="{{ route('admin.manage')  }}" class="nav-link @if($menu == "manageAdmin") active @endif">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>
                                    Manage Admin
                                </p>
                            </a>
                        </li>
                    @endif
                    {{--
                    If user has "islaami" role
                     --}}
                    @if(Auth::user()->hasRole("islaami"))
                        <li class="nav-item">
                            <a href="{{ route('admin.users.all') }}" class="nav-link @if($menu == "manageUser") active @endif">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Manage Users
                                </p>
                            </a>
                        </li>
                    @endif
                    {{--
                    If user has "playmi" role
                     --}}
                    @if(Auth::user()->hasRole("playmi"))
                        <li class="nav-item has-treeview @isset($parent) @if($parent== "playmi") menu-open @endif @endisset">
                            <a href="#" class="nav-link @isset($parent) @if($parent== "playmi") active @endif @endisset">
                                <img class="nav-icon" src="{{ asset("assets/img/playmi_icon.png")  }}" width="25">
                                <p>
                                    Playmi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.videos.all')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "video") active @endif">
                                        <i class="nav-icon fab fa-youtube"></i>
                                        <p>
                                            Video
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.channels.all')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "channel") active @endif">
                                        <i class="nav-icon fas fa-video"></i>
                                        <p>
                                            Kanal
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.categories.all')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "category") active @endif">
                                        <i class="nav-icon fas fa-folder-open"></i>
                                        <p>
                                            Saluran & Kategori
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.recommendations.all')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "recommendation") active @endif">
                                        <i class="nav-icon fas fa-user-check"></i>
                                        <p>
                                            Rekomendasi
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    {{--
                    If user has "islaami" and "playmi" roles
                     --}}
                    @if(Auth::user()->hasAnyRole(['islaami', 'playmi']))
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.all')  }}"
                               class="nav-link @if($menu == "report") active @endif">
                                <i class="nav-icon fas fa-flag"></i>
                                <p>
                                    Laporan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.insights.all')  }}"
                               class="nav-link @if($menu == "insight") active @endif">
                                <i class="nav-icon fas fa-comment-alt"></i>
                                <p>
                                    Saran/Masukan
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.edit')  }}" class="nav-link @if($menu == "admin") active @endif">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p>
                                    Admin
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview @isset($parent) @if($parent == "policy") menu-open @endif @endisset">
                            <a href="#" class="nav-link @isset($parent) @if($parent == "policy") active @endif @endisset">
                                <i class="nav-icon fas fa-landmark"></i>
                                <p>
                                    Ketentuan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.about')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "about") active @endif">
                                        <i class="nav-icon fas fa-mobile-alt"></i>
                                        <p>
                                            Tentang Aplikasi
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.cooperation')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "coop") active @endif">
                                        <i class="nav-icon fas fa-handshake"></i>
                                        <p>
                                            Kerjasama
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.usertnc')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "user_tnc") active @endif">
                                        <i class="nav-icon fas fa-address-book"></i>
                                        <p>
                                            Ketentuan Pengguna
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.privacy')  }}" style="text-indent: 10px;"
                                       class="nav-link @if($menu == "privacy") active @endif">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>
                                            Kebijakan Privasi
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
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

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <x-content-header/>

        @yield('mainContent')
    </div>
    <!-- /.content-wrapper -->

    <x-footer/>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@stack('scripts')
</body>
</html>
