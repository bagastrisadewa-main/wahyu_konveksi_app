@if($sliders->isNotEmpty())
<section class="swiper-container js-swiper-slider swiper-number-pagination slideshow" data-settings='{
  "autoplay": { "delay": 5000 },
  "slidesPerView": 1,
  "effect": "fade",
  "loop": true
}'>
  <div class="swiper-wrapper">
    @foreach($sliders->where('is_active', 1)->sortBy('order') as $slide)
      @php
        $img = $slide->image ?? null;
        $imgUrl = asset('assets_frontend/assets/images/placeholder.jpg');

        if ($img) {
            if (file_exists(public_path('storage/' . $img))) {
                $imgUrl = asset('storage/' . $img);
            } elseif (file_exists(public_path('assets_frontend/assets/images/' . $img))) {
                $imgUrl = asset('assets_frontend/assets/images/' . $img);
            } else {
                $imgUrl = asset('assets_frontend/assets/images/' . $img);
            }
        }
      @endphp

      <div class="swiper-slide">
        <div class="overflow-hidden position-relative h-100">

          {{-- Gambar utama --}}
          <div class="slideshow-character position-absolute bottom-0 pos_right-center">
            <img loading="lazy"
                 src="{{ $imgUrl }}"
                 alt="{{ $slide->title ?? '' }}"
                 class="slideshow-character__img animate animate_fade animate_btt animate_delay-9 w-auto h-auto" />

            {{-- Tulisan besar transparan di belakang --}}
            @if(!empty($slide->title))
              <div class="character_markup type2">
                <p class="text-uppercase font-sofia mark-grey-color animate animate_fade animate_btt animate_delay-10 mb-0">
                  {{ $slide->title }}
                </p>
              </div>
            @endif
          </div>

          {{-- Text sejajar dengan pagination --}}
          <div class="container position-absolute top-50 start-50 translate-middle">
            <div class="row">
              <div class="col-lg-6">
                @if(!empty($slide->subtitle))
                  <h6 class="text_dash text-uppercase fs-base fw-medium animate animate_fade animate_btt animate_delay-3">
                    {{ $slide->subtitle }}
                  </h6>
                @endif

                <h2 class="h1 fw-bold mb-3 animate animate_fade animate_btt animate_delay-5">
                  {{ $slide->title ?? '' }}
                </h2>

                @if(!empty($slide->button_text))
                  <a href="{{ $slide->button_link ?? '#' }}"
                     class="btn btn-outline-dark rounded-pill px-4 py-2 fw-medium animate animate_fade animate_btt animate_delay-7">
                     {{ $slide->button_text }}
                  </a>
                @endif
              </div>
            </div>
          </div>

        </div>
      </div>
    @endforeach
  </div>

{{-- Pagination Number --}}
 <div class="container"> <div class="slideshow-pagination slideshow-number-pagination d-flex align-items-center position-absolute bottom-0 mb-5"></div> </div>
</section>
@endif
