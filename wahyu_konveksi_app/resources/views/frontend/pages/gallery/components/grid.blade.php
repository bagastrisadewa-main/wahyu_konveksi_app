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
          @foreach($images as $img)
            <div class="swiper-slide">
              <div class="card border-0 shadow-sm rounded-8 overflow-hidden">
                <a href="{{ asset('storage/'.$img) }}"
                   class="glightbox"
                   data-gallery="all-gallery"
                   data-title="{{ $gallery->title }}">
                  <img src="{{ asset('storage/'.$img) }}"
                       alt="{{ $gallery->title }}"
                       class="img-fluid gallery-img w-100">
                </a>
              </div>
              <p class="text-center mt-2 fw-semibold">{{ $gallery->title }}</p>
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
              <div class="card border-0 shadow-sm rounded-8 overflow-hidden">

                {{-- Gambar utama --}}
                <a href="{{ asset('storage/'.$firstImage) }}"
                   class="glightbox"
                   data-gallery="gallery-{{ $gallery->id }}"
                   data-title="{{ $gallery->title }}">
                  <img src="{{ asset('storage/'.$firstImage) }}"
                       alt="{{ $gallery->title }}"
                       class="img-fluid gallery-img w-100">
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
              <p class="text-center mt-2 fw-semibold">{{ $gallery->title }}</p>
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
                        <div class="card border-0 shadow-sm rounded-8 overflow-hidden">

                            {{-- Judul gallery sebagai "kategori" --}}
                            <h4 class="gallery-title text-center">{{ $gallery->title }}</h4>

                            {{-- Gambar utama --}}
                            <a href="{{ asset('storage/'.$firstImage) }}"
                               class="glightbox"
                               data-gallery="gallery-uncategorized-{{ $gallery->id }}"
                               data-title="{{ $gallery->title }}">
                                <img src="{{ asset('storage/'.$firstImage) }}"
                                     alt="{{ $gallery->title }}"
                                     class="img-fluid gallery-img w-100">
                            </a>

                                    {{-- Judul kecil di bawah gambar utama --}}
                            <p class="text-center mt-2 fw-semibold">{{ $gallery->title }}</p>

                            {{-- Gambar tambahan untuk Lightbox --}}
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


  {{-- @if($uncategorized->count())
    <div class="category-block mb-5">

        @foreach($uncategorized as $gallery)
      @php
          $images = galleryImages($gallery);
          $firstImage = $images[0] ?? null;
      @endphp

      <div class="category-block mb-5">
          <h4 class="gallery-title text-center">Uncategorized</h4>

          <div class="swiper-container js-swiper-gallery-uncategorized-{{ $gallery->id }}"
              data-settings='{ "autoplay": { "delay": 3000 }, "slidesPerView": 3, "spaceBetween": 20, "loop": true,
                "breakpoints": { "320": { "slidesPerView": 1 }, "576": { "slidesPerView": 2 }, "992": { "slidesPerView": 3 } } }'>
              <div class="swiper-wrapper">
                  <div class="swiper-slide" data-images="{{ htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8') }}">
                      <div class="card border-0 shadow-sm rounded-8 overflow-hidden">
                          <a href="{{ asset('storage/'.$firstImage) }}"
                            class="glightbox"
                            data-gallery="gallery-uncategorized-{{ $gallery->id }}"
                            data-title="{{ $gallery->title }}">
                              <img src="{{ asset('storage/'.$firstImage) }}"
                                  alt="{{ $gallery->title }}"
                                  class="img-fluid gallery-img w-100">
                          </a>
                      </div>
                      <p class="text-center mt-2 fw-semibold">{{ $gallery->title }}</p>
                  </div>
              </div>
          </div>
      </div>
  @endforeach


    </div>
  @endif --}}

@endif


</section>

<style>
  .gallery-img {
    width: 100%;
    height: auto; /* biarkan gambar natural */
    object-fit: contain; /* tidak memotong gambar */
    border-radius: 12px;
    transition: transform .3s ease-in-out;
    background: #f8f9fa; /* biar ada background abu2 kalo gambar transparan */
  }
  .gallery-img:hover {
    transform: scale(1.05);
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

  document.querySelectorAll(".swiper-slide").forEach(function(slide) {
  let imgEl = slide.querySelector("img");
  let images = JSON.parse(slide.dataset.images || '[]');
  let index = 0;

  slide.addEventListener("mouseenter", function() {
    if(images.length <= 1) return;
    index = (index + 1) % images.length;
    imgEl.src = "{{ asset('storage/') }}/" + images[index].replace(/^storage\//,'');
  });

  slide.addEventListener("mouseleave", function() {
    imgEl.src = "{{ asset('storage/') }}/" + images[0].replace(/^storage\//,'');
    index = 0;
  });
});

  
</script>
