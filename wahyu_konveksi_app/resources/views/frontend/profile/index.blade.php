@extends('frontend.layouts.app')

@section('content')
<div class="header-spacer"></div>

<div class="container my-5">
    <h3 class="mb-4">Profil Saya</h3>

    <div class="card profile-card shadow-sm border-0 rounded-4 p-4">
        <p><strong>Nama:</strong> {{ $customer->name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>Telepon:</strong> {{ $customer->phone ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $customer->address ?? '-' }}</p>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('frontend.profile.edit') }}" class="btn btn-outline-primary">
                Edit Profil
            </a>

            <form method="POST" action="{{ route('frontend.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

