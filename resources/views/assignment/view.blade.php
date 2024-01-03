@extends('layouts.app')

@section('title', $course->title . ' - '. $assignment->title)

@section('content')
    <x-app.page-header>
        <x-slot:pretitle>Assignment</x-slot:pretitle>
        <x-slot:title>{{ $assignment->title }}</x-slot:title>
    </x-app.page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12 col-lg-8">
                    <div class="card card-sm mb-4">
                        <div class="card-header">
                            <div class="card-title">Content</div>
                        </div>
                        <div class="card-body">
                            {!! $assignment->content !!}
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="divide-y">
                                @forelse($assignment->comments as $comment)
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
                                  action="{{ route('assignment.comment', ['course' => $course, 'assignment' => $assignment]) }}">
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
                            <div class="card-title">Submission</div>
                        </div>
                        <div class="card-body">
                            @if($submission = $assignment->submissions()->where('student_id', auth()->user()->id)->first())
                                @unless($submission->attachments->count() > 0)
                                    <div class="text-center mb-3">No submission file is uploaded.</div>
                                @else
                                    <div class="list-group list-group-flush mb-3">
                                        @foreach($submission->attachments as $attachment)
                                            <form class="list-group-item active" action="{{ route('submission.attachment.delete', ['course' => $course, 'assignment' => $assignment, 'submission' => $submission, 'attachment' => $attachment]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ $attachment->url }}">{{ $attachment->data['file_name'] ?? '-' }}</a>
                                                <button type="submit" class="badge badge-outline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                @endunless
                            @else
                                <div class="text-center mb-3">No submission file is uploaded.</div>
                            @endif
                            @if(auth()->user()->enrolledCourses->contains($course))
                                <form
                                    action="{{ route('submission.submit', ['course' => $course, 'assignment' => $assignment]) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="submission_file">Upload submission</label>
                                        <input type="file" name="submission_file" id="submission_file"
                                               class="form-control @error('submission_file') is-invalid @enderror">
                                        @error('submission_file')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
        })
    </script>
@endpush
