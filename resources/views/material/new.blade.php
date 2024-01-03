@extends('layouts.app')

@section('title', 'Create new material')

@section('content')
    <x-app.page-header>
        <x-slot:pretitle>Create new</x-slot:pretitle>
        <x-slot:title>Material</x-slot:title>
    </x-app.page-header>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('material.create', ['course' => $course]) }}" method="post" class="row row-cards" enctype="multipart/form-data">
                <div class="col-12 col-lg-8 mb-4">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" autocomplete="off">
                                    <label for="title">Material title</label>
                                    @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="content">Content</label>
                                <textarea name="content" id="content" class="form-control">{!! old('content') !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Attachments</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="video_url">Video URL (YouTube)</label>
                                <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=B9XcgFT_67A">
                                @error('video_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Actions</h4>
                        </div>
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary w-100">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/libs/tinymce/tinymce.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let options = {
                selector: '#content',
                height: 300,
                menubar: false,
                statusbar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
            }
            if (localStorage.getItem("tablerTheme") === 'dark') {
                options.skin = 'oxide-dark';
                options.content_css = 'dark';
            }
            tinyMCE.init(options);
        })
    </script>
@endpush
