@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a href="{{ route('course.home', ['course' => $course]) }}" class="nav-link active">Materials</a>
                </li>
                <li class="nav-item">
                    <a href="{{ '#' }}" class="nav-link">Assignment</a>
                </li>
            </ul>

            <x-app.page-header>
                <x-slot:pretitle>List of</x-slot:pretitle>
                <x-slot:title>Materials</x-slot:title>

                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        @if($course->mentor_id == auth()->user()->id && auth()->user()->role == \App\Enums\UserRole::MENTOR)
                            <a href="{{ route('material.new', ['course' => $course]) }}"
                               class="btn btn-primary d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M12 5l0 14"></path>
                                    <path d="M5 12l14 0"></path>
                                </svg>
                                Create new material
                            </a>
                        @endif
                    </div>
                </div>
            </x-app.page-header>

            @if($course->materials->count() > 0)
                <div class="row row-cards mt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="list-group list-group-flush list-group-hoverable">
                                @foreach($course->materials->sortDesc() as $material)
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <a href="#">
                                                    <span class="avatar"
                                                          style="background-image: url('{{ $material->mentor->profile_picture_url }}')"></span>
                                                </a>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="{{ route('material.view', ['course' => $course, 'material' => $material]) }}" class="text-reset d-block">{{ $material->title }}</a>
                                                <div
                                                    class="d-block text-secondary text-truncate mt-n1">{{ $material->mentor->name }}</div>
                                            </div>
                                            <div class="col-auto">
                                                @if($material->mentor_id == auth()->user()->id)
                                                    <a href="{{ route('material.edit', ['course' => $course, 'material' => $material]) }}"
                                                       class="list-group-item-actions">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                             class="icon icon-tabler icon-tabler-edit-circle" width="24"
                                                             height="24" viewBox="0 0 24 24" stroke-width="2"
                                                             stroke="currentColor" fill="none" stroke-linecap="round"
                                                             stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                            <path
                                                                d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"/>
                                                            <path d="M16 5l3 3"/>
                                                            <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"/>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else

            @endif
        </div>
    </div>
@endsection
