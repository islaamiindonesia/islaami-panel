@extends('layouts.master')

@section('contentHeaderTitle', 'Profil Kanal')

@section('contentHeaderExtra')
    <a href="{{ route('admin.channels.edit', ['id'=>$channel->id]) }}" type="button"
       class="btn btn-primary float-right">Update Kanal</a>
@endsection

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Umum</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid img-rounded" width="200"
                                     src="{{ asset('storage/'. $channel->thumbnail) }}"
                                     alt="User profile picture">
                            </div>

                            <ul class="list-group list-group-unbordered mt-3">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Videos</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Created At</b> <a
                                        class="float-right">{{ date('d-m-Y', strtotime($createdAt)) }}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- right column -->
                <div class="col-md-9">
                    <!-- Video Detail -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Rincian</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Nama Kanal</strong>

                            <p class="text-muted">
                                {{ $channel->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Deskripsi</strong>

                            <p class="text-muted">
                                {{ $channel->description }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

<!-- STYLES & SCRIPTS -->
@prepend('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endprepend

@push('scripts')
    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
@endpush
