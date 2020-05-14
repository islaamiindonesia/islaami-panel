@extends('layouts.master')
@section('contentHeaderTitle', 'Video')

@section('contentHeaderExtra')
    <a href="{{ route('admin.videos.create')  }}" type="button" class="btn btn-primary float-right">Unggah Video</a>
@endsection

@section('mainContent')
    @routes('admin.videos.*')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- select -->
                        <div class="form-group">
                            <label>Tampilkan</label>
                            <select class="form-control" id="filterDropdown">
                                <option value="published" @if($selected == "published") selected @endif>Diunggah
                                <option value="draft" @if($selected == "draft") selected @endif>Draft</option>
                                </option>
                            </select>
                        </div>
                        <table id="videoTable" class="table table-bordered table-striped display" style="width:100%">
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
                                    <td>
                                        <img src="{{ $video->thumbnail }}" width="120">
                                        <br>
                                        {{ $video->title }}
                                    </td>
                                    <td>{{ $video->views->count() }}x</td>
                                    <td>
                                        @if($video->published_at != null)
                                            {{ date('d/m/Y', strtotime($video->published_at)) }}
                                        @else
                                            -
                                        @endif
                                    </td>
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
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $video->id  }}"
                                           href="#">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
        $("#videoTable").DataTable({
            "autoWidth": true,
            "responsive": true,
            "columnDefs": [
                {
                    "targets": [0, 1, 2],
                    "width": 100
                },
                {
                    "targets": [3],
                    'width': 200,
                    "orderable": false,
                }
            ],
        });
        $('#filterDropdown').on('change', function () {
            window.location.href = route('admin.videos.all', {filter: $(this).val()});
        });

        // SweetAlert
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
