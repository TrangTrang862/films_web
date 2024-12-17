@extends('layouts.dashboard.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('web_files/css/bootstrap-fileinput.css') }}">
        <link href="{{ asset('dashboard_files/assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />

        <style>
            .form-group {
                margin-top: 15px;
            }

            .custom-file-input {
                cursor: pointer;
            }

            .custom-file-label::after {
                content: "Browse";
                cursor: pointer;
            }

            .custom-file-label {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .upload-button {
                display: none;
                margin-top: 10px;
            }

            .progress {
                display: none;
                margin-top: 10px;
            }
        </style>
    @endpush

    <section class="content">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-5 col-sm-12">
                    <h2>Add Film
                        <small>Welcome to Films</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                Films</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Films</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Add</strong> Films</h2>
                        </div>

                        <div class="body">
                            <form id="film-form" action="{{ route('dashboard.films.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="header col-lg-12 col-md-12 col-sm-12">
                                    <h2>Main Information</h2>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name"
                                                value="{{ old('name', '') }}">
                                            <span style="color: red; margin-left: 10px">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="year" class="form-control" placeholder="Year"
                                                value="{{ old('year', '') }}">
                                            <span style="color: red;margin-left: 10px">{{ $errors->first('year') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categories and Actors -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <select class="form-control z-index show-tick" name="categories[]"
                                            data-live-search="true" multiple>
                                            <option selected disabled>- Select Categories -</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span
                                            style="color: red;margin-left: 10px">{{ $errors->first('categories') }}</span>
                                    </div>
                                </div>
                                <br>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <select class="form-control z-index show-tick" name="actors[]"
                                            data-live-search="true" multiple>
                                            <option selected disabled>- Select Actors -</option>
                                            @foreach ($actors as $actor)
                                                <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                                            @endforeach
                                        </select>
                                        <span style="color: red;margin-left: 10px">{{ $errors->first('actors') }}</span>
                                    </div>
                                </div>

                                <br>

                                <!-- Film Overview -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="overview" rows="4" class="form-control no-resize" placeholder="Film Overview">{{ old('overview', '') }}</textarea>
                                            <span
                                                style="color: red; margin-left: 10px">{{ $errors->first('overview') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Film video -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="video" rows="4" class="form-control no-resize" placeholder="Film Video">{{ old('video', '') }}</textarea>
                                            <span
                                                style="color: red; margin-left: 10px">{{ $errors->first('video') }}</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- <!-- Video Upload -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="video-upload" class="form-label">Upload Video</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="video-upload"
                                                    name="video">
                                                <label class="custom-file-label" for="video-upload">Choose file...</label>
                                            </div>
                                            <!-- Progress Bar -->
                                            <div class="progress">
                                                <div id="progress-bar"
                                                    class="progress-bar progress-bar-striped progress-bar-animated"
                                                    role="progressbar" style="width: 0%;" aria-valuenow="0"
                                                    aria-valuemin="0" aria-valuemax="100">0%</div>
                                            </div>
                                            <span class="text-danger"
                                                style="margin-left: 10px;">{{ $errors->first('video') }}</span>
                                            <!-- Upload Button -->
                                            <button type="button" class="btn btn-success upload-button" id="upload-button"
                                                disabled>Upload Video</button>
                                        </div>

                                        <style>
                                            /* Style for disabled button */
                                            .btn:disabled {
                                                background-color: gray;
                                                /* Gray color for disabled button */
                                                border-color: gray;
                                                /* Gray border color */
                                                cursor: not-allowed;
                                                /* Cursor change to indicate disabled state */
                                            }
                                        </style>


                                    </div>
                                </div> --}}

                                <!-- Background Cover Upload -->
                                <div class="form-group last">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                alt="" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-dark btn-file">
                                                <span class="fileinput-new"> Select Film Background_Cover </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="background_cover"
                                                    value="{{ old('background_cover', '') }}">
                                            </span>
                                            <a href="" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <span
                                            style="color: red; margin-left: 10px">{{ $errors->first('background_cover') }}</span>
                                    </div>
                                </div>

                                <!-- Film Poster Upload -->
                                <div class="form-group last">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image"
                                                alt="" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-dark btn-file">
                                                <span class="fileinput-new"> Select Film Poster </span>
                                                <span class="fileinput-exists"> Change </span>
                                                <input type="file" name="poster" value="{{ old('poster', '') }}">
                                            </span>
                                            <a href="" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <span style="color: red; margin-left: 10px">{{ $errors->first('poster') }}</span>
                                    </div>
                                </div>
                                <!-- Form Buttons -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-round">Add</button>
                                        <button type="reset"
                                            class="btn btn-default btn-round btn-simple">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    @push('scripts')
        <script src="{{ asset('web_files/js/bootstrap-fileinput.js') }}"></script>
        <script>
            document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                var fileName = e.target.files[0].name;
                var label = e.target.nextElementSibling;
                label.textContent = fileName;

                // Show the upload button if video is selected
                var uploadButton = document.getElementById('upload-button');
                uploadButton.style.display = 'block';
            });

            document.querySelector('#upload-button').addEventListener('click', function() {
                var form = document.getElementById('film-form');
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', "{{ route('dashboard.films.store') }}", true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = Math.round((e.loaded / e.total) * 100);
                        var progressBar = document.getElementById('progress-bar');
                        progressBar.style.width = percentComplete + '%';
                        progressBar.setAttribute('aria-valuenow', percentComplete);
                        progressBar.textContent = percentComplete + '%';
                    }
                });

                xhr.addEventListener('load', function() {
                    if (xhr.status === 200) {
                        alert('Film added successfully!');
                        document.querySelector('.progress').style.display = 'none';
                        document.getElementById('progress-bar').style.width = '0%';
                        document.getElementById('progress-bar').textContent = '0%';
                    } else {
                        alert('Error adding film!');
                    }
                });

                xhr.send(formData);
            });

            document.getElementById('upload-button').addEventListener('click', function() {
                // Lấy giá trị của input file
                var videoInput = document.getElementById('video-upload');
                var errorMessage = document.getElementById('error-message');

                // Nếu không có file nào được chọn
                if (videoInput.files.length === 0) {
                    // Hiển thị thông báo lỗi
                    errorMessage.textContent = "Vui lòng chọn video trước khi tải lên.";
                } else {
                    // Xóa thông báo lỗi nếu đã chọn file
                    errorMessage.textContent = "";

                    // Thực hiện logic tải video lên
                    // Bạn có thể thêm AJAX hoặc xử lý form submit ở đây
                    alert('Video đã sẵn sàng để tải lên!');
                }
            });
            document.getElementById('video-upload').addEventListener('change', function() {
                var uploadButton = document.getElementById('upload-button');
                var fileSelected = this.files.length > 0;

                // Toggle button disabled state
                uploadButton.disabled = !fileSelected;

                // Toggle classes based on whether a file is selected or not
                uploadButton.classList.toggle('btn-secondary', !fileSelected); // Gray if no file
                uploadButton.classList.toggle('btn-success', fileSelected); // Green if file is selected
            });
        </script>
    @endpush
@endsection
