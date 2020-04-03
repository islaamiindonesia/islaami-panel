@extends('layouts.master')

@section('contentHeaderTitle', 'Articles')

@section('contentHeaderExtra')
    @parent
@endsection

@section('breadcrumbItem')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.articleCategories.all') }}">Article Categories</a>
    </li>
    <li class="breadcrumb-item active">{{ $categoryName }}</li>
@endsection

@section('mainContent')
    @routes('admin.articleCategories.articles.*')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.articleCategories.articles.create', ['categoryId'=>$categoryID])  }}"
                           type="button" class="btn btn-primary">Add New Article</a>
                    </div>
                    <div class="card-body">
                        <table id="articleTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ date('d F Y', strtotime($article->updated_at)) }}</td>
                                    <td class="project-actions text-left">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.articleCategories.articles.show', ['categoryId' => $article->category_id, 'id'=>$article->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            View
                                        </a>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.articleCategories.articles.edit', ['categoryId' => $article->category_id, 'id'=>$article->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $article->id  }}"
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
            $("#articleTable").DataTable({
                "autoWidth": true,
                "responsive": true,
                "columnDefs": [
                    {
                        "targets": [0],
                        "width":300,
                    },
                    {
                        "targets": [2],
                        "width":300,
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
                text: 'Article ini tidak akan dapat dilihat kembali jika terhapus.',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
                showCancelButton: true,
                preConfirm: (confirmed) => {
                    if (confirmed) {
                        axios.post(route('admin.articleCategories.articles.delete', {
                            categoryId: '{{ $categoryID }}',
                            id: $(this).data("id")
                        }).url()).then(() => {
                                Swal.fire(
                                    'Article Deleted',
                                    'Anda sudah menghapus article ini',
                                    'success'
                                ).then((result) => {
                                    if (result) window.location.href = route('admin.articleCategories.articles.all', {categoryId: '{{ $categoryID }}'});
                                });
                            })
                    }
                },
            })
        });
    </script>
@endpush
