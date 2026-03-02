@extends('layouts.app')

@section('title', 'Edit Gallery')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Gallery</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        {{-- Kategori --}}
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Tanpa Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ $gallery->category_id == $c->id ? 'selected' : '' }}>
                                        {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Judul --}}
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                name="title" value="{{ $gallery->title }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                name="description">{{ $gallery->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $gallery->status=='active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $gallery->status=='inactive' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                        </div>

                        {{-- Upload multi gambar baru --}}
                        <div class="form-group">
                            <label>Tambah Gambar Baru</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                name="images[]" multiple>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preview gambar lama --}}
                        @if($gallery->image)
                            <div class="form-group">
                                <label>Gambar Lama</label>
                                <div class="mt-2 d-flex flex-wrap" id="image-preview-wrapper">
                                    @foreach(json_decode($gallery->image, true) as $index => $img)
                                        <div class="position-relative me-2 mb-2 image-item" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/'.$img) }}" alt="Gambar Gallery"
                                                class="img-thumbnail" width="120" height="100" style="object-fit:cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-image"
                                                data-url="{{ route('galleries.images.destroy', [$gallery->id, $index]) }}"
                                                style="border-radius:50%; padding:2px 6px;">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('galleries.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.delete-image').forEach(button => {
        button.addEventListener('click', function () {
            let url = this.dataset.url;
            let imageItem = this.closest('.image-item');

            if (confirm("Yakin ingin menghapus gambar ini?")) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        imageItem.remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(err => {
                    alert("Terjadi kesalahan!");
                    console.error(err);
                });
            }
        });
    });
});
</script>
@endpush
