@extends('layouts.auth')

@section('title', 'Welcome')

@section('content')
    <div class="card card-md">
        @auth
            <form class="card-body" method="post" action="{{ route('auth.logout') }}">
                @csrf
                <a href="{{ route('course.catalogue') }}" class="btn btn-primary w-100 mb-3">Browse Course</a>
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        @else
            <a href="{{ route('auth.login.page') }}" class="btn btn-primary w-100">Login</a>
        @endauth
    </div>
@endsection
