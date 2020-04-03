@extends('layouts.master')

@section('contentHeaderTitle', 'Artikel')

@section('contentHeaderExtra')
    <a href="{{ route('admin.articleCategories.create')  }}" type="button" class="btn btn-primary float-right">Buat
        Kategori</a>
@endsection

@section('mainContent')
    @routes('admin.articleCategories.*')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="categoryTable" class="table table-bordered table-striped">
                            <thead>
                            <tr style="text-align: center">
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr style="text-align: center">
                                    <td>{{ $category->name }}</td>
                                    <td class="project-actions">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.articleCategories.articles.all', ['categoryId' => $category->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Artikel
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#" data-toggle="modal"
                                           data-target="#modal-default">
                                            <i class="fas fa-pencil-alt"></i>
                                            Ubah
                                        </a>

                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Ubah Kategori</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form role="form"
                                                          action="{{ route('admin.articleCategories.update', ['id'=>$category->id]) }}"
                                                          method="post">
                                                        <div class="modal-body">
                                                            @method('PUT')
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="name">Nama Kategori</label>
                                                                <input type="text" name="name" class="form-control"
                                                                       required
                                                                       placeholder="Masukkan nama kategori"
                                                                       value="{{$category->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $category->id  }}"
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
        // DataTable
        $(function () {
            $("#categoryTable").DataTable({
                "autoWidth": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets":[0,1],
                        "width":200
                    },
                    {
                        "targets": [1],
                        "orderable": false,
                    }
                ],
            });
        });

        // SweetAlert
        $('.swalDelete').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Kategori ini akan dihapus.',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.articleCategories.delete', {id: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire(
                                    'Berhasil',
                                    'Anda sudah menghapus kategori ini',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.articleCategories.all');
                                });
                            })
                    }
                },
            })
        });
    </script>
@endpush
