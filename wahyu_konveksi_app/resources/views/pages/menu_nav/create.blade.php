@extends('layouts.app')

@section('title', 'Add Navigation Menu')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Navigation Menu</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Navigation</a></div>
                <div class="breadcrumb-item">Add Menu</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('navigation-menus.store') }}" method="POST">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title">
                            <small class="form-text text-muted">Wajib diisi</small>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" id="url">
                            <small class="form-text text-muted">Otomatis mengikuti judul, bisa diubah manual</small>
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Tipe Menu <span class="text-danger">*</span></label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror">
                                <option value="internal">Internal</option>
                                <option value="external">External</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Parent Menu</label>
                            <select name="parent_id" class="form-control">
                                <option value="">-- Tidak ada (root) --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}">{{ $parent->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ikon (opsional)</label>
                            <input type="text" name="icon" class="form-control" placeholder="fas fa-home">
                        </div>

                        <div class="form-group">
                            <label>Urutan <span class="text-danger">*</span></label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror">
                            @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="active" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('navigation-menus.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('title').addEventListener('keyup', function () {
        let val = this.value.trim().toLowerCase().replace(/\s+/g, '-');
        document.getElementById('url').value = '/' + val;
    });
</script>
@endpush
