@extends('layouts.auth')

@section('title', 'Login ')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header text-center d-block">
            {{-- ✅ Logo menggantikan bawaan Stisla --}}
            {{-- <img src="{{ isset($appSettings['logo']) ? asset('storage/settings/' . $appSettings['logo']) : asset('img/default-logo.png') }}"
                alt="Logo"
                style="height: 40px; margin-bottom: 10px;"> --}}
            <h4 class="mt-2">{{ $appSettings['app_name'] ?? 'WHS Konveksindo' }}</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.login.submit') }}" class="needs-validation" novalidate="">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" tabindex="1" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" tabindex="2">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

   {{-- ✅ Footer --}}
                <div class="simple-footer text-center mt-4">
                    {{ $appSettings['footer_text'] ?? '© 2025 Yans Productions. All rights reserved.' }}
                </div>
@endsection



@push('scripts')
    <!-- JS Libraies -->
@endpush
