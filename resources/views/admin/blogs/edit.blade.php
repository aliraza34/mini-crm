@extends('admin.layouts.master')
@push('links')
    <style>
        .nav-item .nav-link {
            border-radius: 15px 15px 0px 0px;
            border-color: #e9ecef #e9ecef #dee2e6;
        }

        .nav-item .nav-link.active {
            color: white;
            background: #007bff;
            font-weight: bold;
        }

    </style>
@endpush
@section('content')
    <main>
        <div class="container-fluid">
            {{-- <h1 class="mt-4 mb-2">Images Library</h1> --}}
            <div class="breadcrumb mt-5 mb-3">
                <span class="breadcrumb-item">Blogs</span>
                <span class="breadcrumb-item active">Home</span>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <ul class="nav nav-tabs mt-4" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="Edit-tab" data-toggle="tab" href="#Edit" role="tab" aria-controls="Edit"
                        aria-selected="true">Edit</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="Edit" role="tabpanel" aria-labelledby="add_blog-tab">
                    <div class="card mb-4">
                        <form action="{{ route('blog.update', $blog->id) }}" enctype="multipart/form-data" method="post">
                            @csrf
                            @method('put')
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tile"><strong>Title</strong></label>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror" id="tile"
                                                placeholder="Title" value="{{ old('title', $blog->title) }}">
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for=""><strong>Featured Image</strong></label>
                                        <div class="custom-file">
                                            <input type="file" name="image"
                                                class="custom-file-input @error('image') is-invalid @enderror"
                                                id="customFile" multiple>
                                            <label class="custom-file-label" for="customFile">Choose Image</label>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div id="preview_images">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="tile"><strong>Description</strong></label>
                                            <textarea id="description" type="text" name="description"
                                                class="form-control @error('description') is-invalid @enderror"
                                                placeholder="Before Result Text">{{ old('description', $blog->description) }}</textarea>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="form-group">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
@push('scripts')
    <script src="assets/admin/js/tinyMce.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            //preview img before add
            $("#customFile").on('change', function() {
                var fileList = this.files;
                for (var i = 0; i < fileList.length; i++) {
                    //get a blob
                    var t = window.URL || window.webkitURL;
                    var objectUrl = t.createObjectURL(fileList[i]);
                    $('#preview_images').append('<img src="' + objectUrl + '" />');

                }
            });
            tinymce.init({
                selector: '#description',
                height: 600,
               // toolbar: 'code image media pageembed template link anchor codesample | undo redo | table | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | a11ycheck ltr rtl | showcomments addcomment',
                plugins: 'code image table link imagetools lists',
                force_br_newlines: false,
                force_p_newlines: false,
                forced_root_block: '',
                relative_urls: false,
                remove_script_host: false,
                document_base_url: '{{ secure_url('/') }}',
            });
        });
    </script>
@endpush
