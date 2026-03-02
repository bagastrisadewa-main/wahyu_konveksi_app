@extends('frontend.layouts.app')

@section('title', 'Login')

@section('content')

    <div class="container">
        {{-- Spacer supaya login tidak nempel header --}}
        @include('frontend.auth.components.header-spacer')

        <div class="login-page-wrapper">
            <div class="login-card">
                @include('frontend.auth.components.login-form')
            </div>
        </div>
    </div>

@endsection
