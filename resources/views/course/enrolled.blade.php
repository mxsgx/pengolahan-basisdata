@extends('layouts.app')

@section('content')
    <x-app.page-header>
        <x-slot:pretitle>My</x-slot:pretitle>
        <x-slot:title>Courses</x-slot:title>
    </x-app.page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                @foreach(auth()->user()->enrolledCourses as $course)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card rounded-lg">
                            <div class="card-header">
                                <div class="card-title">
                                    <a href="{{ route('course.home', ['course' => $course]) }}"
                                       class="link-dark">{{ $course->title }}</a>
                                </div>
                                @if(auth()->user()->role == \App\Enums\UserRole::STUDENT && !$course->students->contains(auth()->user()))
                                    <form action="{{ route('course.enroll', ['course' => $course]) }}" method="post"
                                          class="card-actions">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 5l0 14"></path>
                                                <path d="M5 12l14 0"></path>
                                            </svg>
                                            Enroll
                                        </button>
                                    </form>
                                @endif
                                @if(auth()->user()->role == \App\Enums\UserRole::MENTOR && $course->mentor_id === auth()->user()->id)
                                    <div class="card-actions">
                                        <a href="{{ route('course.edit', ['course' => $course]) }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" /><path d="M16 5l3 3" /><path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" /></svg>
                                            Edit
                                        </a>
                                    </div>
                                @endif
                                @if(auth()->user()->role == \App\Enums\UserRole::STUDENT && $course->students->contains(auth()->user()))
                                    <div class="card-actions">
                                        <a href="{{ route('course.home', ['course' => $course]) }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                                            View
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body p-0">
                                @if($course->cover_image_url)
                                    <img src="{{ $course->cover_image_url }}" height="200px" width="100%"
                                         alt="{{ $course->title }}" class="object-fit-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-100" preserveAspectRatio="none"
                                         width="400" height="200" viewBox="0 0 400 200" fill="transparent"
                                         stroke="var(--tblr-border-color, #b8cef1)">
                                        <line x1="0" y1="0" x2="400" y2="200"></line>
                                        <line x1="0" y1="200" x2="400" y2="0"></line>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
