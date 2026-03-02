@extends('frontend.layouts.app')

@section('content')
<div class="header-spacer"></div>

<div class="container my-5">
    <h3 class="mb-4">Edit Profil</h3>

    <div class="card shadow-sm border-0 rounded-4 p-4">
        <form method="POST" action="{{ route('frontend.profile.update') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="name"
                       class="form-control"
                       value="{{ old('name', $customer->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Telepon</label>
                <input type="text" name="phone"
                       class="form-control"
                       value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Simpan
                </button>
                <a href="{{ route('frontend.profile') }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
