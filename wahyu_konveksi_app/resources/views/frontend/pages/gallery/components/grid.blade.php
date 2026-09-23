@php
  function galleryImages($gallery) {
      if (is_array($gallery->image)) return $gallery->image;
      $decoded = @json_decode($gallery->image, true);
      return is_array($decoded) ? $decoded : ($gallery->image ? [$gallery->image] : []);
  }
@endphp

<section class="container py-5">

{{-- Semua Gallery / Sesuai Judul yg Dipilih --}}
@if($selectedGallery->count())
  <div class="all-gallery-block mb-5">
    <h3 class="fw-bold mb-4 text-dark text-center">
      {{ request('title') ? 'Gallery Terpilih' : 'Semua Gallery' }}
    </h3>

    <div class="swiper-container js-swiper-all-gallery"
         data-settings='{ "autoplay": { "delay": 3000 }, "slidesPerView": 4, "spaceBetween": 20, "loop": true,
           "breakpoints": { "320": { "slidesPerView": 1 }, "576": { "slidesPerView": 2 }, "768": { "slidesPerView": 3 }, "1200": { "slidesPerView": 4 } } }'>
      <div class="swiper-wrapper">

        @foreach($selectedGallery as $gallery)
          @php $images = galleryImages($gallery); @endphp
          @foreach($images as $key => $img)
            <div class="swiper-slide">
              <div class="gallery-card">
                <a href="{{ asset('storage/'.$img) }}"
                   class="glightbox gallery-card__link"
                   data-gallery="all-gallery"
                   data-title="{{ $gallery->title }}">
                  <div class="gallery-card__img-wrapper">
                    <img src="{{ asset('storage/'.$img) }}"
                         alt="{{ $gallery->title }}"
                         class="gallery-card__img"
                         loading="lazy">
                    <div class="gallery-card__overlay">
                      <i class="fa fa-search-plus"></i>
                    </div>
                  </div>
                  <div class="gallery-card__caption">
                    {{ $gallery->title }}
                  </div>
                </a>
              </div>
            </div>
          @endforeach
        @endforeach

      </div>
    </div>
  </div>
@endif


{{-- ✅ Tampilkan kategori & uncategorized hanya jika tidak ada filter --}}
@if(!request('title'))

  {{-- Per Kategori --}}
  @foreach($categories as $category)
    @if($category->galleries->count())
      <div class="category-block mb-5">
        <h4 class="gallery-title text-center">{{ $category->name }}</h4>

        <div class="swiper-container js-swiper-category-{{ $category->id }}"
             data-settings='{ "autoplay": { "delay": 3000 }, "slidesPerView": 3, "spaceBetween": 20, "loop": true,
               "breakpoints": { "320": { "slidesPerView": 1 }, "576": { "slidesPerView": 2 }, "992": { "slidesPerView": 3 } } }'>
          <div class="swiper-wrapper">

            @foreach($category->galleries as $gallery)
              @php
                $images = galleryImages($gallery);
                $firstImage = $images[0] ?? null;
              @endphp

              <div class="swiper-slide">
                <div class="gallery-card">

                  <a href="{{ asset('storage/'.$firstImage) }}"
                     class="glightbox gallery-card__link"
                     data-gallery="gallery-{{ $gallery->id }}"
                     data-title="{{ $gallery->title }}">
                    <div class="gallery-card__img-wrapper">
                      <img src="{{ asset('storage/'.$firstImage) }}"
                           alt="{{ $gallery->title }}"
                           class="gallery-card__img"
                           loading="lazy">
                      <div class="gallery-card__overlay">
                        <i class="fa fa-search-plus"></i>
                      </div>
                    </div>
                    <div class="gallery-card__caption">
                      {{ $gallery->title }}
                    </div>
                  </a>

                  {{-- Gambar tambahan untuk Lightbox --}}
                  @foreach($images as $key => $img)
                    @if($key > 0)
                      <a href="{{ asset('storage/'.$img) }}"
                         class="glightbox d-none"
                         data-gallery="gallery-{{ $gallery->id }}"
                         data-title="{{ $gallery->title }}"></a>
                    @endif
                  @endforeach

                </div>
              </div>

            @endforeach

          </div>
        </div>
      </div>
    @endif
  @endforeach


  {{-- Tanpa Kategori --}}
  @if($uncategorized->count())
    <div class="category-block mb-5">
      <h4 class="gallery-title text-center">Lainnya</h4>

      <div class="swiper-container js-swiper-uncategorized"
           data-settings='{ "autoplay": { "delay": 3000 }, "slidesPerView": 3, "spaceBetween": 20, "loop": true,
             "breakpoints": { "320": { "slidesPerView": 1 }, "576": { "slidesPerView": 2 }, "992": { "slidesPerView": 3 } } }'>
        <div class="swiper-wrapper">

          @foreach($uncategorized as $gallery)
            @php
              $images = galleryImages($gallery);
              $firstImage = $images[0] ?? null;
            @endphp

            <div class="swiper-slide">
              <div class="gallery-card">

                <a href="{{ asset('storage/'.$firstImage) }}"
                   class="glightbox gallery-card__link"
                   data-gallery="gallery-uncategorized-{{ $gallery->id }}"
                   data-title="{{ $gallery->title }}">
                  <div class="gallery-card__img-wrapper">
                    <img src="{{ asset('storage/'.$firstImage) }}"
                         alt="{{ $gallery->title }}"
                         class="gallery-card__img"
                         loading="lazy">
                    <div class="gallery-card__overlay">
                      <i class="fa fa-search-plus"></i>
                    </div>
                  </div>
                  <div class="gallery-card__caption">
                    {{ $gallery->title }}
                  </div>
                </a>

                @foreach($images as $key => $img)
                  @if($key > 0)
                    <a href="{{ asset('storage/'.$img) }}"
                       class="glightbox d-none"
                       data-gallery="gallery-uncategorized-{{ $gallery->id }}"
                       data-title="{{ $gallery->title }}"></a>
                  @endif
                @endforeach

              </div>
            </div>

          @endforeach

        </div>
      </div>
    </div>
  @endif

@endif

</section>

<style>
  /* ===== Card gallery — ukuran gambar selalu konsisten ===== */
  .gallery-card {
    border-radius: 18px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .gallery-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(0,0,0,0.15);
  }

  .gallery-card__link {
    display: block;
    text-decoration: none;
    color: inherit;
  }

  .gallery-card__img-wrapper {
    position: relative;
    width: 100%;
   aspect-ratio: 3 / 4;
    overflow: hidden;
    background: #f1f1f1;
  }

  .gallery-card__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
  }

  .gallery-card:hover .gallery-card__img {
    transform: scale(1.08);
  }

  .gallery-card__overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.6rem;
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .gallery-card:hover .gallery-card__overlay {
    opacity: 1;
  }

  .gallery-card__caption {
    padding: 12px 14px;
    font-weight: 600;
    font-size: 0.95rem;
    color: #212529;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .gallery-title {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    font-weight: 700;
    color: #333;
    margin: 2rem 0 1.5rem 0;
    text-transform: capitalize;
  }

  .gallery-title::before,
  .gallery-title::after {
    content: "";
    flex: 1;
    height: 2px;
    background: #ddd;
    margin: 0 15px;
  }
</style>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".swiper-container").forEach(function(el) {
      let settings = el.getAttribute("data-settings");
      if (settings) {
        new Swiper(el, JSON.parse(settings));
      }
    });

    GLightbox({
      selector: '.glightbox',
      touchNavigation: true,
      loop: true
    });
  });
</script>