@extends('layouts.app')

@section('title', 'Profil Saya')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Profil Saya</h1></div>
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $user->photo ? asset('storage/users/' . $user->photo) : asset('img/avatar/avatar-1.png') }}"
                    class="rounded-circle mb-3" width="100" height="100">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <div class="mt-4">
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary mr-2">Edit Profil</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
