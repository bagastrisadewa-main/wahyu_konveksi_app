{{-- Header Mobile --}}
<div class="header-mobile header_sticky d-lg-none">
  <div class="container d-flex align-items-center justify-content-between h-100">
    
{{-- Hamburger --}}
<a class="mobile-nav-activator d-block position-relative" href="javascript:void(0)">
  <div class="hamburger" id="hamburgerMenu">
    <span></span>
    <span></span>
    <span></span>
  </div>
</a>

    {{-- Logo (center) --}}
    <div class="logo mx-auto">
      <a href="{{ url('/') }}">
        <img src="{{ asset('storage/settings/' . ($appSettings['store_logo'] ?? 'default.png')) }}"
             alt="{{ $appSettings['store_name'] ?? 'Logo' }}"
             class="logo__image d-block mx-auto"/>
      </a>
    </div>

    {{-- Search (right) --}}
    <a href="javascript:void(0)" class="header-tools__item js-search-toggle-mobile">
      <svg class="d-block" width="20" height="20">
        <use href="#icon_search"></use>
      </svg>
    </a>

          {{-- Cart Icon Mobile --}}
      <div class="header-tools__item position-relative">
          <a href="{{ route('frontend.cart.index') }}" class="d-inline-flex align-items-center justify-content-center">
              <svg class="d-block" width="20" height="20">
                  <use href="#icon_cart"></use>
              </svg>

              @auth('customer')
                  @php
                      $cartCount = auth('customer')->user()->cartItems()->count();
                  @endphp
              @else
                  @php $cartCount = 0; @endphp
              @endauth

          <span id="cart-count-badge-mobile"
                class="cart-count-badge cart-badge position-absolute top-0 start-100 translate-middle"
                style="{{ $cartCount > 0 ? '' : 'display:none' }}">
              {{ $cartCount }}
          </span>


          
          </a>
      </div>


  </div>

  {{-- Search Box Mobile (muncul di bawah logo saat aktif) --}}
  <div class="search-popup-mobile d-none" id="searchPopupMobile">
    <div class="container">
      <div class="search-box position-relative">
        <input type="text" id="search-input-mobile" class="search-field__input" placeholder="Cari Produk,Kategori Produk,Artikel..." autocomplete="off"/>
        <button type="button" class="btn-icon search-popup__submit">
          <svg width="20" height="20"><use href="#icon_search"/></svg>
        </button>
        <ul id="search-results-mobile"></ul>
      </div>
    </div>
  </div>

  {{-- Mobile Navigation --}}
 <nav class="header-mobile__navigation navigation d-flex flex-column w-100 position-absolute top-100 overflow-auto d-none">
    <div class="container">
      <ul class="navigation__list list-unstyled position-relative">
        @foreach($navigationMenus as $menu)
          <li class="navigation__item">
            <a href="{{ $menu->type === 'external' ? $menu->url : url($menu->url ?? '#') }}"
               class="navigation__link"
               @if($menu->open_in_new_tab) target="_blank" @endif>
              {{ $menu->title }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </nav>
</div>


{{-- Search Popup Mobile --}}
{{-- <div class="search-popup-mobile d-none d-lg-none" id="searchPopupMobile">
  <div class="container">
    <div class="search-box position-relative">
      <input type="text" id="search-input-mobile" class="search-field__input" placeholder="Cari Produk,Kategori Produk,Artikel..." autocomplete="off"/>
      <button type="button" class="btn-icon search-popup__submit">
        <svg width="20" height="20"><use href="#icon_search"/></svg>
      </button>
      <ul id="search-results-mobile"></ul>
    </div>
  </div>
</div> --}}


{{-- Header Desktop --}}
<header id="header" class="header header-fullwidth header-transparent-bg d-none d-lg-block">
  <div class="container">
    <div class="header-desk header-desk_type_1">
      
      {{-- Logo --}}
      <div class="logo">
        <a href="{{ url('/') }}">
          <img src="{{ asset('storage/settings/' . ($appSettings['store_logo'] ?? 'default.png')) }}"
               alt="{{ $appSettings['store_name'] ?? 'Logo' }}"
               class="logo__image d-block"/>
        </a>
      </div>

      {{-- Navigation --}}
      <nav class="navigation">
        <ul class="navigation__list list-unstyled d-flex">
          @foreach($navigationMenus as $menu)
            <li class="navigation__item">
              <a href="{{ $menu->type === 'external' ? $menu->url : url($menu->url ?? '#') }}"
                 class="navigation__link"
                 @if($menu->open_in_new_tab) target="_blank" @endif>
                {{ $menu->title }}
              </a>
            </li>
          @endforeach
        </ul>
      </nav>

      {{-- Tools --}}
      <div class="header-tools d-flex align-items-center">

        {{-- Search --}}
        <div class="header-tools__item hover-container">
          <a class="js-search-toggle-desktop search-field__actor" href="javascript:void(0)">
            <svg class="d-block" width="20" height="20"><use href="#icon_search"/></svg>
          </a>
        </div>

        {{-- WhatsApp --}}
        @php
            $waNumber = $appSettings['whatsapp'] ?? '6287738728252';
            $waMessage = urlencode('Halo WHS Konveksindo, saya ingin bertanya terkait layanan konveksi yang tersedia. Terima kasih.');
        @endphp

        <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $waMessage }}"
          class="header-tools__item" target="_blank" rel="noopener">
          <img src="{{ asset('assets_frontend/assets/images/icon/wa.png') }}" width="20" height="20" alt="WhatsApp">
        </a>
              {{-- 🔽 TAMBAHKAN DI SINI --}}
                <div class="header-tools__item position-relative d-none d-lg-block">

                    @auth('customer')
                        <a href="javascript:void(0)" id="customerDropdownToggle" class="header-user-icon">
                            <img src="{{ asset('assets_frontend/assets/images/icon/user.png') }}"
                                alt="User">
                        </a>

                        <div id="customerDropdown"
                            class="position-absolute bg-white shadow rounded d-none"
                            style="right:0; top:40px; min-width:160px; z-index:9999">

                            <a href="{{ route('frontend.profile') }}"
                              class="dropdown-item px-3 py-2 d-block text-dark">
                                👤 Profil Saya
                            </a>
                            <a href="{{ route('frontend.orders.history') }}"
                            {{-- <a href="" --}}
                            {{-- {{ route('frontend.orders.history') }} --}}
                              class="dropdown-item px-3 py-2 d-block text-dark">
                                📦 History Order
                            </a>
                            <form action="{{ route('frontend.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="dropdown-item px-3 py-2 text-danger w-100 text-start">
                                    🚶‍♂️ Logout
                                </button>
                            </form>
                        </div>

                    @else
                        <a href="{{ route('frontend.login') }}" class="d-block">
                            <svg width="20" height="20">
                                <use href="#icon_user"></use>
                            </svg>
                        </a>
                    @endauth

                </div>

      {{-- Cart Desktop --}}
      <div class="header-tools__item position-relative d-none d-lg-flex align-items-center justify-content-center">
          <a href="{{ route('frontend.cart.index') }}"
            class="header-tools__cart position-relative d-flex align-items-center justify-content-center">

              <svg class="d-block" width="20" height="20">
                  <use href="#icon_cart"></use>
              </svg>

              @auth('customer')
                  @php
                $cartCount = auth('customer')->user()->cartItems()->sum('qty');

                  @endphp
              @else
                  @php $cartCount = 0; @endphp
              @endauth

              

            <span id="cart-count-badge-desktop"
                  class="cart-count-badge cart-badge position-absolute top-0 start-100 translate-middle"
                  style="{{ $cartCount > 0 ? '' : 'display:none' }}">
                {{ $cartCount }}
            </span>


          </a>
      </div>



              {{-- 🔼 END --}}

      </div>
    </div>
  </div>

  {{-- Search Box Desktop --}}
  <div class="search-popup d-none" id="searchPopupDesktop">
    <div class="container">
      <div class="search-box position-relative">
        <input type="text" id="search-input-desktop" class="search-field__input" placeholder="Cari Produk,Kategori Produk,Artikel...." autocomplete="off"/>
        <button type="button" class="btn-icon search-popup__submit">
          <svg width="20" height="20"><use href="#icon_search"/></svg>
        </button>
        <ul id="search-results-desktop"></ul>
      </div>
    </div>
  </div>
</header>


{{-- CSS untuk Header + Search --}}
<style>

  .header-tools__cart {
    position: relative;
}

.cart-badge {
    position: absolute;
    bottom: -6px;
    right: -8px;
    min-width: 18px;
    height: 18px;
    font-size: 11px;
    line-height: 18px;
    background: #dc3545; /* merah */
    color: #fff;
    border-radius: 50%;
    text-align: center;
    font-weight: bold;
    padding: 0 4px;
}

  .logo__image { max-height: 70px; width: auto; }
  @media (max-width: 768px) {
    .logo__image { max-height: 35px; }
  }

  .search-popup, .search-popup-mobile {
    width: 100%;
    background: #fff;
    border-top: 1px solid #ddd;
    padding: 15px 0;
    z-index: 9999;
  }
  .search-popup .search-box,
  .search-popup-mobile .search-box {
    position: relative;
    width: 100%;
  }
  .search-field__input {
    width: 100%;
    border: 1px solid #ccc;
    padding: 10px 40px 10px 12px;
    border-radius: 4px;
  }
  .btn-icon {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
  }
  #search-results-desktop, #search-results-mobile {
    list-style: none;
    margin: 10px 0 0;
    padding: 0;
    max-height: 250px;
    overflow-y: auto;
  }
  #search-results-desktop li,
  #search-results-mobile li {
    padding: 8px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
  }
  #search-results-desktop li:hover,
  #search-results-mobile li:hover {
    background: #f0f0f0;
  }

  /* Search mobile tampil di bawah logo */
.search-popup-mobile {
  background: rgba(255, 255, 255, 0.95);
  border-top: 1px solid #ddd;
  padding: 10px 0;
}
.search-popup-mobile .search-box {
  position: relative;
  width: 100%;
}
.search-popup-mobile .search-field__input {
  width: 100%;
  border: 1px solid #ccc;
  padding: 10px 40px 10px 12px;
  border-radius: 4px;
  background: rgba(255, 255, 255, 0.9);
  color: #000;
}
.search-popup-mobile .btn-icon {
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  cursor: pointer;
}

/* Hamburger Menu */
.hamburger {
  width: 25px;
  height: 18px;
  position: relative;
  cursor: pointer;
  display: inline-block;
}
.hamburger span {
  background: #000;
  position: absolute;
  height: 3px;
  width: 100%;
  left: 0;
  transition: all 0.3s ease-in-out;
}
.hamburger span:nth-child(1) { top: 0; }
.hamburger span:nth-child(2) { top: 7px; }
.hamburger span:nth-child(3) { top: 14px; }

/* Active (jadi X) */
.hamburger.active span:nth-child(1) {
  transform: rotate(45deg);
  top: 7px;
}
.hamburger.active span:nth-child(2) {
  opacity: 0;
}
.hamburger.active span:nth-child(3) {
  transform: rotate(-45deg);
  top: 7px;
}

/* Mobile nav background transparan putih */
.header-mobile__navigation {
  background: rgba(255, 255, 255, 0.55) !important;
  backdrop-filter: blur(6px);
}


</style>


{{-- JS Search --}}
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Desktop
    const desktopBtn = document.querySelector(".js-search-toggle-desktop");
    const desktopPopup = document.getElementById("searchPopupDesktop");
    const desktopInput = document.getElementById("search-input-desktop");
    const desktopResults = document.getElementById("search-results-desktop");

    // Mobile
    const mobileBtn = document.querySelector(".js-search-toggle-mobile");
    const mobilePopup = document.getElementById("searchPopupMobile");
    const mobileInput = document.getElementById("search-input-mobile");
    const mobileResults = document.getElementById("search-results-mobile");

    // Hamburger Menu
    const hamburgerMenu = document.getElementById("hamburgerMenu");
    const mobileNav = document.querySelector(".header-mobile__navigation");

    function closePopup(popup, input, results) {
      popup.classList.add("d-none");
      input.value = "";
      results.innerHTML = "";
    }

    // Toggle Desktop
    desktopBtn?.addEventListener("click", function(e){
      e.preventDefault();
      desktopPopup.classList.toggle("d-none");
      if (!desktopPopup.classList.contains("d-none")) desktopInput.focus();
    });

    // Toggle Mobile
    mobileBtn?.addEventListener("click", function(e){
      e.preventDefault();
      mobilePopup.classList.toggle("d-none");

      if (!mobilePopup.classList.contains("d-none")) {
          mobileInput.focus();

          // 🔹 Re-bind live search setiap popup dibuka
          liveSearch("#search-input-mobile", "#search-results-mobile");
      }
    });

    // mobileBtn?.addEventListener("click", function(e){
    //   e.preventDefault();
    //   mobilePopup.classList.toggle("d-none");
    //   if (!mobilePopup.classList.contains("d-none")) mobileInput.focus();
    // });

    // Hamburger
    document.querySelector(".mobile-nav-activator").addEventListener("click", function(e) {
      e.preventDefault();
      hamburgerMenu.classList.toggle("active");
      mobileNav.classList.toggle("d-none");
    });

    // Klik luar → tutup
    document.addEventListener("click", function(e){
      if (!desktopPopup.contains(e.target) && !e.target.closest(".js-search-toggle-desktop")) {
        if (!desktopPopup.classList.contains("d-none")) closePopup(desktopPopup, desktopInput, desktopResults);
      }
      if (!mobilePopup.contains(e.target) && !e.target.closest(".js-search-toggle-mobile")) {
        if (!mobilePopup.classList.contains("d-none")) closePopup(mobilePopup, mobileInput, mobileResults);
      }
    });

    // Scroll → tutup
    window.addEventListener("scroll", function(){
      if (!desktopPopup.classList.contains("d-none")) closePopup(desktopPopup, desktopInput, desktopResults);
      if (!mobilePopup.classList.contains("d-none")) closePopup(mobilePopup, mobileInput, mobileResults);
    });

// =====================
// 🔎 Live Search Fixed
// =====================
function liveSearch(inputSelector, resultsSelector) {
  const input = document.querySelector(inputSelector);
  const results = document.querySelector(resultsSelector);

  if (!input || !results) return;

  // Pasang listener keyup
  input.addEventListener("keyup", function () {
    const q = this.value.trim();
    if (q.length < 2) {
      results.innerHTML = "";
      return;
    }

    fetch(`/search?q=${encodeURIComponent(q)}`)
      .then(res => res.json())
      .then(data => {
        results.innerHTML = "";
        let hasResult = false;

        // Kategori
        if (data.categories?.length) {
          hasResult = true;
          const ul = document.createElement("ul");
          ul.innerHTML = "<strong>Kategori</strong>";
          data.categories.forEach(cat => {
            const li = document.createElement("li");
            li.innerHTML = `<a href="/kategori/${cat.slug}">${cat.name}</a>`;
            ul.appendChild(li);
          });
          results.appendChild(ul);
        }

        // Produk
        if (data.products?.length) {
          hasResult = true;
          const ul = document.createElement("ul");
          ul.innerHTML = "<strong>Produk</strong>";
          data.products.forEach(prod => {
            const li = document.createElement("li");
            li.innerHTML = `<a href="/produk/${prod.slug}" target="_blank">${prod.name}</a>`;

            ul.appendChild(li);
          });
          results.appendChild(ul);
        }

        // Artikel
        if (data.articles?.length) {
          hasResult = true;
          const ul = document.createElement("ul");
          ul.innerHTML = "<strong>Artikel</strong>";
          data.articles.forEach(art => {
            const li = document.createElement("li");
            li.innerHTML = `<a href="/detail-artikel/${art.slug}">${art.title}</a>`;
            ul.appendChild(li);
          });
          results.appendChild(ul);
        }

        if (!hasResult) results.innerHTML = "<li>Tidak ada hasil</li>";
      })
      .catch(err => {
        console.error("Live search error:", err);
        results.innerHTML = "<li>Terjadi kesalahan saat mencari</li>";
      });
  });

  // Hapus hasil saat klik salah satu link tapi **tidak mempengaruhi class aktif**
results.addEventListener("click", (e) => {
    if (e.target.tagName === "A") {
        e.preventDefault(); // cegah reload default
        const url = e.target.getAttribute('href');

        // Reset search popup
        results.innerHTML = "";
        input.value = "";

        // Redirect ke produk
        window.location.href = url;
    }
});
}

// Inisialisasi live search
liveSearch("#search-input-desktop", "#search-results-desktop");
liveSearch("#search-input-mobile", "#search-results-mobile");







          /* =====================
      * 👤 DROPDOWN USER
      * ===================== */
      const toggle = document.getElementById('customerDropdownToggle');
      const dropdown = document.getElementById('customerDropdown');

      if (toggle && dropdown) {
        toggle.addEventListener('click', function (e) {
          e.preventDefault();
          dropdown.classList.toggle('d-none');
        });

        document.addEventListener('click', function (e) {
          if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('d-none');
          }
        });
      }
  });

function updateCartBadge(totalQty) {
    // Desktop
    const badgeDesktop = document.getElementById('cart-count-badge-desktop');
    if (badgeDesktop) {
        if (totalQty > 0) {
            badgeDesktop.innerText = totalQty;
            badgeDesktop.style.display = 'inline-flex';
        } else {
            badgeDesktop.style.display = 'none';
        }
    }

    // Mobile
    const badgeMobile = document.getElementById('cart-count-badge-mobile');
    if (badgeMobile) {
        if (totalQty > 0) {
            badgeMobile.innerText = totalQty;
            badgeMobile.style.display = 'inline-flex';
        } else {
            badgeMobile.style.display = 'none';
        }
    }
}




</script>
