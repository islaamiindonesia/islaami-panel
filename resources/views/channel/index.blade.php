@extends('layouts.master')

@section('contentHeaderTitle', 'Kanal')

@section('contentHeaderExtra')
    <a href="{{ route('admin.channels.create')  }}" type="button" class="btn btn-primary float-right">Buat Kanal</a>
@endsection

@section('mainContent')
    @routes('admin.channels.all')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- select -->
                        <div class="form-group">
                            <label>Tampilkan</label>
                            <select class="form-control" id="filterDropdown">
                                <option value="active" @if($selected == "active") selected @endif>Aktif</option>
                                <option value="suspended" @if($selected == "suspended") selected @endif>Ditangguhkan
                                </option>
                            </select>
                        </div>
                        <table id="channelTable" class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center;">
                                <th>Thumbnail</th>
                                <th>Nama Kanal</th>
                                <th>Video</th>
                                <th>Pengikut</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($channels as $channel)
                                <tr style="text-align: center;">
                                    <td>
                                        <img src="{{ asset('storage/'. $channel->thumbnail) }}" width="100"/></td>
                                    <td>
                                        <a href="{{ route('admin.channels.show', ['id' => $channel->id]) }}">
                                            {{ $channel->name }}
                                        </a>
                                    </td>
                                    <td>{{ $channel->videos }}</td>
                                    <td>{{ $channel->followers }}</td>
                                    <td>{{ date('d-M-Y', strtotime($channel->created_at) )}}</td>
                                    <td class="project-actions">
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.channels.edit', ['id' => $channel->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Ubah
                                        </a>
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $channel->id  }}"
                                           href="#">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                        @if($channel->suspended_at)
                                            <a class="btn btn-warning btn-sm swalActivate" data-id="{{ $channel->id  }}"
                                               href="#">
                                                <i class="fas fa-lock-open"></i>
                                                Aktifkan
                                            </a>
                                        @else
                                            <a class="btn btn-warning btn-sm swalSuspend" data-id="{{ $channel->id  }}"
                                               href="#">
                                                <i class="fas fa-lock"></i>
                                                Tangguhkan
                                            </a>
                                        @endif
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
        // DataTable
        $(function () {
            $("#channelTable").DataTable({
                "autoWidth": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "width": 100,
                    },
                    {
                        "targets": [5],
                        "width": 250,
                        "orderable": false,
                    }
                ],
            });
            $('#filterDropdown').on('change', function () {
                window.location.href = route('admin.channels.all', {filter: $(this).val()});
            });
        });

        // SweetAlert
        $('.swalDelete').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Channel ini tidak akan dapat dilihat kembali jika terhapus.',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.channels.delete', [$(this).data("id")]).url())
                            .then(() => {
                                Swal.fire(
                                    'Channel Deleted',
                                    'Anda sudah menghapus channel ini',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.channels.all');
                                });
                            })
                    }
                },
            })
        });

        $('.swalActivate').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Channel ini akan diaktivasi kembali',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.patch(route('admin.channels.activate', [$(this).data("id")]).url())
                            .then(() => {
                                Swal.fire(
                                    'Channel Activated',
                                    'Channel ini telah diaktifkan kembali',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.channels.all');
                                });
                            })
                    }
                },
            })
        });

        $('.swalSuspend').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Channel ini akan ditangguhkan',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.patch(route('admin.channels.suspend', [$(this).data("id")]).url())
                            .then(() => {
                                Swal.fire(
                                    'Channel Suspended',
                                    'Channel ini telah ditangguhkan',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.channels.all');
                                });
                            })
                    }
                },
            })
        });
    </script>
@endpush
