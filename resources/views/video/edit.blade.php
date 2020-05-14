@extends('layouts.master')

@section('contentHeaderTitle', 'Edit Video')

@section('contentHeaderExtra')
@endsection

@section('mainContent')
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
                                    <label for="title">Title</label>
                                    <input name="title" type="text" class="form-control" placeholder="Enter video title"
                                           value="{{$video->title}}">
                                </div>
                                <div class="form-group">
                                    <label for="url">Video URL</label>
                                    <input name="url" type="text" class="form-control" value="{{$video->url}}">
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="textarea" placeholder="Place some text here"
                                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                        {{$video->description}}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label>Channel</label>
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
                                    <label>Category</label>
                                    <select id="category" name="category" class="form-control select2"
                                            style="width: 100%;">
                                        <option value="">Pilih Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                    @if($video->category->id == $category->id) selected @endif>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Subcategory</label>
                                    <select id="subcategory" name="subcategory" class="form-control select2"
                                            style="width: 100%;">
                                        <option value="">Pilih Subcategory</option>
                                        @if($video->subcategory->name != "")
                                            @foreach($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}"
                                                        @if($video->subcategory->id == $subcategory->id) selected @endif>
                                                    {{ $subcategory->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Label</label>
                                    <select id="label" name="labels[]" class="select2" multiple="multiple"
                                            data-placeholder="Pilih Label" style="width: 100%;">
                                        <option value="">Pilih Label</option>
                                        @if(count($selectedLabels) > 0)
                                            @for($i = 0; $i < count($labels); $i++)
                                                <option value="{{ $labels[$i]->id }}"
                                                        @if($selectedLabels->contains($labels[$i]->id)) selected @endif>
                                                    {{ $labels[$i]->name }}
                                                </option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>

                                <!-- time Picker -->
                                <div class="form-group">
                                    <label>Upload</label>
                                    <input class="form-control" type="checkbox" name="upload" disabled
                                           data-bootstrap-switch>
                                    <div class="input-group date" id="datetimePicker" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#datetimePicker">
                                            <div class="input-group-text"><i class="far fa-clock"></i></div>
                                        </div>
                                        <input data-toggle="datetimepicker" type="text" name="published"
                                               class="form-control datetimepicker-input"
                                               data-target="#datetimePicker" placeholder="{{ $publishedAt }}" disabled/>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <!-- /.form group -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
    <!-- Bootstrap Switch -->
    <script src="{{ asset("assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js") }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("assets/dist/js/adminlte.min.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset("assets/dist/js/demo.js") }}"></script>
    <!-- Summernote -->
    <script src="{{ asset("assets/plugins/summernote/summernote-bs4.min.js") }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            //Initialize Select2 Elements
            $('.select2').select2();

            // Summernote
            $('.textarea').summernote();

            $('#category').on('change', function () {
                let selectedCategoryID = $(this).find(':selected').attr('value');
                $('#subcategory').empty();

                if (selectedCategoryID) {
                    axios.get(route('categories.subcategories.all', {categoryId: selectedCategoryID}))
                        .then((response) => {
                            $('#subcategory').append('<option value="">Pilih Subcategory</option>');
                            for (let i = 0; i < response.data.length; i++) {
                                let id = response.data[i].id;
                                let name = response.data[i].name;
                                $('#subcategory').append('<option value="' + id + '">' + name + '</option>');
                            }
                        })
                }
            });

            $('#subcategory').on('change', function () {
                let selectedCategoryID = $(this).find(':selected').attr('value');
                let selectedSubcategoryID = $(this).find(':selected').attr('value');
                $('#label').empty();

                if (selectedSubcategoryID) {
                    axios.get(route('categories.subcategories.labels.all', {
                        categoryId: selectedCategoryID,
                        subcategoryId: selectedSubcategoryID
                    })).then((response) => {
                        $('#label').append('<option value="">Pilih Label</option>');
                        for (let i = 0; i < response.data.length; i++) {
                            let id = response.data[i].id;
                            let name = response.data[i].name;
                            $('#label').append('<option value="' + id + '">' + name + '</option>');
                        }
                    })
                }
            });

            //Datetime Picker
            $.fn.datetimepicker.Constructor.Default = $.extend({}, $.fn.datetimepicker.Constructor.Default, {
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check-o',
                    clear: 'far fa-trash',
                    close: 'far fa-times'
                }
            });
            $('#datetimePicker').datetimepicker();

            // Bootstrap Switch
            $.fn.bootstrapSwitch.defaults.onText = 'Today';
            $.fn.bootstrapSwitch.defaults.offText = 'Later';

            let published = "{{ $publishedAt }}";
            let todayDate = "{{ \Carbon\Carbon::now()->toDateTimeString() }}";
            if (published === todayDate) {
                $.fn.bootstrapSwitch.defaults.state = true
            } else {
                $.fn.bootstrapSwitch.defaults.state = false
            }

            $("input[data-bootstrap-switch]").bootstrapSwitch({
                onInit: function (event, state) {
                    $('#datetimePicker > .form-control').prop('disabled', state);
                },
                onSwitchChange: function (event, state) {
                    $('#datetimePicker > .form-control').prop('disabled', state);
                    if (state) {
                        $('#datetimePicker').datetimepicker('clear');
                    }
                }
            });
        });
    </script>
@endpush
