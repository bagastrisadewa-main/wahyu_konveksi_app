@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kategori</h1>
        </div>

        <div class="section-body">
            <div class="card">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- <div class="card-header">
                            <h4>Tambah Kategori</h4>
                        </div> --}}
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name">
                                @error('name')
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

                            {{-- Deskripsi (sementara di-comment) --}}
                            {{--
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>
                            --}}
                        </div>
                        <div class="card-footer text-right">
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
    preview.innerHTML = ''; // reset
    [...event.target.files].forEach(file => {
        if (file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = e => {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail', 'mr-2', 'mb-2');
                img.style.width = '120px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
