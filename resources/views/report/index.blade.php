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
                        <form role="form" action="{{ route('admin.reports.all') }}" method="get">
                            <div class="row">
                                <div class="col-2">
                                    <!-- filter -->
                                    <div class="form-group">
                                        <select class="form-control" name="filterBy">
                                            @foreach(["solved", "unsolved"] as $col)
                                                <option @if($col == $filterBy) selected @endif value="{{ $col }}">
                                                    @if($col == "solved")
                                                        Selesai
                                                    @else
                                                        Belum Selesai
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-block btn-primary">Tampilkan</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped mb-1">
                            <thead>
                            <tr style="text-align: center">
                                <th>Nama</th>
                                <th>Dibuat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports as $report)
                                <tr style="text-align: center">
                                    <td>{{ $report->user->fullname }}</td>
                                    <td>{{ date('d/m/Y', strtotime($report->created_at)) }}</td>
                                    <td>
                                        @if($report->is_solved)
                                            Selesai
                                        @else
                                            Belum Selesai
                                        @endif
                                    </td>
                                    <td class="project-actions">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.reports.show', ['id' => $report->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Laporan
                                        </a>
                                        @if($report->is_solved)
                                            <a class="btn btn-info btn-sm swalUpdateStatus @if($report->is_solved) disabled @endif"
                                               data-id="{{ $report->id  }}"
                                               href="#" @if($report->is_solved) aria-disabled="true"
                                               role="button" @endif>
                                                <i class="fas fa-trash"></i>
                                                Tandai Selesai
                                            </a>
                                        @else
                                            <a class="btn btn-info btn-sm swalUpdateStatus @if($report->is_solved) disabled @endif"
                                               data-id="{{ $report->id  }}"
                                               href="#" @if($report->is_solved) aria-disabled="true"
                                               role="button" @endif>
                                                <i class="fas fa-trash"></i>
                                                Tandai Selesai
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="float-right pagination">{{ $reports->withQueryString()->links() }}</div>
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
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
    <!-- page script -->
    <script>
        // SweetAlert
        $('.swalUpdateStatus').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Dengan ini maka status laporan akan berubah menjadi selesai dan tidak dapat diubah kembali',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.patch
                        (
                            route('admin.reports.verify').url(),
                            {
                                id: $(this).data("id")
                            }
                        ).then(() => {
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
