@extends('layouts.app')

@section('title', 'Edit Slider Image')

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
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Slider</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Slider</a></div>
                <div class="breadcrumb-item">Edit Slider</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title',$slider->title) }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Sub Judul</label>
                            <input type="text" name="subtitle" class="form-control" 
                                   value="{{ old('subtitle',$slider->subtitle) }}">
                        </div>

                        <div class="form-group">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control" 
                                   value="{{ old('button_text',$slider->button_text) }}">
                        </div>

                        <div class="form-group">
                            <label>Button Link</label>
                            <input type="text" name="button_link" class="form-control" 
                                   value="{{ old('button_link',$slider->button_link) }}">
                        </div>

                        <!-- Image Upload with Preview -->
                        <div class="form-group mt-4">
                            <label>Gambar <span class="text-danger">*</span></label>
                            <div class="mb-3">
                                <img id="image-preview" 
                                     src="{{ $slider->image ? asset('storage/'.$slider->image) : asset('img/example-image.jpg') }}" 
                                     alt="Preview Image" class="img-fluid d-block">
                            </div>
                            <input type="file" name="image" accept=".jpg,.jpeg,.png"
                                   class="form-control-file @error('image') is-invalid @enderror" onchange="previewImage(event)">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" class="form-control" 
                                   value="{{ old('order',$slider->order) }}">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ $slider->is_active ? 'selected':'' }}>Aktif</option>
                                <option value="0" {{ !$slider->is_active ? 'selected':'' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('sliders.index') }}" class="btn btn-secondary mr-2">
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
