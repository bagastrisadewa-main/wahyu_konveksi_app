@extends('layouts.app')

@section('title', 'Add Slider Image')

@push('style')
<style>
    #image-preview {
        max-width: 400px;
        margin-bottom: 15px;
        border-radius: 8px;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
        transition: 0.3s ease-in-out;
    }

    #image-preview:hover {
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
            <h1>Add Slider</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Slider</a></div>
                <div class="breadcrumb-item">Add Slider</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                            <small class="text-danger">Wajib diisi</small>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sub Judul</label>
                            <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}">
                            @error('button_text')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Button Link</label>
                            <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link') }}">
                            @error('button_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group mt-4">
                            <label>Gambar <span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <img id="image-preview" src="{{ asset('img/example-image.jpg') }}" alt="Preview Image" class="img-fluid d-block">
                            </div>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                                class="form-control-file @error('image') is-invalid @enderror"
                                onchange="previewImage(event)">
                            <small class="text-danger">Wajib diisi</small>
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order',0) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('sliders.index') }}" class="btn btn-secondary mr-2">
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
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('image-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
