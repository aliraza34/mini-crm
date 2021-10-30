@extends('admin.layouts.master')
@push('links')
    <link href="assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <style>
        .nav-item .nav-link {
            border-radius: 15px 15px 0px 0px;
            border-color: #e9ecef #e9ecef #dee2e6;
            color: black;
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
                    <a class="nav-link @if (!$errors->any()) active @endif"
                        id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link @if ($errors->any()) active @endif"
                        id="add_blog-tab" data-toggle="tab" href="#add_blog" role="tab"
                        aria-controls="add_blog" aria-selected="false">Add Blog</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade @if (!$errors->any()) show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="card mb-4">
                        {{-- <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            DataTable Example
                        </div> --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            {{-- <th>ِImage</th> --}}
                                            <th>Description</th>
                                            <th>Create At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Title</th>
                                            {{-- <th>ِImage</th> --}}
                                            <th>Description</th>
                                            <th>Create At</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @if (!$blogs->isEmpty())
                                            {{-- @php $i = 1; @endphp --}}
                                            @foreach ($blogs as $i => $blog)
                                                <tr>
                                                    <td>
                                                        {{ $i + 1 }}
                                                    </td>
                                                    <td>{{ $blog->title ?? $blog->title }}</td>
                                                    {{-- <td>
                                                        <img src="{{ asset('blog_images/' . $blog->image) }}"
                                                            alt="{{ $blog->image }}" title="{{ $blog->title }}"
                                                            width="80">
                                                    </td> --}}
                                                    <td><?php echo !empty($blog->description) ?
                                                        (strlen(strip_tags($blog->description)) > 50 ?
                                                        substr(strip_tags($blog->description), 0, 50) . '...' :
                                                        strip_tags($blog->description)) : ''; ?></td>

                                                    <td>{{ !empty($blog->created_at) ? date('F d, Y', strtotime($blog->created_at)) : '---' }}

                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-around align-items-center">
                                                            <a href="{{ route('blog.edit', $blog->id) }}"
                                                                class="btn btn-primary" data-id="{{ $blog->id }}"><i
                                                                    class="fas fa-edit"></i></a>
                                                            <button class="btn btn-danger delete_blog"
                                                                data-id="{{ $blog->id }}"><i
                                                                    class="fas fa-trash"></i></button>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if ($errors->any()) show active @endif"" id="add_blog" role="tabpanel" aria-labelledby="add_blog-tab">
                    <div class="card mb-4">
                        <form action="{{ route('blog.store') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="tile"><strong>Title</strong></label>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror" id="tile"
                                                placeholder="Title" value="{{ old('title') }}">
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
                                                placeholder="Before Result Text">{{ old('description') }}</textarea>
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
    <script src="assets/admin/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="assets/admin/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/admin/js/tinyMce.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').DataTable();
            //preview img before add
            $("#customFile").on('change', function() {
                var fileList = this.files;
                for (var i = 0; i < fileList.length; i++) {
                    //get a blob
                    var t = window.URL || window.webkitURL;
                    var objectUrl = t.createObjectURL(fileList[i]);
                    $('#preview_images').html('<img src="' + objectUrl + '" />');

                }
            });
            //delete Blog
            $(document).on('click', '.delete_blog', function() {
                var id = $(this).data('id');
                var $this = $(this);
                if (confirm('Are You Sure, You want tot delete this Blog.?')) {
                    $.ajax({
                        url: "{{ secure_url('admin/blog') }}/" + id,
                        method: 'DELETE',
                        dataType: 'JSON',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            id: id
                        },
                        success: function(resp) {
                            console.dir(resp);
                            if (resp.success == 'deleted') {
                                $this.closest('tr').fadeOut();
                            } else {
                                alert('something went wrong');
                            }
                        },
                        error: function(err) {
                            console.error(err)
                        }
                    });
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
