@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="card card-md">
        <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form action="{{ route('auth.login.action') }}" method="post" autocomplete="off" novalidate="">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="your@email.com"
                           autocomplete="off">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-label" for="password">
                        Password
                    </label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                           placeholder="Your password" autocomplete="off">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-2">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="remember_me">
                        <span class="form-check-label">Remember me on this device</span>
                    </label>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center text-secondary mt-3">
        Don't have account yet? <a href="{{ route('auth.register.page') }}" tabindex="-1">Register</a>
    </div>
@endsection
