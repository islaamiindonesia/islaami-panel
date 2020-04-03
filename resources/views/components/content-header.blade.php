<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <h1 class="m-0 text-dark">@yield('contentHeaderTitle')</h1>
            </div><!-- /.col -->
            <div class="col-sm-4">
                @section('contentHeaderExtra')
                    <ol class="breadcrumb float-sm-right">
                        @yield('breadcrumbItem')
                    </ol>
                @show
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
