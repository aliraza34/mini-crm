@extends('admin.layouts.master')
@push('links')
    <link href="assets/admin/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
@endpush
@section('content')
    <main>
        <div class="container-fluid">
            {{-- <h1 class="mt-4 mb-2">Images Library</h1> --}}
            <div class="breadcrumb mt-5 mb-3">
                <span class="breadcrumb-item">Images Library</span>
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
            <div id="form" style="@if (!$errors->any()) display: none; @endif">
                <form action="{{ route('media.store') }}" enctype="multipart/form-data" method="post" id="image_form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <label for=""><strong>Select Images</strong></label>
                            <div class="custom-file" style="height: auto !important">
                                <input type="file" name="images[]"
                                    class="custom-file-input @error('images') is-invalid @enderror" id="customFile"
                                    multiple>
                                <label class="custom-file-label" for="customFile">Choose Images</label>
                                @error('images')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('images.*')
                                    <span class="text-danger" style="font-size: 13px" role="alert">
                                        <strong>The Image Type Must be jpg,jpeg,png,svg</strong>
                                    </span>
                                @enderror
                                <div id="preview_images">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tile"><strong>Title</strong></label>
                                <input type="text" name="media_title"
                                    class="form-control @error('media_title') is-invalid @enderror" id="tile"
                                    placeholder="Title">
                                @error('media_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="alt"><strong>Alt</strong></label>
                                <input type="text" name="media_alt"
                                    class="form-control @error('media_alt') is-invalid @enderror" id="alt"
                                    placeholder="Alt">
                                @error('media_alt')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h2 class="h2">Images</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2" id="buttons">
                        @if ($errors->any()) <button type='submit'
                                class='btn btn-outline-success mx-1' id='submit'>Submit</button>@endif
                        <button class="btn btn-sm btn-outline-success" id="add_new_images">
                        @if ($errors->any()){{ 'Hide Form' }} @else
                                {{ 'Add New Images' }}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
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
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Alternate</th>
                                    <th>Create At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Path</th>
                                    <th>Alternate</th>
                                    <th>Create At</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @if (!$images->isEmpty())
                                    {{-- @php $i = 1; @endphp --}}
                                    @foreach ($images as $i => $image)
                                        <tr>
                                            <td>
                                                {{ $i + 1 }}
                                            </td>
                                            <td>
                                                <img src="{{ asset('media/' . $image->media_path) }}"
                                                    alt="{{ $image->media_alt }}" title="{{ $image->media_title }}"
                                                    width="80">
                                            </td>
                                            <td>{{ $image->media_title ?? $image->media_title }}</td>
                                            <td>{{ secure_url('media/' . $image->media_path) }}</td>
                                            <td>{{ $image->media_alt ?? $image->media_alt }}</td>
                                            <td>{{ !empty($image->created_at) ? date('F d, Y', strtotime($image->created_at)) : '---' }}
                                            </td>
                                            <td><button class="btn btn-danger delete_image"
                                                    data-id="{{ $image->id }}"><i class="fas fa-trash"></i></button>
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
    </main>
@endsection
@push('scripts')
    <script src="assets/admin/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="assets/admin/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // datatable
            $('#dataTable').DataTable();
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

            $('#add_new_images').click(function() {
                $('#form').slideToggle('normal');
                if ($(this).text().trim() != 'Hide Form') {
                    $(this).text('Hide Form');
                    $('#buttons').prepend(
                        "<button type='submit' class='btn btn-outline-success mx-1' id='submit'>Submit</button>"
                    );
                } else {
                    $('#submit').remove();
                    $(this).text('Add New Images');
                }
            });
            $(document).on('click', '#submit', function() {
                $('#image_form').submit();
            });
            //delete image
            $(document).on('click', '.delete_image', function() {
                var id = $(this).data('id');
                var $this = $(this);
                if (confirm('Are You Sure, You want tot delete this Blog.?')) {

                    $.ajax({
                        url: "{{ secure_url('admin/media') }}/" + id,
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
                            }
                        },
                        error: function(err) {
                            console.error(err)
                        }

                    });
                }
            })
        });
    </script>
@endpush
