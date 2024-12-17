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
                    <h2>Edit Film
                        <small>Welcome to Films</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-7 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}"><i class="zmdi zmdi-home"></i>
                                Films</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Films</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Edit</strong> Film</h2>
                        </div>

                        <div class="body">
                            <form id="film-form" action="{{ route('dashboard.films.update', $film->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="header col-lg-12 col-md-12 col-sm-12">
                                    <h2>Main Information</h2>
                                </div>

                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Name"
                                                value="{{ old('name', $film->name) }}">
                                            <span style="color: red; margin-left: 10px">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="year" class="form-control" placeholder="Year"
                                                value="{{ old('year', $film->year) }}">
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
                                                <option value="{{ $category->id }}"
                                                    {{ in_array($category->id, $film->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
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
                                                <option value="{{ $actor->id }}"
                                                    {{ in_array($actor->id, $film->actors->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $actor->name }}
                                                </option>
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
                                            <textarea name="overview" rows="4" class="form-control no-resize" placeholder="Film Overview">{{ old('overview', $film->overview) }}</textarea>
                                            <span
                                                style="color: red; margin-left: 10px">{{ $errors->first('overview') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Film video -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea name="video" rows="4" class="form-control no-resize" placeholder="Film Video">{{ old('video', $film->video) }}</textarea>
                                            <span
                                                style="color: red; margin-left: 10px">{{ $errors->first('video') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Video Upload -->
                                {{-- <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="video-upload" class="form-label">Upload Video</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="video-upload"
                                                    name="video">
                                                <label class="custom-file-label" for="video-upload">
                                                    {{ $film->video ?? 'Choose file...' }}
                                                </label>
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
                                            <button type="button" class="btn btn-success upload-button"
                                                id="upload-button">Upload Video</button>
                                        </div>
                                    </div>
                                </div> --}}

                                <!-- Background Cover Upload -->
                                <div class="form-group last">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                            <img src="{{ $film->background_cover }}" alt="Background Cover" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-dark btn-file">
                                                <span class="fileinput-new">Select Film Background_Cover</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="background_cover">
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
                                            <img src="{{ $film->poster }}" alt="Film Poster" />
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                            style="max-width: 200px; max-height: 150px;"></div>
                                        <div>
                                            <span class="btn btn-dark btn-file">
                                                <span class="fileinput-new">Select Film Poster</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" name="poster">
                                            </span>
                                            <a href="" class="btn btn-danger fileinput-exists"
                                                data-dismiss="fileinput">Remove</a>
                                        </div>
                                        <span style="color: red; margin-left: 10px">{{ $errors }}</span>
                                    </div>
                                </div>
                                <!-- Form Buttons -->
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-round">Update</button>
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
                xhr.open('POST', "{{ route('dashboard.films.update', $film->id) }}", true);
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
                        alert('Film updated successfully!');
                        document.querySelector('.progress').style.display = 'none';
                        document.getElementById('progress-bar').style.width = '0%';
                        document.getElementById('progress-bar').textContent = '0%';
                    } else {
                        alert('Error updating film!');
                    }
                });

                xhr.send(formData);
            });
        </script>
    @endpush
@endsection
