@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Kategori</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <h4>Edit Kategori</h4>
                    </div>

                    <div class="card-body">
                        {{-- Nama Kategori --}}
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name', $category->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload multi gambar --}}
                        <div class="form-group">
                            <label>Gambar (bisa tambah baru)</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                name="images[]" multiple id="images-input">
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Preview gambar lama --}}
                            @if($category->image)
                                <div class="mt-2 d-flex flex-wrap" id="image-preview-wrapper">
                                    @foreach(json_decode($category->image, true) as $index => $img)
                                        <div class="position-relative me-2 mb-2 image-item" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/'.$img) }}" alt="Gambar Kategori"
                                                class="img-thumbnail" width="120" height="100" style="object-fit:cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-image"
                                                data-url="{{ route('admin.categories.destroyImage', [$category->id, $index]) }}"
                                                style="border-radius:50%; padding:2px 6px;">×</button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Preview gambar baru --}}
                            <div id="new-image-preview" class="d-flex flex-wrap mt-2"></div>
                        </div>

                        {{-- Deskripsi (sementara di-comment) --}}
                        {{-- 
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="description">{{ old('description', $category->description) }}</textarea>
                        </div>
                        --}}
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary mr-2">
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

    // Hapus gambar lama via AJAX
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

    // Preview gambar baru
    const imagesInput = document.getElementById('images-input');
    const newPreview = document.getElementById('new-image-preview');

    imagesInput.addEventListener('change', function () {
        newPreview.innerHTML = ''; // clear dulu preview lama
        const files = Array.from(this.files);

        files.forEach((file) => {
            const reader = new FileReader();
            reader.onload = function (e) {
                const div = document.createElement('div');
                div.classList.add('position-relative', 'me-2', 'mb-2');
                div.style.width = '120px';
                div.style.height = '100px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '120px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';

                div.appendChild(img);
                newPreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endpush
