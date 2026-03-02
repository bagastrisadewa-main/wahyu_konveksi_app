@extends('layouts.app')

@section('title', 'Edit Tentang Kami')

@push('style')
<style>
    .preview-container {
        margin-top: 10px;
    }

    .preview-container img {
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.15);
        transition: 0.3s ease-in-out;
    }

    .preview-container img:hover {
        transform: scale(1.05);
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Tentang Kami</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('about.index') }}">Tentang Kami</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">

            {{-- Alert Sukses / Error --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">

                        {{-- Judul --}}
                        <div class="form-group">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" value="{{ old('title', $about->title) }}" required>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label>Deskripsi <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="12" style="min-height: 250px;" required>{{ old('description', $about->description) }}</textarea>
                        </div>

                        {{-- Gambar Utama --}}
                        <div class="form-group mt-4">
                            <label>Gambar Utama</label>
                            <div class="preview-container mb-2">
                                @if($about->image)
                                    <img src="{{ asset('storage/'.$about->image) }}" id="image-preview">
                                @else
                                    <img id="image-preview" class="d-none">
                                @endif
                            </div>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                                   class="form-control-file"
                                   onchange="previewImage(event, 'image-preview')">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                        </div>

                        {{-- Banner Section --}}
                        @if($about->banner_image || $about->banner_title)
                            {{-- Record ini sudah punya banner --}}
                            <div class="form-group mt-4">
                                <label>Banner Image</label>
                                <div class="preview-container mb-2">
                                    @if($about->banner_image)
                                        <img src="{{ asset('storage/'.$about->banner_image) }}" id="banner-preview">
                                    @else
                                        <img id="banner-preview" class="d-none">
                                    @endif
                                </div>
                                <input type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp"
                                       class="form-control-file"
                                       onchange="previewImage(event, 'banner-preview')">
                            </div>

                            <div class="form-group">
                                <label>Banner Title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title', $about->banner_title) }}">
                            </div>

                        @elseif(!$bannerExists)
                            {{-- Record ini belum punya banner dan belum ada banner di record lain --}}
                            <div class="form-group mt-4">
                                <label>Banner Image</label>
                                <div class="preview-container mb-2">
                                    <img id="banner-preview" class="d-none">
                                </div>
                                <input type="file" name="banner_image" accept=".jpg,.jpeg,.png,.webp"
                                       class="form-control-file"
                                       onchange="previewImage(event, 'banner-preview')">
                            </div>

                            <div class="form-group">
                                <label>Banner Title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title') }}">
                            </div>
                        @endif

                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('about.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
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
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById(previewId);
            output.src = reader.result;
            output.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
