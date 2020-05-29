@extends('layouts.master')

@section('contentHeaderTitle', 'Edit Video')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
    @routes('categories.*')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" action="{{ route('admin.videos.update', ['id'=> $video->id]) }}"
                              method="post">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input name="title" type="text" class="form-control" placeholder="Enter video title"
                                           value="{{$video->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="url">Link Youtube</label>
                                    <input name="url" type="text" class="form-control" value="{{$video->url}}">
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi <small>(opsional)</small></label>
                                    <textarea name="description" class="textarea" placeholder="Place some text here"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        {{$video->description}}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label>Kanal</label>
                                    <select name="channel" class="form-control select2" style="width: 100%;">
                                        <option value="">Pilih Channel</option>
                                        @foreach($channels as $channel)
                                            <option value="{{ $channel->id }}"
                                                    @if($video->channel->id == $channel->id) selected @endif>
                                                {{ $channel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Saluran</label>
                                    <select id="category" name="category" class="form-control select2"
                                            style="width: 100%;">
                                        <option value="">Pilih Saluran</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($video->category->id == $category->id) selected @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Kategori <small>(opsional)</small></label>
                                    <select id="subcategory" name="subcategory" class="form-control select2"
                                            style="width: 100%;">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                    @if($video->subcategory != null && $video->subcategory->id == $subcategory->id) selected @endif>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Label <small>(opsional)</small></label>
                                    <select id="label" name="labels[]" class="select2" multiple="multiple"
                                            data-placeholder="Pilih Label" style="width: 100%;">
                                        <option value="">Pilih Label</option>
                                        @if($video->subcategory)
                                            @php($labels = \App\Label::where('subcategory_id', $video->subcategory->id)->get()->toArray())
                                            @if(!empty($labels))
                                                @for($i = 0; $i < count($labels); $i++)
                                                    <option value="{{ $labels[$i]["id"] }}"
                                                            @if($video->labels->contains($labels[$i]["id"])) selected @endif>
                                                        {{ $labels[$i]["name"] }}
                                                    </option>
                                                @endfor
                                            @endif
                                        @endif
                                    </select>
                                </div>


                                <!-- time Picker -->
                                @php($published_at = \Carbon\Carbon::make($video->published_at)->toDateTimeString())
                                <div class="form-group">
                                    <label>Waktu Publikasi</label>
                                    <div class="icheck-material-blue">
                                        <input type="radio" id="now" name="publishNow" value="on"
                                               @if($video->is_published_now == true) checked @endif />
                                        <label for="now">Segera</label>
                                    </div>
                                    <div class="icheck-material-blue">
                                        <input type="radio" id="later" name="publishNow" value="off"
                                               @if($video->is_published_now == false) checked @endif />
                                        <label for="later">Atur Jadwal</label>
                                    </div>
                                    <div class="input-group date" id="timepicker" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#timepicker"
                                             data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                        <input id="timeField" name="publishedAt"
                                               @if($video->is_published_now == true)
                                               disabled
                                               @else
                                               placeholder="{{ date("d/m/Y H:i", strtotime($published_at)) }}"
                                               @endif
                                               type="text" class="form-control datetimepicker-input"
                                               value="{{ date("d/m/Y H:i", strtotime($published_at)) }}"
                                               data-target="#timepicker"/>
                                    </div>

                                    <div class="form-group">
                                        <div class="icheck-material-blue">
                                            <input type="checkbox" id="show" name="showUpload" @if($video->is_upload_shown) checked @endif />
                                            <label for="show">Tampilkan Waktu Unggah</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="action" value="publish">
                                        Terbitkan
                                    </button>
                                    <button type="submit" class="btn btn-link" name="action" value="draft"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Video ini tidak akan dipublikasi">
                                        Simpan Sebagai Draft
                                    </button>
                                </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

<!-- STYLES & SCRIPTS -->
@prepend('styles')
    <!-- iCheckMaterial CSS -->
    <link rel="stylesheet" href="{{ asset("assets/dist/css/icheck-material.css") }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/fontawesome-free/css/all.min.css") }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset("assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css") }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/select2/css/select2.min.css") }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset("assets/plugins/summernote/summernote-bs4.css") }}">
    <!-- Theme style -->
    <link rel=" stylesheet" href="{{ asset("assets/dist/css/adminlte.min.css") }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
@endprepend

@push('scripts')
    <!-- jQuery -->
    <script src="{{ asset("assets/plugins/jquery/jquery.min.js") }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- Select2 -->
    <script src="{{ asset("assets/plugins/select2/js/select2.full.min.js") }}"></script>
    <!-- Moment JS -->
    <script src="{{ asset("assets/plugins/moment/moment.min.js") }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset("assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
    <!-- Summernote -->
    <script src="{{ asset("assets/plugins/summernote/summernote-bs4.min.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // tooltip
            $('[data-toggle="tooltip"]').tooltip();

            //Initialize Select2 Elements
            $('.select2').select2();

            // Summernote
            $('.textarea').summernote({
                height: 300,
            });

            $('#category').on('change', function () {
                let selectedCategoryID = $(this).find(':selected').attr('value');
                $('#subcategory').empty();
                $('#label').empty();
                $('#subcategory').append('<option value="">Pilih Kategori </option>');
                $('#label').append('<option value="">Pilih Label</option>');

                if (selectedCategoryID) {
                    $.ajax({
                        url: route('allSubcategories', {categoryId: selectedCategoryID}),
                        success: function (response) {
                            for (let i = 0; i < response.data.length; i++) {
                                let id = response.data[i].id;
                                let name = response.data[i].name;
                                $('#subcategory').append('<option value="' + id + '">' + name + '</option>');
                            }
                        }
                    })
                }
            });

            $('#subcategory').on('change', function () {
                let selectedCategoryID = $(this).find(':selected').attr('value');
                let selectedSubcategoryID = $(this).find(':selected').attr('value');
                $('#label').empty();
                $('#label').append('<option value="">Pilih Label</option>');

                if (selectedSubcategoryID) {
                    $.ajax({
                        url: route('allLabels', {categoryId: selectedCategoryID, subcategoryId: selectedSubcategoryID}),
                        success: function (response) {
                            for (let i = 0; i < response.data.length; i++) {
                                let id = response.data[i].id;
                                let name = response.data[i].name;
                                $('#label').append('<option value="' + id + '">' + name + '</option>');
                            }
                        }
                    })
                }
            });

            //Timepicker
            $('#timepicker').datetimepicker(
                {
                    format: 'DD/MM/YYYY HH:mm',
                    icons:
                        {
                            time: 'fas fa-clock',
                            date: 'fas fa-calendar',
                            up: 'fas fa-arrow-up',
                            down: 'fas fa-arrow-down',
                            previous: 'fas fa-arrow-circle-left',
                            next: 'fas fa-arrow-circle-right',
                            today: 'far fa-calendar-check-o',
                            clear: 'fas fa-trash',
                            close: 'far fa-times'
                        },
                });

            $('#now').change(
                function () {
                    if ($(this).is(':checked')) {
                        $('#timeField').attr('disabled', true);
                        $('#timeField').attr('required', false);
                        $('#timeField').attr('placeholder', '');
                        $('#timeField').val('')
                    }
                });

            $('#later').change(
                function () {
                    if ($(this).is(':checked')) {
                        $('#timeField').attr('disabled', false);
                        $('#timeField').attr('required', true);
                        $('#timeField').val('{{ date("d/m/Y H:i", strtotime($published_at)) }}')
                    }
                });
        });
    </script>
@endpush
