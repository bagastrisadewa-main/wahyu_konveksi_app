@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Tambah Artikel</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="card-body">

            {{-- Judul --}}
            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control @error('title') is-invalid @enderror" 
                     name="title" value="{{ old('title') }}">
              @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Konten (Summernote aktif otomatis dari layout/app.blade) --}}
            <div class="form-group">
              <label>Konten</label>
              <textarea class="form-control summernote @error('content') is-invalid @enderror"
                        name="content"
                        rows="15"
                        style="min-height:200px;">{{ old('content') }}</textarea>
              @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Layout --}}
            <div class="form-group">
              <label>Layout</label>
              <select name="layout" class="form-control">
                <option value="default">Default</option>
                {{-- <option value="modern">Modern</option>
                <option value="magazine">Magazine</option> --}}
              </select>
            </div>

            {{-- SEO --}}
            <div class="form-group">
              <label>Meta Title</label>
              <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}">
            </div>
            <div class="form-group">
              <label>Meta Description</label>
              <textarea class="form-control" name="meta_description">{{ old('meta_description') }}</textarea>
            </div>
            <div class="form-group">
              <label>Kata Kunci</label>
              <input type="text" class="form-control" name="keywords" value="{{ old('keywords') }}">
              <small class="form-text text-muted">Pisahkan dengan koma</small>
            </div>

            {{-- Upload multi gambar --}}
            <div class="form-group">
              <label>Gambar Artikel</label>
              <input type="file" id="image-input" class="form-control @error('images.*') is-invalid @enderror"
                     name="images[]" multiple>
              <div id="image-preview" class="mt-3 d-flex flex-wrap"></div>
              @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Status --}}
            <div class="form-group">
              <label>Status</label>
              <select name="is_published" class="form-control">
                <option value="1">Published</option>
                <option value="0">Draft</option>
              </select>
            </div>
          </div>

          <div class="card-footer text-right">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary mr-2">
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
{{-- Script preview gambar sebelum upload --}}
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
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<script>
$(document).ready(function() {
  let activeEditor = null;

  $('.summernote').on('summernote.focus', function() {
    activeEditor = $(this);
  });

  $('.summernote').summernote({
    height: 300,
    codeviewFilter: false,
    codeviewIframeFilter: false,
    callbacks: {
      onPaste: function (e) {
        const clipboardData = (e.originalEvent || e).clipboardData;
        const text = clipboardData.getData('text/plain');

        if (text.match(/(youtube\.com|youtu\.be|vimeo\.com|tiktok\.com)/)) {
          e.preventDefault();
          e.stopPropagation();

          // Tunggu agar Summernote siap
          setTimeout(() => {
            const embedHtml = convertToEmbed(text);
            if (activeEditor) {
              activeEditor.summernote('pasteHTML', embedHtml);
            }
          }, 100);
        }
      }
    }
  });

  // 🧩 Fungsi ubah link ke iframe embed
  function convertToEmbed(url) {
    if (url.includes('youtube.com') || url.includes('youtu.be')) {
      let videoId = '';
      if (url.includes('youtu.be/')) {
        videoId = url.split('youtu.be/')[1];
      } else if (url.includes('v=')) {
        videoId = url.split('v=')[1].split('&')[0];
      }

      return `
        <div class="ratio ratio-16x9 mb-2">
          <iframe width="560" height="315"
            src="https://www.youtube-nocookie.com/embed/${videoId}"
            frameborder="0" allowfullscreen
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
          </iframe>
        </div>`;
    }

    if (url.includes('vimeo.com')) {
      const videoId = url.split('vimeo.com/')[1];
      return `
        <div class="ratio ratio-16x9 mb-2">
          <iframe src="https://player.vimeo.com/video/${videoId}" width="560" height="315" frameborder="0" allowfullscreen></iframe>
        </div>`;
    }

    if (url.includes('tiktok.com')) {
      return `
        <blockquote class="tiktok-embed" cite="${url}" style="max-width: 605px;min-width: 325px;">
          <section></section>
        </blockquote>
        <script async src="https://www.tiktok.com/embed.js"></script>`;
    }

    return `<a href="${url}" target="_blank">${url}</a>`;
  }
});
</script>



@endpush
