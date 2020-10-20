@extends('layouts.master')

@section('contentHeaderTitle', 'Lihat Detail Kanal')

@section('contentHeaderExtra')
    <a href="{{ route('admin.channels.edit', ['id'=>$channel->id]) }}" type="button"
       class="btn btn-primary float-right">Edit Kanal</a>
@endsection

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Info Kanal</h3>
                        </div>
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="img-fluid img-rounded" width="200"
                                     src="{{ asset('storage/'. $channel->thumbnail) }}"
                                     alt="User profile picture">
                            </div>

                            <ul class="list-group list-group-unbordered mt-3">
                                <li class="list-group-item">
                                    <b>Pengikut</b> <a class="float-right">{{ $channel->followers->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Video</b> <a class="float-right">{{ $channel->videos->count() }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Dibuat Pada</b> <a
                                        class="float-right">{{ date('d/m/Y', strtotime($createdAt)) }}</a>
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
                            <h3 class="card-title">Detail Kanal</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-desktop mr-1"></i> Nama Kanal</strong>

                            <p class="text-muted">
                                {{ $channel->name }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-file-alt mr-1"></i> Deskripsi</strong>

                            <p class="text-muted">
                                {!! $channel->description !!}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <div class="row">
                @routes('admin.videos.*')
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form role="form" action="{{ route('admin.channels.show', ['id'=>$channel->id]) }}" method="get">
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
                                                            Diunggah Terkini
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
                                    <th>Waktu Upload</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $video)
                                    <tr style="text-align: center;">
                                        <td style="width:300px; max-width: 300px">
                                            <img src="https://img.youtube.com/vi/{{ $video->video_id }}/sddefault.jpg" width="120">
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
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset("assets/plugins/sweetalert2/sweetalert2.min.js") }}"></script>
    <!-- DataTables -->
    <script src="{{ asset("assets/plugins/datatables/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") }}"></script>
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
                                        if (confirmed) window.location.href = route('admin.channels.show', {id: '{{ $channel->id }}'});
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
                                        if (confirmed) window.location.href = route('admin.channels.show', {id: '{{ $channel->id }}'});
                                    }
                                });
                            })
                    }
                },
            })
        });

        $('.swalDelete').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Video ini tidak akan dapat dilihat kembali jika terhapus.',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.videos.delete', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Video Deleted',
                                    text: 'Anda sudah menghapus video ini',
                                    preConfirm: (confirmed) => {
                                        if (confirmed) window.location.href = route('admin.channels.show', {id: '{{ $channel->id }}'});
                                    }
                                });
                            })
                    }
                },
            });
        });
    </script>
@endpush
