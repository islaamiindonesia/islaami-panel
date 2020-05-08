@extends('layouts.master')

@section('contentHeaderTitle', 'Manage Role')

@section('contentHeaderExtra')
    <a href="{{ route('admin.roles.create')  }}" type="button" class="btn btn-primary float-right">Create New Role</a>
@endsection

@section('mainContent')
    @routes('admin.roles')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="roleTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td class="project-actions text-left">
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.roles.edit',['id'=>$role->id]) }}">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $role->id  }}"
                                           href="#">
                                            <i class="fas fa-trash"></i>
                                            Delete
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
            $("#roleTable").DataTable({
                "autoWidth": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": [2],
                        "orderable": false,
                    }
                ],
            });
            $('#filterDropdown').on('change', function () {
                window.location.href = route('admin.users.all', {filter: $(this).val()});
            });

            // SweetAlert
            $('.swalDelete').click(function () {
                Swal.fire({
                    icon: 'question',
                    title: 'Apakah Anda yakin ?',
                    text: 'Role ini akan dihapus',
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Batal',
                    showCancelButton: true,
                    preConfirm: (confirmed) => {
                        if (confirmed) {
                            axios.post(route('admin.roles.delete', {id: $(this).data("id")}).url())
                                .then(() => {
                                    Swal.fire(
                                        'Role Deleted',
                                        'Role berhasil dihapus',
                                        'success'
                                    ).then((response) => {
                                        if (response) window.location.href = route('admin.roles.manage');
                                    });
                                })
                        }
                    },
                })
            });
        });
    </script>
@endpush
