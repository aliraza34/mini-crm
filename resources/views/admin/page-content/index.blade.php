@extends('admin.layouts.master')
@push('links')
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
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div id="form" style="@if (!$errors->any()) display: none; @endif">

            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h2 class="h2">Images</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2" id="buttons">

                    </div>
                </div>
            </div>
            <div class="card mb-4 p-4">
                <form action="{{ route('page_content') }}" enctype="multipart/form-data" method="post" id="image_form">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="tile"><strong>Before Result</strong></label>
                                <textarea id="before_result" type="text" name="before_result"
                                    class="form-control @error('before_result') is-invalid @enderror"
                                    placeholder="Before Result Text">{{ !empty($page_content->before_result) ? $page_content->before_result : '' }}</textarea>
                                @error('before_result')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tile"><strong>Main Content</strong></label>
                                <textarea id="main_content" type="text" name="main_content"
                                    class="form-control @error('main_content') is-invalid @enderror"
                                    placeholder="Before Result Text">{{ !empty($page_content->main_content) ? $page_content->main_content : '' }}</textarea>
                                @error('main_content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script src="{{ asset('assets/admin/js/tinyMce.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#before_result',
            height: 300,
            plugins: 'code image table link imagetools lists',
            force_br_newlines: false,
            force_p_newlines: false,
            forced_root_block: '',
            relative_urls: false,
            remove_script_host: false,
            document_base_url: '{{ secure_url('/') }}',
        });
        tinymce.init({
            selector: '#main_content',
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
    </script>
@endpush
