@extends('layouts.master')

@section('contentHeaderTitle', 'Lihat Laporan')

@section('contentHeaderExtra')
    @parent
@endsection

@section('breadcrumbItem')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.reports.all') }}">Laporan</a>
    </li>
    <li class="breadcrumb-item active">{{ date('d F Y', strtotime($report->created_at)) }}</li>
@endsection

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Video Detail -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Laporan</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Nama Pengguna</strong>

                            <p class="text-muted">
                                {{ $report->user->fullname }}
                            </p>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Laporan</strong>

                            <p class="text-muted">
                                {{ $report->description }}
                            </p>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Lihat Foto</strong>

                            <p class="text-muted">
                                <img class="img-fluid" width="200" data-toggle="modal" data-target="#modal-default"
                                     src="{{ $report->image_url }}" alt="Photo">

                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Lihat Foto</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="text-align: center;">
                                            <img class="img-fluid" style="width:100%;max-width:300px"
                                                 src="{{ $report->image_url }}" alt="Photo">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary float-right"
                                                    data-dismiss="modal"> Tutup
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                            </p>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <form role="form" action="{{ route('admin.reports.verify', ['id'=>$report->id]) }}"
                                  method="post">
                                @method('PATCH')
                                @csrf
                                <button type="submit" class="btn btn-primary" @if($report->is_solved) disabled @endif>
                                    Verify
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
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
