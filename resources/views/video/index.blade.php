@extends('layouts.master')
@section('contentHeaderTitle', 'Video')

@section('contentHeaderExtra')
    <a href="{{ route('admin.videos.create')  }}" type="button" class="btn btn-primary float-right">Unggah Video</a>
    {{--    <a href="{{ route('admin.videos.draft')  }}" type="button" class="btn btn-primary float-right mr-1">Lihat Draf</a>--}}
@endsection

@section('mainContent')
    @routes('admin.videos.*')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form role="form" action="{{ route('admin.videos.all') }}" method="get">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input name="query" type="search" class="form-control"
                                               placeholder="Cari Judul" value="{{ $query }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <!-- filter -->
                                    <div class="form-group">
                                        <select class="form-control" name="isPublished">
                                            <option @if($isPublished == "true") selected @endif value="true">Diunggah
                                            </option>
                                            <option @if($isPublished == "false") selected @endif value="false">Draft
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <!-- sort -->
                                    <div class="form-group">
                                        <select class="form-control" name="sortBy">
                                            @foreach(["created_at", "views"] as $col)
                                                <option @if($col == $sortBy) selected @endif value="{{ $col }}">
                                                    @if($col == "created_at")
                                                        Dibuat Terbaru
                                                    @else
                                                        Ditonton Terbanyak
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-block btn-primary">Terapkan</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped display mb-1" style="width:100%">
                            <thead>
                            <tr style="text-align: center">
                                <th>Judul Video</th>
                                <th>Ditonton</th>
                                <th>Diunggah Pada</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($videos as $video)
                                <tr style="text-align: center;">
                                    <td style="width:300px; max-width: 300px">
                                        <img src="{{ $video->thumbnail }}" width="120">
                                        <br>
                                        <a href="{{ route('admin.videos.show', ['id'=>$video->id]) }}">{{ $video->title }}</a>
                                    </td>
                                    <td>{{ $video->views()->count() }}x</td>
                                    <td>{{ date('d/m/Y', strtotime($video->created_at)) }}</td>
                                    <td class="project-actions" style="text-align: center;">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.videos.show', ['id' => $video->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Detail
                                        </a>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.videos.edit', ['id' => $video->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Ubah
                                        </a>
                                        @if($video->is_published)
                                            <a class="btn btn-secondary btn-sm swalDraft" data-id="{{ $video->id }}"
                                               href="#">
                                                <i class="fas fa-archive"></i>
                                                Draft
                                            </a>
                                        @else
                                            <a class="btn btn-secondary btn-sm swalUpload" data-id="{{ $video->id }}"
                                               href="#">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                Upload
                                            </a>
                                        @endif
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $video->id }}"
                                           href="#">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="float-right pagination">{{ $videos->withQueryString()->links() }}</div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

{{-- STYLES & SCRIPTS --}}
@prepend('styles')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css") }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endprepend

@push('scripts')
    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Moment JS -->
    <script src="{{ asset("assets/plugins/moment/moment.min.js") }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset("assets/plugins/sweetalert2/sweetalert2.min.js") }}"></script>
    <!-- DataTables -->
    <script src="{{ asset("assets/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
    <script src="{{ asset("assets/dist/js/datetime-moment.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
    <!-- page script -->
    <script>
        // SweetAlert
        $('.swalUpload').on('click', function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Video ini akan dipublikasikan',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.videos.upload', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Video sudah dipublikasikan',
                                    preConfirm: (confirmed) => {
                                        if (confirmed) window.location.href = route('admin.videos.all');
                                    }
                                });
                            })
                    }
                },
            })
        });

        $('.swalDraft').on('click', function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Video ini tidak akan dipublikasi',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.videos.draft', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Video sudah tersimpan sebagai draft',
                                    preConfirm: (confirmed) => {
                                        if (confirmed) window.location.href = route('admin.videos.all');
                                    }
                                });
                            })
                    }
                },
            })
        });

        $('.swalDelete').on('click', function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Video ini akan dihapus',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.videos.delete', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Anda sudah menghapus video ini',
                                    preConfirm: (confirmed) => {
                                        if (confirmed) window.location.href = route('admin.videos.all');
                                    }
                                });
                            })
                    }
                },
            })
        });
    </script>
@endpush
