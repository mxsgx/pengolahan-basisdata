@extends('layouts.app')

@section('title', 'Create new course')

@section('content')
    <x-app.page-header>
        <x-slot:pretitle>Create new</x-slot:pretitle>
        <x-slot:title>Course</x-slot:title>
    </x-app.page-header>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('course.create') }}" method="post" class="row row-cards" enctype="multipart/form-data">
                <div class="col-12 col-lg-8 mb-4">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" autocomplete="off">
                                    <label for="title">Course title</label>
                                    @error('title')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" id="description" class="form-control">{!! old('description') !!}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Attachments</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="cover_image">Cover Image</label>
                                <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror">
                                @error('cover_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="started_at" class="form-label required">Start date</label>
                                <div class="input-icon @error('started_at') is-invalid @enderror">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                                    </span>
                                    <input class="form-control @error('started_at') is-invalid @enderror" placeholder="Select a date" id="started_at" name="started_at" value="{{ old('started_at') }}" required>
                                </div>
                                @error('started_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ended_at" class="form-label">End date</label>
                                <div class="input-icon @error('ended_at') is-invalid @enderror">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                                    </span>
                                    <input class="form-control @error('ended_at') is-invalid @enderror" placeholder="Select a date" id="ended_at" name="ended_at" value="{{ old('ended_at') }}">
                                </div>
                                @error('ended_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/libs/tinymce/tinymce.min.js" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let options = {
                selector: '#description',
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

            window.flatpickr && flatpickr(document.getElementById('started_at'), {
                dateFormat: 'Y-m-d H:i',
                enableTime: true,
            });

            window.flatpickr && flatpickr(document.getElementById('ended_at'), {
                dateFormat: 'Y-m-d H:i',
                enableTime: true,
            });
        })
    </script>
@endpush
