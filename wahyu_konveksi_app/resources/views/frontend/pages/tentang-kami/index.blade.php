@extends('frontend.layouts.app')

@section('title', 'Tentang Kami')

@section('content')

  {{-- Slider --}}
  @include('frontend.pages.beranda.components.slider', ['sliders' => $sliders])

  {{-- Tentang Kami Section --}}
  <section class="about-us container py-5 mb-5">
      @foreach($abouts as $index => $about)
          <div class="row align-items-center mb-5">
              
              {{-- Kalau index genap: gambar kiri, teks kanan --}}
              @if($index % 2 == 0)
                  <div class="col-md-6 mb-4 mb-md-0 text-center">
                      <img loading="lazy" 
                           src="{{ asset('storage/' . $about->image) }}" 
                           alt="{{ $about->title }}" 
                           class="img-fluid rounded shadow w-100 h-100" 
                           style="object-fit:cover; border-radius:15px;">
                  </div>
                  <div class="col-md-6 ps-md-4">
                      @if($about->banner_title)
                          <p class="text-primary fw-semibold mb-2" 
                             style="font-size:1.1rem; border-bottom:2px solid #0d6efd; display:inline-block;">
                              {{ $about->banner_title }}
                          </p>
                      @endif
                      <h2 class="fw-bold" style="font-size:2rem; line-height:1.2;">
                          {{ $about->title }}
                      </h2>
                      <p style="font-size:1.2rem; line-height:1.6; margin-top:1rem;">
                          {{ $about->description }}
                      </p>
                  </div>
              @else
                  {{-- Kalau index ganjil: teks kiri, gambar kanan --}}
                  <div class="col-md-6 pe-md-4 order-2 order-md-1">
                      @if($about->banner_title)
                          <p class="text-primary fw-semibold mb-2" 
                             style="font-size:1.1rem; border-bottom:2px solid #0d6efd; display:inline-block;">
                              {{ $about->banner_title }}
                          </p>
                      @endif
                      <h2 class="fw-bold" style="font-size:2rem; line-height:1.2;">
                          {{ $about->title }}
                      </h2>
                      <p style="font-size:1.2rem; line-height:1.6; margin-top:1rem;">
                          {{ $about->description }}
                      </p>
                  </div>
                  <div class="col-md-6 mb-4 mb-md-0 text-center order-1 order-md-2">
                      <img loading="lazy" 
                           src="{{ asset('storage/' . $about->image) }}" 
                           alt="{{ $about->title }}" 
                           class="img-fluid rounded shadow w-100 h-100" 
                           style="object-fit:cover; border-radius:15px;">
                  </div>
              @endif

          </div>
      @endforeach
  </section>


 {{-- Section Visi & Misi --}}
<section class="visi-misi position-relative py-5" 
         style="background: url('{{ asset('assets_frontend/assets/images/about/bg.jpg') }}') no-repeat center center/cover;">
    {{-- Overlay transparan --}}
    <div class="position-absolute top-0 start-0 w-100 h-100" 
         style="background: rgba(0,0,0,0.5); z-index:0;"></div>

    <div class="container position-relative" style="z-index:1;">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center">
                <h2 class="fw-bold text-white mb-3" style="font-size:2.5rem;">Visi & Misi Kami</h2>
                <p class="text-white" style="font-size:1.3rem;">
                    Komitmen kami dalam memberikan layanan terbaik dan kontribusi nyata bagi masyarakat
                </p>
            </div>
        </div>

        <div class="row justify-content-center g-4">
            {{-- Visi --}}
            <div class="col-md-5">
                <div class="card bg-white bg-opacity-75 text-dark h-100 shadow-lg border-0 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('assets_frontend/assets/images/icon/visi.png') }}" alt="Visi" class="me-3" width="40">
                        <h4 class="fw-bold mb-0">Visi Kami</h4>
                    </div>
                    <p class="mb-0">
                        Menjadi produsen textile dan garment terbesar, terbaik dan terpercaya dalam sub spesialis jaket & almamater
                    </p>
                </div>
            </div>

            {{-- Misi --}}
            <div class="col-md-5">
                <div class="card bg-white bg-opacity-75 text-dark h-100 shadow-lg border-0 p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('assets_frontend/assets/images/icon/misi.png') }}" alt="Misi" class="me-3" width="40">
                        <h4 class="fw-bold mb-0">Misi Kami</h4>
                    </div>
                    <ul class="mb-0">
                        <li>Menghasilkan produk-produk fashion jaket terbaik</li>
                        <li>Inovatif & kreatif untuk memenuhi kebutuhan pasar</li>
                        <li>Menjadi mitra handal untuk para pelanggan B2B/B2C</li>
                        <li>Mengurangi pengangguran dan mensejahterakan masyarakat sekitar</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- CTA WhatsApp --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-10 text-center">
                <h4 class="fw-bold mb-3 text-white" style="font-size:1.8rem;">
                    Hubungi kami untuk konsultasi dan pemesanan
                </h4>
                <p class="text-white mb-4" style="font-size:1.2rem;">
                    Kami siap menjadi mitra terpercaya Anda dalam memenuhi kebutuhan konveksi.
                </p>
                <a href="https://api.whatsapp.com/send/?phone=6287738728252&text&type=phone_number&app_absent=0" 
                   class="btn px-4 py-2 rounded-pill d-inline-flex align-items-center gap-2" 
                   style="background: rgba(27, 43, 108,0.9); color:#fff;" target="_blank" rel="noopener">
                    <img src="{{ asset('assets_frontend/assets/images/icon/wa.png') }}" width="20" height="20" alt="WhatsApp" style="filter: brightness(0) invert(1);">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Section Alamat Kami --}}
<section class="alamat-kami container py-5">
    <div class="row align-items-center g-4">

        {{-- Google Maps --}}
        <div class="col-md-7">
            <div class="ratio ratio-16x9 rounded-5 shadow-lg overflow-hidden">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15959.273281372596!2d0!3d0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a57e88453856f%3A0x41363ab8b8e8be2!2sKONVEKSI%20JOGJA%20%7C%20Tempat%20Bikin%20Jaket%2C%20Baju%2C%20%26%20Kaos!5e0!3m2!1sid!2sid!4v1759071256800!5m2!1sid!2sid" 
                    width="100%" height="100%" style="border:0;" 
                    allowfullscreen="" loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        {{-- Box Info Alamat --}}
        <div class="col-md-5">
            <div class="card shadow-lg border-0 h-100 p-5 rounded-5">
                <div class="d-flex align-items-center mb-4">
                    <img src="{{ asset('assets_frontend/assets/images/icon/maps.png') }}" 
                        alt="Maps Icon" width="38" class="me-3">
                    <h4 class="fw-bold mb-0">Alamat Kami</h4>
                </div>
                <p class="mb-0" style="font-size:1.2rem; line-height:1.8;">
                    Jl. Nitiprayan No.89B RT.03 DK.VII, Desa Ngestiharjo,<br>
                    Kec. Kasihan, Kab. Bantul, D.I. Yogyakarta
                </p>
            </div>
        </div>

    </div>
</section>





@endsection
