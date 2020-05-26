@extends('layouts.master')

@section('contentHeaderTitle', 'Saluran & Kategori')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
    @routes('admin.categories.all')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.categories.create')  }}" type="button" class="btn btn-primary">Tambah
                            Saluran</a>

                        <button class="btn btn-info" data-toggle="modal" data-target="#modal-default">Ubah Urutan</button>

                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Ubah Urutan</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="categoryList" class="list-group">
                                            @foreach($categories as $category)
                                                <div class="list-group-item" id="#categoryItem"
                                                     data-id="{{ $category->id }}">{{ $category->name }}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btnSave" type="button" class="btn btn-primary float-right"
                                                data-dismiss="modal">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                    </div>
                    <div class="card-body">
                        <form role="form" action="{{ route('admin.categories.all') }}" method="get">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group">
                                        <input name="query" type="search" class="form-control"
                                               placeholder="Cari Saluran" value="{{ $query }}">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-block btn-primary">Cari</button>
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-striped mb-1">
                            <thead>
                            <tr style="text-align: center;">
                                <th>No. Urut</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr style="text-align: center;">
                                    <td>{{ $category->number }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td class="project-actions">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.categories.subcategories.all', ['categoryId' => $category->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Kategori
                                        </a>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.categories.edit', ['categoryId' => $category->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Ubah
                                        </a>
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

                        <div class="float-right pagination">{{ $categories->withQueryString()->links() }}</div>
                    </div>
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
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/toastr/toastr.min.css") }}">
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
    <!-- ScrollableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset("assets/plugins/sweetalert2/sweetalert2.min.js") }}"></script>
    <!-- Toastr -->
    <script src="{{ asset("assets/plugins/toastr/toastr.min.js") }}"></script>
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
        $("#btnSave").click(function () {
            window.location.href = route('admin.categories.all');
        });

        // SweetAlert x Toast
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        // SweetAlert
        $('.swalDelete').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Saluran ini akan dihapus.',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.categories.delete', {categoryId: $(this).data("id")}).url())
                            .then(() => {
                                Swal.fire(
                                    'Berhasil',
                                    'Anda sudah menghapus saluran ini',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.categories.all');
                                });
                            })
                    }
                },
            })
        });

        // Sortable
        const sort = new Sortable(categoryList, {
            animation: 150,
            ghostClass: 'blue-background-class',
            dataIdAttr: 'data-id',
            onUpdate: function () {
                const list = sort.toArray();
                for (let i = 0; i < list.length; i++) {
                    var position = (i + 1);
                    axios.patch(route('admin.categories.updateNumber', {
                        categoryId: list[i],
                        number: position
                    }).url())
                        .then((result) => {
                            if (result) {
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Berhasil membuat perubahan.'
                                })
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Terjadi kesalahan. Mohon coba sesaat lagi.'
                                })
                            }
                        })
                }
            }
        });
    </script>
@endpush
