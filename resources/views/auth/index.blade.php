@extends('layouts.auth')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Please choose your action</h2>
            <a href="{{ route('auth.login.page') }}" class="btn btn-primary w-100">Login</a>
            <div class="hr-text my-4">or</div>
            <a href="{{ route('auth.login.page') }}" class="btn btn-outline-primary w-100">Register</a>
        </div>
    </div>
@endsection
