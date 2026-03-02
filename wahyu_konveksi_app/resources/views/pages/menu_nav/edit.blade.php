@extends('layouts.app')

@section('title', 'Edit Navigation Menu')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Navigation Menu</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Navigation</a></div>
                <div class="breadcrumb-item">Edit Menu</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('navigation-menus.update', $navigationMenu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="title" value="{{ old('title', $navigationMenu->title) }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" value="{{ old('url', $navigationMenu->url) }}" class="form-control" id="url">
                        </div>

                        <div class="form-group">
                            <label>Tipe Menu</label>
                            <select name="type" class="form-control">
                                <option value="internal" {{ $navigationMenu->type == 'internal' ? 'selected' : '' }}>Internal</option>
                                <option value="external" {{ $navigationMenu->type == 'external' ? 'selected' : '' }}>External</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Parent Menu</label>
                            <select name="parent_id" class="form-control">
                                <option value="">-- Tidak ada (root) --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ $navigationMenu->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ikon</label>
                            <input type="text" name="icon" value="{{ $navigationMenu->icon }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" value="{{ $navigationMenu->order }}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="active" class="form-control">
                                <option value="1" {{ $navigationMenu->active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$navigationMenu->active ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('navigation-menus.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
