@extends('layouts.master')

@section('contentHeaderTitle', 'Laporan')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
    @routes('admin.reports.*', 'reports.*')
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
                                <option value="unsolved" @if($selected == "unsolved") selected @endif>Belum Selesai
                                </option>
                                <option value="solved" @if($selected == "solved") selected @endif>Selesai</option>
                            </select>
                        </div>
                        <table id="reportTable" class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center">
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $report)
                                <tr style="text-align: center">
                                    <td>{{ $report->user->name }}</td>
                                    <td>
                                        @if($report->is_solved)
                                            Selesai
                                        @else
                                            Belum Selesai
                                        @endif
                                    </td>
                                    <td>{{ date('d F Y', strtotime($report->created_at)) }}</td>
                                    <td class="project-actions text-left">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.reports.show', ['id' => $report->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Laporan
                                        </a>
                                        <a class="btn btn-info btn-sm swalUpdateStatus @if($report->is_solved) disabled @endif"
                                           data-id="{{ $report->id  }}"
                                           href="#" @if($report->is_solved) aria-disabled="true" role="button" @endif>
                                            <i class="fas fa-trash"></i>
                                            Ubah Status
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
        // DataTable
        $(function () {
            $("#reportTable").DataTable({
                "autoWidth": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "width": 300,
                    },
                    {
                        "targets": [3],
                        "orderable": false,
                        "width": 200,
                    }
                ],
            });
            $('#filterDropdown').on('change', function () {
                window.location.href = route('admin.reports.all', {filter: $(this).val()});
            });
        });

        // SweetAlert
        $('.swalUpdateStatus').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Dengan ini maka laporan telah dikerjakan dan status laporan akan berubah menjadi selesai',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.patch(route('reports.verify', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Laporan telah diverifikasi',
                                    text: 'Terima kasih',
                                    preConfirm: (confirmed) => {
                                        if (confirmed) window.location.href = route('admin.reports.all');
                                    }
                                });
                            })
                    }
                },
            })
        });
    </script>
@endpush
