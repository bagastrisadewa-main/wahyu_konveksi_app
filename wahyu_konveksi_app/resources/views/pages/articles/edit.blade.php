@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('main')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Edit Artikel</h1>
    </div>

    <div class="section-body">
      <div class="card">
        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card-body">

            {{-- Judul --}}
            <div class="form-group">
              <label>Judul</label>
              <input type="text" class="form-control @error('title') is-invalid @enderror" 
                     name="title" value="{{ old('title', $article->title) }}">
              @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Konten --}}
            <div class="form-group">
              <label>Konten</label>
              <textarea class="form-control summernote @error('content') is-invalid @enderror"
                        name="content"
                        rows="15"
                        style="min-height:200px;">{{ old('content', $article->content) }}</textarea>
              @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Layout --}}
            <div class="form-group">
              <label>Layout</label>
              <select name="layout" class="form-control">
                @foreach($layouts as $layout)
                  <option value="{{ $layout }}" {{ $article->layout == $layout ? 'selected' : '' }}>
                    {{ ucfirst($layout) }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- SEO --}}
            <div class="form-group">
              <label>Meta Title</label>
              <input type="text" class="form-control" name="meta_title" 
                     value="{{ old('meta_title', $article->meta_title) }}">
            </div>
            <div class="form-group">
              <label>Meta Description</label>
              <textarea class="form-control" name="meta_description">{{ old('meta_description', $article->meta_description) }}</textarea>
            </div>
            <div class="form-group">
              <label>Kata Kunci</label>
              <input type="text" class="form-control" name="keywords" 
                     value="{{ old('keywords', $article->keywords) }}">
              <small class="form-text text-muted">Pisahkan dengan koma</small>
            </div>

            {{-- Upload gambar baru --}}
            <div class="form-group">
              <label>Upload Gambar Baru</label>
              <input type="file" id="image-input" 
                     class="form-control @error('images.*') is-invalid @enderror"
                     name="images[]" multiple>
              <div id="image-preview" class="mt-3 d-flex flex-wrap"></div>
              @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Gambar lama --}}
            @if($article->images && $article->images->count() > 0)
            <div class="mt-3 d-flex flex-wrap" id="article-image-wrapper">
              @foreach($article->images as $img)
                <div class="position-relative mr-2 mb-2 image-item" style="width:120px;" data-id="{{ $img->id }}">
                  <img src="{{ asset('storage/'.$img->image_path) }}"
                       class="img-thumbnail"
                       style="width:120px; height:100px; object-fit:cover;">
                  <button type="button"
                          class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-article-image"
                          data-url="{{ route('admin.articles.images.destroy', [$article->id, $img->id]) }}"
                          style="border-radius:50%; padding:2px 6px;">×</button>
                </div>
              @endforeach
            </div>
            @endif

            {{-- Status --}}
            <div class="form-group mt-3">
              <label>Status</label>
              <select name="is_published" class="form-control">
                <option value="1" {{ $article->is_published ? 'selected':'' }}>Published</option>
                <option value="0" {{ !$article->is_published ? 'selected':'' }}>Draft</option>
              </select>
            </div>

          </div>

          <div class="card-footer text-right">
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary mr-2">
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
{{-- Preview gambar baru --}}
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
                div.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="width:120px;height:100px;object-fit:cover;">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

{{-- Hapus gambar lama --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.delete-article-image').forEach(button => {
        button.addEventListener('click', function () {
            let url = this.dataset.url;
            let imageItem = this.closest('.image-item');
            Swal.fire({
                title: 'Yakin hapus gambar ini?',
                text: "Tindakan ini tidak bisa dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            Swal.fire('Terhapus!', 'Gambar berhasil dihapus.', 'success');
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
                        console.error(err);
                    });
                }
            });
        });
    });
});
</script>

{{-- Summernote + Auto Embed Video (sama seperti CREATE) --}}
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
      onImageUpload: function(files) {
        for (let i = 0; i < files.length; i++) {
          uploadImage(files[i]);
        }
      },
      onPaste: function (e) {
        const clipboardData = (e.originalEvent || e).clipboardData;
        const text = clipboardData.getData('text/plain');

        if (text.match(/(youtube\.com|youtu\.be|vimeo\.com|tiktok\.com)/)) {
          e.preventDefault();
          e.stopPropagation();

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

  function uploadImage(file) {
    let data = new FormData();
    data.append('file', file);
    data.append('_token', '{{ csrf_token() }}');
    $.ajax({
      url: '{{ route("admin.articles.upload.image") }}',
      method: 'POST',
      data: data,
      contentType: false,
      processData: false,
      success: function(url) {
        $('.summernote').summernote('insertImage', url);
      },
      error: function() {
        alert('Upload gambar gagal');
      }
    });
  }

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
