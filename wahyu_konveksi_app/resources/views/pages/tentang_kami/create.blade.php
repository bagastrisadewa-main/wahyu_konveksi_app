@extends('layouts.app')

@section('title', 'Tambah Tentang Kami')

@push('style')
<style>
    #image-preview,
    #banner-preview {
        max-width: 400px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.15);
        transition: 0.3s ease-in-out;
    }

    #image-preview:hover,
    #banner-preview:hover {
        transform: scale(1.05);
    }

    small.text-danger {
        display: block;
        margin-top: 3px;
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Tentang Kami</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('about.index') }}">Tentang Kami</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Alert Success / Error --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">

                        {{-- Judul --}}
                        <div class="form-group">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="12" style="min-height:250px;" required>{{ old('description') }}</textarea>
                        </div>

                        {{-- Gambar Utama --}}
                        <div class="form-group mt-4">
                            <label>Gambar Utama <span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <img id="image-preview" src="{{ asset('img/example-image.jpg') }}" alt="Preview Gambar Utama">
                            </div>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                                class="form-control-file" onchange="previewImage(event, 'image-preview')" required>
                        </div>

                        {{-- Banner --}}
                        @php
                            $bannerExists = \App\Models\AboutUs::whereNotNull('banner_title')
                                ->orWhereNotNull('banner_image')->exists();
                        @endphp

                        @if(!$bannerExists)
                        <div id="banner-section">
                            <div class="form-group mt-4">
                                <label>Banner Image</label>
                                <div class="mb-3">
                                    <img id="banner-preview" src="{{ asset('img/example-image.jpg') }}" alt="Preview Banner">
                                </div>
                                <input type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp"
                                    class="form-control-file" onchange="previewImage(event, 'banner-preview')">
                                <small class="text-muted">Opsional</small>
                            </div>

                            <div class="form-group">
                                <label>Banner Title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title') }}">
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('about.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event, previewId) {
    const output = document.getElementById(previewId);
    output.src = URL.createObjectURL(event.target.files[0]);
}
</script>
@endpush
