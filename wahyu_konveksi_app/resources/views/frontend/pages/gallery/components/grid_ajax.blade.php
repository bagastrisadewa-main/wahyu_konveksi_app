@php
  function galleryImages($gallery) {
      if (is_array($gallery->image)) return $gallery->image;
      $decoded = @json_decode($gallery->image, true);
      return is_array($decoded) ? $decoded : ($gallery->image ? [$gallery->image] : []);
  }
@endphp

@foreach($galleries as $gallery)
  @php $images = galleryImages($gallery); @endphp

  <h4 class="gallery-title text-center">{{ $gallery->title }}</h4>

  <div class="swiper-container js-swiper-gallery-{{ $gallery->id }}"
       data-settings='{ "autoplay": { "delay": 3000 }, "slidesPerView": 3, "spaceBetween": 20, "loop": true,
         "breakpoints": { "320": { "slidesPerView": 1 }, "576": { "slidesPerView": 2 }, "992": { "slidesPerView": 3 } } }'>
    <div class="swiper-wrapper">
      @foreach($images as $img)
        <div class="swiper-slide">
          <div class="card border-0 shadow-sm overflow-hidden">
            <a href="{{ asset('storage/'.$img) }}"
               class="glightbox"
               data-gallery="gallery-{{ $gallery->id }}"
               data-title="{{ $gallery->title }}">
              <img src="{{ asset('storage/'.$img) }}"
                   alt="{{ $gallery->title }}"
                   class="img-fluid gallery-img w-100">
            </a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endforeach
