@extends('layouts.master')

@section('contentHeaderTitle', 'Rekomendasi')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="recommendationTable" class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center">
                                <th>Nama Pengguna</th>
                                <th>Nama Kanal</th>
                                <th>URL Kanal</th>
                                <th>Dibuat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recommendations as $recommendation)
                                <tr style="text-align: center">
                                    <td>{{ $recommendation->user->fullname }}</td>
                                    <td>{{ $recommendation->channel_name }}</td>
                                    <td><a href="{{ $recommendation->channel_url }}">Link Channel</a></td>
                                    <td>{{ date('d F Y', strtotime($recommendation->created_at)) }}</td>
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
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
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
            $("#recommendationTable").DataTable({
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
@endpush
