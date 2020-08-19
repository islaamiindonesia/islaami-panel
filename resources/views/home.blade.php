@extends('layouts.master')

@section('contentHeaderTitle', 'Beranda')

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                @if(Auth::user()->hasAnyRole(['islaami','super admin']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $users->count() }}</h3>

                                <p>User Terdaftar</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            @if(!Auth::user()->hasRole('super admin'))
                                <a href="{{ route('admin.users.all') }}" class="small-box-footer">Lihat Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                @endif
                @if(Auth::user()->hasAnyRole(['playmi','super admin']))
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $videos->count() }}</h3>

                                <p>Video Playmi</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-videocam"></i>
                            </div>
                            @if(!Auth::user()->hasRole('super admin'))
                                <a href="{{ route('admin.videos.all') }}" class="small-box-footer">Lihat Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-gradient-indigo">
                            <div class="inner">
                                <h3>{{ $channels->count() }}</h3>

                                <p>Jumlah Kanal</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-social-youtube"></i>
                            </div>
                            @if(!Auth::user()->hasRole('super admin'))
                                <a href="{{ route('admin.channels.all') }}" class="small-box-footer">Lihat Selengkapnya <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

{{-- STYLES & SCRIPTS --}}
@prepend('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/jqvmap/jqvmap.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/daterangepicker/daterangepicker.css") }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/summernote/summernote-bs4.css") }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endprepend

@push('scripts')
    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset("assets/plugins/jquery-ui/jquery-ui.min.js") }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset("assets/plugins/chart.js/Chart.min.js") }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset("assets/plugins/sparklines/sparkline.js") }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset("assets/plugins/jqvmap/jquery.vmap.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/jqvmap/maps/jquery.vmap.usa.js") }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset("assets/plugins/jquery-knob/jquery.knob.min.js") }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset("assets/plugins/moment/moment.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/daterangepicker/daterangepicker.js") }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}"></script>
    <!-- Summernote -->
    <script src="{{ asset("assets/plugins/summernote/summernote-bs4.min.js") }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.js") }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset("assets/dist/js/pages/dashboard.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
@endpush
