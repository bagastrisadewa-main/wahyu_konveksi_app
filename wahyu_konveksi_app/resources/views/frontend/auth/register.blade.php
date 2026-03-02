@extends('frontend.layouts.app')

@section('title', 'Register')

@section('content')
<section class="login-register">
    <div class="container">
        {{-- Spacer supaya register tidak nempel header --}}
        @include('frontend.auth.components.header-spacer')

        <div class="login-page-wrapper">
            <div class="login-card">
                @include('frontend.auth.components.register-form')
            </div>
        </div>
    </div>
</section>
@endsection
