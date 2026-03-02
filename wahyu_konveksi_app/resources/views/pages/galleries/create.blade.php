@extends('layouts.app')

@section('title', 'Tambah Gallery')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Gallery</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        {{-- Kategori --}}
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">-- Tanpa Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
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
                                name="title" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload multi gambar --}}
                        <div class="form-group">
                            <label>Gambar (bisa pilih lebih dari satu)</label>
                            <input type="file" id="image-input" class="form-control @error('images.*') is-invalid @enderror" 
                                name="images[]" multiple>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Preview gambar --}}
                            <div id="image-preview" class="mt-3 d-flex flex-wrap"></div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('galleries.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image-input').addEventListener('change', function(event) {
    let preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    [...event.target.files].forEach(file => {
        if (file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = e => {
                let div = document.createElement('div');
                div.classList.add('position-relative','mr-2','mb-2');
                div.style.width = '120px';
                div.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail" style="width:120px; height:100px; object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-image"
                        style="border-radius:50%; padding:2px 6px;">×</button>
                `;
                preview.appendChild(div);

                div.querySelector('.remove-image').addEventListener('click', () => {
                    div.remove();
                });
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
