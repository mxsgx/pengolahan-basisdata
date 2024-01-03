@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Create new account</h2>
            <form action="{{ route('auth.register.action') }}" method="post" autocomplete="off" novalidate="">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Full name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="John Doe"
                           autocomplete="off">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="your@email.com"
                           autocomplete="off">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                           placeholder="Your password" autocomplete="off">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label" for="password_confirmation">Password confirmation</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           placeholder="Re-type your password" autocomplete="off">
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center text-secondary mt-3">
        Already have account? <a href="{{ route('auth.login.page') }}" tabindex="-1">Login</a>
    </div>
@endsection
