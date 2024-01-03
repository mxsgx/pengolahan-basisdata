@extends('layouts.base')

@section('body')
    <div class="page">
        <x-app.navbar/>

        <div class="page-wrapper">
            @yield('content')
        </div>
    </div>
@endsection

@push('scripts')
    <form action="{{ route('auth.logout') }}" method="post" id="logout-form">@csrf</form>
@endpush
