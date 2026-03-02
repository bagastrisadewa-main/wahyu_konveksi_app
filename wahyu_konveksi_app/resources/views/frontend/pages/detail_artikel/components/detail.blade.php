    {{-- Hero Section --}}
    <div class="hero-section position-relative" style="margin-top:80px;">
        {{-- Background full --}}
        <img src="{{ asset('assets_frontend/assets/images/bg.jpg') }}" 
            alt="Hero Background" 
            class="w-100" 
            style="height:320px; object-fit:cover; object-position:center; display:block;">

        {{-- Overlay judul + breadcrumb --}}
        <div class="position-absolute top-50 start-50 translate-middle text-center px-3">
            <h1 class="fw-bold display-5 text-dark mb-3">Detail Artikel</h1>

            @php
                $home = $navigationMenus->firstWhere('slug', 'home') ?? $navigationMenus->firstWhere('slug', 'beranda');
                $artikelMenu = $navigationMenus->firstWhere('slug', 'artikel');
            @endphp

            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a href="{{ url($home->url ?? route('frontend.home')) }}" 
                  class="text-dark fw-semibold text-decoration-none fs-5">
                    {{ $home->title ?? 'Beranda' }}
                </a>
                <span class="text-dark fs-5">/</span>
                <span class="text-dark fw-semibold fs-5">
                    {{ $artikelMenu->title ?? 'Artikel' }}
                </span>
            </div>
        </div>
    </div>
      

{{-- Konten utama --}}
<div class="container py-5">
  <div class="row">

    {{-- Kiri (Konten Artikel) --}}
    <div class="col-lg-8">

            {{-- Judul Artikel --}}
      <h2 class="fw-bold mb-3 text-center">{{ $article->title }}</h2>

      {{-- Tanggal --}}
      <p class="text-muted small text-center mb-2">{{ $article->created_at->format('d M Y') }}</p>



      {{-- Gambar Artikel --}}
      @if($article->images->first())
        <div class="text-center mb-4">
          <img src="{{ asset('storage/' . $article->images->first()->image_path) }}" 
               alt="{{ $article->title }}" 
               class="img-fluid rounded shadow-sm">
        </div>
      @endif

      {{-- Konten Artikel --}}
      <div class="content mb-5 article-content">
          {!! $article->content !!}
      </div>

      {{-- Style khusus untuk konten artikel --}}
      @push('styles')
      <style>
      .article-content iframe {
          width: 100%;
          max-width: 100%;
          aspect-ratio: 16 / 9;
          border-radius: 10px;
          margin-top: 15px;
          margin-bottom: 15px;
          display: block;
      }
      .article-content img {
          max-width: 100%;
          height: auto;
          border-radius: 8px;
          margin-top: 10px;
          margin-bottom: 10px;
      }
      .article-content p {
          line-height: 1.8;
          color: #333;
      }
      </style>
      @endpush

      {{-- Script untuk memastikan iframe pakai protokol HTTPS --}}
      @push('scripts')
      <script>
      document.addEventListener("DOMContentLoaded", function() {
          document.querySelectorAll('.article-content iframe').forEach(function(iframe) {
              if (iframe.src.startsWith("//")) {
                  iframe.src = "https:" + iframe.src;
              }
              iframe.setAttribute("allowfullscreen", "true");
          });
      });
      </script>
      <script async src="https://www.tiktok.com/embed.js"></script>
      @endpush

      {{-- Komentar --}}
      <div class="mb-4">
        <h4 class="mb-3">Komentar</h4>
        <ul id="comment-list" class="list-unstyled">
          @forelse($comments as $cmt)
            <li class="mb-3 border-bottom pb-2">
              <strong>{{ $cmt->name }}</strong>
              <span class="text-warning">{!! str_repeat('⭐', $cmt->rating) !!}</span><br>
              <small class="text-muted">{{ $cmt->created_at->diffForHumans() }}</small>
              <p class="mb-0">{{ $cmt->comment }}</p>
            </li>
          @empty
            <p class="text-muted">Belum ada komentar.</p>
          @endforelse
        </ul>
      </div>

   
      {{-- Form Komentar --}}
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h4 class="mb-4">Tinggalkan Komentar</h4>

          @auth('customer')
            <form method="POST" action="{{ route('frontend.detail_artikel.comment', $article->id) }}">
              @csrf

              <div class="mb-3">
                <label class="form-label">Rating</label>
                <select name="rating" class="form-select" required>
                  <option value="">Pilih rating</option>
                  <option value="5">⭐⭐⭐⭐⭐</option>
                  <option value="4">⭐⭐⭐⭐</option>
                  <option value="3">⭐⭐⭐</option>
                  <option value="2">⭐⭐</option>
                  <option value="1">⭐</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Komentar</label>
                <textarea name="comment" class="form-control" rows="4" required></textarea>
              </div>

              <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
          @else
            <div class="alert alert-warning mb-0">
              <strong>Login diperlukan.</strong><br>
              Silakan <a href="{{ route('frontend.login') }}?redirect={{ url()->current() }}" class="fw-semibold">
                login terlebih dahulu
              </a> untuk memberikan komentar.
            </div>
          @endauth

        </div>
      </div>


    </div>

    {{-- Kanan (Sidebar) --}}
    <div class="col-lg-4">
      <div class="ps-lg-4">

        {{-- Search --}}
        <div class="mb-4">
          <form action="{{ route('frontend.artikel.index') }}" method="GET" class="d-flex">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari artikel...">
            <button class="btn btn-dark ms-2">Cari</button>
          </form>
        </div>

          {{-- Latest Posts --}}
          <div class="mb-5">
            <h5 class="fw-bold mb-4 fs-4">Latest Posts</h5>

            @foreach($latestPosts as $post)
              <div class="d-flex mb-4 align-items-start">
                {{-- Gambar --}}
                @if($post->images->first())
                  <img src="{{ asset('storage/' . $post->images->first()->image_path) }}" 
                      class="me-3 rounded-3"
                      style="width:120px; height:90px; object-fit:cover;" 
                      alt="{{ $post->title }}">
                @else
                  <img src="{{ asset('assets_frontend/assets/images/bg.jpg') }}" 
                      class="me-3 rounded-3"
                      style="width:120px; height:90px; object-fit:cover;" 
                      alt="Default">
                @endif

                {{-- Info Artikel --}}
                <div class="flex-grow-1">
                  <a href="{{ route('frontend.detail_artikel.show', $post->slug) }}" 
                    class="fw-bold text-dark text-decoration-none d-block mb-1 fs-6">
                    {{ Str::limit($post->title, 80) }}
                  </a>
                  <small class="text-muted d-block mb-2">
                    {{ $post->created_at->format('d M Y') }}
                  </small>
                  <p class="text-muted small mb-0">
                    {{ Str::limit(strip_tags($post->content), 90) }}
                  </p>
                </div>
              </div>
            @endforeach
          </div>



          {{-- Social --}}
          <div class="mb-4">
            <h5 class="fw-bold mb-3">Social</h5>

            {{-- Sosmed --}}
            <ul class="social-links list-unstyled d-flex gap-3 mt-3 mb-0">
              <li>
                <a href="https://www.instagram.com/konveksijogja.whs/?hl=en" 
                  target="_blank" rel="noopener" 
                  class="footer__social-link d-block">
                  <svg class="svg-icon svg-icon_instagram" width="18" height="18">
                    <use href="#icon_instagram" />
                  </svg>
                </a>
              </li>
              <li>
                <a href="https://facebook.com/" target="_blank" rel="noopener" 
                  class="footer__social-link d-block">
                  <svg class="svg-icon" width="18" height="18">
                    <use href="#icon_facebook" />
                  </svg>
                </a>
              </li>
              <li>
                <a href="https://youtube.com/" target="_blank" rel="noopener" 
                  class="footer__social-link d-block">
                  <svg class="svg-icon" width="18" height="18">
                    <use href="#icon_youtube" />
                  </svg>
                </a>
              </li>
            </ul>
          </div>


          {{-- Tags --}}
          @if(!empty($tags))
          <div class="mb-4">
            <h5 class="fw-bold mb-3">Tags</h5>
            <div class="d-flex flex-wrap gap-2">
              @foreach($tags as $tag)
                <a href="{{ url('/artikel?tag=' . urlencode($tag)) }}" 
                  class="btn btn-outline-dark btn-sm mb-2">
                  {{ $tag }}
                </a>
              @endforeach
            </div>
          </div>
          @endif


      </div>
    </div>

  </div>
</div>
