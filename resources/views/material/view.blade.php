@extends('layouts.app')

@section('title', $course->title . ' - '. $material->title)

@section('content')
    <x-app.page-header>
        <x-slot:pretitle>Material</x-slot:pretitle>
        <x-slot:title>{{ $material->title }}</x-slot:title>
    </x-app.page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12 col-lg-8">
                    @if($material->video_url)
                        <div class="card card-sm mb-4">
                            <div class="card-header">
                                <div class="card-title">Video</div>
                            </div>
                            <div class="card-body">
                                <div id="youtube" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>
                            </div>
                        </div>
                    @endif
                    <div class="card card-sm mb-4">
                        <div class="card-header">
                            <div class="card-title">Content</div>
                        </div>
                        <div class="card-body">
                            {!! $material->content !!}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="divide-y">
                                @forelse($material->comments as $comment)
                                    <div>
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="avatar"
                                                      style="background-image: url('{{ $comment->user->profile_picture_url }}')"></span>
                                            </div>
                                            <div class="col">
                                                <div class="text-truncate">
                                                    {{ $comment->user->name }}
                                                </div>
                                                <div class="text-secondary">{!! $comment->content !!}</div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center">No comment</div>
                                @endforelse
                            </div>
                            <hr>
                            <form method="post"
                                  action="{{ route('material.comment', ['course' => $course, 'material' => $material]) }}">
                                @csrf
                                <textarea name="comment" id="comment"
                                          class="form-control">{!! old('comment') !!}</textarea>
                                <button type="submit" class="btn btn-primary mt-2">Comment</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Assignment</div>
                        </div>
                        <div class="card-body">
                            @if($material->assignment)
                                <div>
                                    <div class="row mb-0">
                                        <div class="col">
                                            <div class="text-truncate">
                                                <a href="{{ route('assignment.view', ['course' => $course, 'assignment' => $material->assignment]) }}" class="text-dark">{{ $material->assignment->title }}</a>
                                            </div>
                                            <div class="text-secondary">Deadline
                                                at {{ $material->assignment->deadline_at ?$material->assignment->deadline_at->format('d M Y') : '-' }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center">No assignment for this material</div>

                                @if($material->mentor_id == auth()->user()->id)
                                    <a href="{{ route('assignment.new', ['course' => $course]) }}"
                                       class="btn btn-primary w-100 mt-4">Create an assignment!</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/libs/plyr/dist/plyr.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/libs/plyr/dist/plyr.min.js"
            defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/libs/tinymce/tinymce.min.js"
            defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let options = {
                selector: '#comment',
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
            window.Plyr && (new Plyr('#youtube'));
        })
    </script>
@endpush
