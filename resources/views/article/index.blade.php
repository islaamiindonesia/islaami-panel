@extends('layouts.master')

@section('contentHeaderTitle', 'Articles')

@section('contentHeaderExtra')
    @parent
@endsection

@section('breadcrumbItem')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.articleCategories.all') }}">Kategori Artikel</a>
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
                           type="button" class="btn btn-primary">Buat Artikel Baru</a>
                    </div>
                    <div class="card-body">
                        <form role="form"
                              action="{{ route('admin.articleCategories.articles.all', ['categoryId'=>$categoryID]) }}"
                              method="get">
                            <div class="row">
                                <div class="col-10">
                                    <div class="form-group">
                                        <input name="query" type="search" class="form-control"
                                               placeholder="Cari Artikel" value="{{ $query }}">
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
                                <th>Judul</th>
                                <th>Dibuat pada</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr style="text-align: center">
                                    <td>{{ $article->title }}</td>
                                    <td>{{ date('d/m/Y', strtotime($article->created_at)) }}</td>
                                    <td class="project-actions text-left">
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('admin.articleCategories.articles.show', ['categoryId' => $article->category_id, 'id'=>$article->id]) }}">
                                            <i class="fas fa-folder"></i>
                                            Lihat Artikel
                                        </a>
                                        <a class="btn btn-info btn-sm"
                                           href="{{ route('admin.articleCategories.articles.edit', ['categoryId' => $article->category_id, 'id'=>$article->id]) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            Ubah
                                        </a>
                                        <a class="btn btn-danger btn-sm swalDelete" data-id="{{ $article->id  }}"
                                           href="#">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="float-right pagination">{{ $articles->withQueryString()->links() }}</div>
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
        $('.swalDelete').click(function () {
            Swal.fire({
                icon: 'question',
                title: 'Apakah Anda yakin ?',
                text: 'Artikel ini akan dihapus.',
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
                                'Berhasil',
                                'Artikel berhasil dihapus',
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
