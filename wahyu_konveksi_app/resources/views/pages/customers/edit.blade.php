@extends('layouts.app')

@section('title', 'Edit Customer')

@section('main')
<div class="main-content">
<section class="section">
    <div class="section-header">
        <h1>Edit Customer</h1>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
                    </div>

                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}" required>
                    </div>

                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control">{{ $customer->address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Password (opsional)</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $customer->is_active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$customer->is_active ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="text-right">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-light">Batal</a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
</div>
@endsection
