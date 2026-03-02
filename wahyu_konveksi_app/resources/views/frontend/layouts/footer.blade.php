@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    $customer = Auth::guard('customer')->user();
@endphp
<hr class="mt-5 text-secondary" />

{{-- FOOTER DESKTOP --}}
<footer class="footer footer_type_2 d-none d-md-block">
  <div class="footer-middle container">
    <div class="row row-cols-lg-5 row-cols-2">
      
{{-- Kolom Store Info --}}
<div class="footer-column footer-store-info col-12 mb-4 mb-lg-0">
  <div class="d-flex flex-column text-start">
    {{-- Logo --}}
    <div class="logo mb-3">
      <a href="{{ url('/') }}">
        <img 
          src="{{ isset($appSettings['store_logo']) 
                    ? asset('storage/settings/' . $appSettings['store_logo']) 
                    : asset('assets_frontend/assets/images/logo.png') }}"
          alt="{{ $appSettings['store_name'] ?? 'Logo' }}"
          class="logo__image"
          style="max-height:70px;"/>
      </a>
    </div>

    {{-- Alamat --}}
    <p class="footer-address mb-2">
      <a href="https://maps.app.goo.gl/32eZ6NYjjz9BDsPn8" 
         target="_blank" rel="noopener" 
         class="text-decoration-none text-dark">
        Jl.Nitiprayan No.89B RT.03 DK.VII, Desa Ngestiharjo,<br>
        Kec. Kasihan, Kab. Bantul, D. I. Yogyakarta
      </a>
    </p>

    {{-- Kontak --}}
      @php
          $waNumber = $appSettings['whatsapp'] ?? '6287738728252';
          // Format nomor untuk ditampilkan (bisa pakai spasi seperti contoh)
          $displayNumber = preg_replace('/(\d{4})(\d{4})(\d+)/', '$1 $2 $3', $waNumber);
      @endphp

      <p class="m-0 mb-1 d-flex align-items-center gap-2">
          <img src="{{ asset('assets_frontend/assets/images/icon/hp.png') }}" width="16" height="16" alt="Phone">
          <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ urlencode('Halo WHS Konveksindo, saya ingin bertanya terkait layanan konveksi yang tersedia. Terima kasih.') }}" 
            class="text-dark text-decoration-none" target="_blank" rel="noopener">
              {{ $displayNumber }}
          </a>
      </p>

    <p class="m-0">
      <strong class="fw-medium">
        <a href="mailto:whskonveksindo@gmail.com" class="text-dark text-decoration-none">
          whskonveksindo@gmail.com
        </a>
      </strong>
    </p>

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
</div>


      {{-- MENU --}}
      <div class="footer-column footer-menu mb-4 mb-lg-0">
        <h6 class="sub-menu__title text-uppercase">Menu</h6>
        <ul class="sub-menu__list list-unstyled">
          @foreach($navigationMenus->where('parent_id', null) as $menu)
            <li class="sub-menu__item">
              <a href="{{ $menu->url }}" class="menu-link menu-link_us-s">
                {{ $menu->title }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>

              {{-- KATEGORI
          <div class="footer-column footer-menu mb-4 mb-lg-0">
            <h6 class="sub-menu__title text-uppercase">Kategori</h6>
            <ul class="sub-menu__list list-unstyled">
              @isset($categories)
                @foreach($categories as $kategori)
                  <li class="sub-menu__item">
                    <a href="{{ url('/kategori/'.$kategori->slug) }}" class="menu-link menu-link_us-s">
                      {{ $kategori->name }}
                    </a>
                  </li>
                @endforeach
              @endisset
            </ul>
          </div> --}}


{{-- Produk (Kategori) --}}
<div class="footer-column footer-menu mb-4 mb-lg-0">
    <h6 class="sub-menu__title text-uppercase">Produk</h6>
    <ul class="sub-menu__list list-unstyled">
        @isset($categories)
            @foreach($categories as $category)
                <li class="sub-menu__item">
                    <a href="{{ url('/kategori/' . $category->slug) }}" class="menu-link menu-link_us-s">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        @endisset
    </ul>
</div>


{{-- Artikel --}}
<div class="footer-column footer-menu mb-4 mb-lg-0">
  <h6 class="sub-menu__title text-uppercase">Artikel</h6>
  <ul class="sub-menu__list list-unstyled">
    @foreach($articles as $article)
      <li class="sub-menu__item">
        <a href="{{ url('/artikel/' . $article->slug) }}" class="menu-link menu-link_us-s">
          {{ mb_strimwidth($article->title, 0, 25, '...') }}
        </a>
      </li>
    @endforeach
  </ul>
</div>





          {{-- Penawaran Khusus --}}
      <div class="footer-column footer-menu mb-4 mb-lg-0">
        <div class="footer-column footer-menu mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=whskonveksindo@gmail.com&su=Penawaran%20Khusus%20WHSKonveksindo&body=Halo%20WHSKonveksindo,%0ASaya%20ingin%20menanyakan%20penawaran%20khusus.%0ATerima%20kasih."
            {{-- <a href="mailto:whskonveksindo@gmail.com?subject=Penawaran%20Khusus%20WHSKonveksindo&body=Halo%20WHSKonveksindo,%0ASaya%20ingin%20menanyakan%20penawaran%20khusus.%0ATerima%20kasih." --}}
              class="btn-penawaran-khusus">
                ✉️ Penawaran Khusus
            </a>
        </div>
      </div>
    </div>



  </div>




  <div class="footer-bottom">
    <div class="container d-md-flex align-items-center">
      <span class="footer-copyright me-auto">
        ©{{ date('Y') }} {{ $appSettings['site_name'] ?? 'WHSKonveksindo' }}
      </span>
      <div class="footer-settings d-md-flex align-items-center">
        <a href="{{ url('/privacy-policy') }}">Privacy Policy</a> &nbsp;|&nbsp;
        <a href="{{ url('/terms') }}">Terms &amp; Conditions</a>
      </div>
    </div>
  </div>
</footer>

{{-- FOOTER MOBILE --}}
    <footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
      <div class="row text-center">
        
        {{-- Home --}}
        <div class="col-3">
          <a href="{{ url('/') }}" class="footer-mobile__link d-flex flex-column align-items-center">
            <svg class="d-block" width="18" height="18"><use href="#icon_home" /></svg>
            <span>Home</span>
          </a>
        </div>

        {{-- Produk --}}
        <div class="col-3">
          <a href="{{ url('/produk') }}" class="footer-mobile__link d-flex flex-column align-items-center">
            <img src="{{ asset('assets_frontend/assets/images/icon/clothes.png') }}" width="25" height="25" alt="Produk">
            <span>Produk</span>
          </a>
        </div>

        {{-- WhatsApp --}}
        @php
            $waNumber = $appSettings['whatsapp'] ?? '6287738728252';
        @endphp

        <div class="col-3">
            <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text=Halo%20WHSKonveksindo,%20saya%20ingin%20bertanya%20terkait%20layanan%20konveksi%20yang%20tersedia.%20Terima%20kasih."
              target="_blank"
              rel="noopener"
              class="footer-mobile__link d-flex flex-column align-items-center">
              
                <img src="{{ asset('assets_frontend/assets/images/icon/wa.png') }}"
                    width="20"
                    height="20"
                    alt="WhatsApp">

                <span>Whatsapp</span>
            </a>
        </div>


        {{-- 👤 User --}}
        <div class="col-3">

          @if($customer)
            {{-- SUDAH LOGIN --}}
            <a href="{{ route('frontend.profile') }}"
              class="footer-mobile__link d-flex flex-column align-items-center">

              <img src="{{ asset('assets_frontend/assets/images/icon/user.png') }}"
                  class="footer-mobile-user-avatar"
                  alt="User">

              <span class="footer-mobile-user-name">
                {{ Str::of($customer->name)->explode(' ')->first() }}
              </span>
            </a>
          @else
            {{-- BELUM LOGIN --}}
            <a href="{{ route('frontend.login') }}"
              class="footer-mobile__link d-flex flex-column align-items-center">

              <svg class="d-block" width="18" height="18">
                <use href="#icon_user"></use>
              </svg>

              <span>Akun</span>
            </a>
          @endif

        </div>

        

    </footer>


{{-- <footer class="footer-mobile container w-100 px-5 d-md-none bg-body">
  <div class="row text-center">
    <div class="col-4">
      <a href="{{ url('/') }}" class="footer-mobile__link d-flex flex-column align-items-center">
        <svg class="d-block" width="18" height="18"><use href="#icon_home" /></svg>
        <span>Home</span>
      </a>
    </div>
    <div class="col-4">
      <a href="{{ url('/shop') }}" class="footer-mobile__link d-flex flex-column align-items-center">
        <img src="{{ asset('assets_frontend/assets/images/icon/clothes.png') }}" width="25" height="25" alt="Produk">
        <span>Produk</span>
      </a>
    </div>
    <div class="col-4">
      <a href="https://api.whatsapp.com/send/?phone=6287738728252&text&type=phone_number&app_absent=0" target="_blank" rel="noopener" class="footer-mobile__link d-flex flex-column align-items-center">
        <img src="{{ asset('assets_frontend/assets/images/icon/wa.png') }}" width="20" height="20" alt="WhatsApp">
        <span>Whatsapp</span>
      </a>
    </div>
  </div>
</footer> --}}
