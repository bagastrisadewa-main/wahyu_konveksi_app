<section class="products-carousel container py-5">
  <h2 class="section-title text-center mb-5 fw-bold" style="font-size:2.2rem; position: relative;">
    Kategori Produk
    <span style="
      display:block;
      width:60px;
      height:4px;
      background:#000;
      margin:8px auto 0;
      border-radius:2px;
    "></span>
  </h2>

  <div class="position-relative">
    <div class="swiper-container js-swiper-categories">
      <div class="swiper-wrapper">

        @foreach($categories as $category)
          @php
            $images = $category->image ? json_decode($category->image, true) : [];
            $firstImage = $images[0] ?? 'assets_frontend/assets/images/no-image.png';
            $secondImage = $images[1] ?? $firstImage;
          @endphp

          <div class="swiper-slide product-card product-card_style3">
            <div class="pc__img-wrapper">
              <a href="{{ route('categories.show', $category->slug) }}">
                <img loading="lazy" src="{{ asset('storage/' . $firstImage) }}" class="pc__img" alt="{{ $category->name }}">
                <img loading="lazy" src="{{ asset('storage/' . $secondImage) }}" class="pc__img pc__img-second" alt="{{ $category->name }}">
              </a>
            </div>
            <div class="pc__info position-relative text-center">
              <h6 class="pc__title">
                <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
              </h6>
            </div>
          </div>
        @endforeach

        {{-- @foreach($categories as $category)
          @php
            $images = $category->image ? json_decode($category->image, true) : [];
            $firstImage = $images[0] ?? 'assets_frontend/assets/images/no-image.png';
            $secondImage = $images[1] ?? $firstImage;
          @endphp

          <div class="swiper-slide product-card product-card_style3">
            <div class="pc__img-wrapper">
              <a href="{{ route('categories.show', $category->slug) }}">
                <img loading="lazy" src="{{ asset('storage/' . $firstImage) }}" class="pc__img" alt="{{ $category->name }}">
                <img loading="lazy" src="{{ asset('storage/' . $secondImage) }}" class="pc__img pc__img-second" alt="{{ $category->name }}">
              </a>
            </div>
            <div class="pc__info position-relative text-center">
              <h6 class="pc__title">
                <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
              </h6>
            </div>
          </div>
        @endforeach --}}
      </div>
    </div>

    <div class="products-carousel__prev products-carousel__prev-1 position-absolute top-50 start-0 translate-middle-y d-flex align-items-center justify-content-center">
      <svg width="25" height="25" viewBox="0 0 25 25"><use href="#icon_prev_md" /></svg>
    </div>
    <div class="products-carousel__next products-carousel__next-1 position-absolute top-50 end-0 translate-middle-y d-flex align-items-center justify-content-center">
      <svg width="25" height="25" viewBox="0 0 25 25"><use href="#icon_next_md" /></svg>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
  new Swiper('.js-swiper-categories', {
    slidesPerView: 1, // default untuk mobile
    spaceBetween: 30,
    loop: true,
    loopedSlides: {{ $categories->count() }}, // tetap semua kategori masuk loop
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    navigation: {
      nextEl: '.products-carousel__next-1',
      prevEl: '.products-carousel__prev-1'
    },
    breakpoints: {
      320: { slidesPerView: 1, spaceBetween: 14 },
      576: { slidesPerView: 2, spaceBetween: 20 },
      768: { slidesPerView: 3, spaceBetween: 24 },
      1200: { slidesPerView: 4, spaceBetween: 30 }, // <- desktop tampil 4 kategori saja
    }
  });
});
</script>
