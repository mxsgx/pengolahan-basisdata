@extends('layouts.base')

@section('title', 'Auth')

@section('bodyClass', 'd-flex flex-column')

@section('body')
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark">
                    <h1 class="my-0">{{ config('app.name') }}</h1>
                </a>
            </div>

            @yield('content')
        </div>
    </div>
@endsection
