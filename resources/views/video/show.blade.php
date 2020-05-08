@extends('layouts.master')

@section('contentHeaderTitle', 'Show Video')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Video Stats -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Video Stats</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid img-rounded"
                                     src="{{ $video->thumbnail }}"
                                     alt="User profile picture">
                            </div>

                            <ul class="list-group list-group-unbordered mt-3">
                                <li class="list-group-item">
                                    <b>Views</b> <a class="float-right">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Published At</b> <a class="float-right">31/12/2002</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- Channel -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Channel Info</h3>
                        </div>
                        <div class="card-body">
                            <h3 class="profile-username text-center">{{ $video->channel->name }}</h3>

                            <a href="{{ route('admin.channels.show', ['id'=>$video->channel_id]) }}"
                               class="btn btn-outline-primary btn-block"><b>Go to Channel</b></a>
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
                            <h3 class="card-title">Video Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Title</strong>

                            <p class="text-muted">
                                {{ $video->title }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Video URL</strong>

                            <p class="text-muted">
                                <a href="{{ $video->url }}">{{ $video->url }}</a>
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Description</strong>

                            <p class="text-muted">
                                {{ $video->description }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Category</strong>

                            <p class="text-muted">
                                {{ $video->category->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Subcategory</strong>

                            <p class="text-muted">
                                {{ $video->subcategory->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i> Labels</strong>

                            <p class="text-muted">
                                @foreach($video->labels as $label)
                                    <span class="badge badge-pill badge-primary">{{ $label->name }}</span>
                                @endforeach
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
