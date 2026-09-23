<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', $appSettings['store_name'] ?? 'Wahyu Konveksi')</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('assets_frontend/assets/images/favicon.ico') }}" type="image/x-icon">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&family=Allura&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets_frontend/assets/css/plugins/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/assets/css/custom.css') }}">

     {{-- GLightbox CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

</head>
<body>

        {{-- Include sprite --}}
    @include('frontend.partials.sprite')


    {{-- Header (desktop & mobile) --}}
    @include('frontend.layouts.header')

    {{-- Konten --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    {{-- JS --}}
    <script src="{{ asset('assets_frontend/assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/assets/js/plugins/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/assets/js/plugins/bootstrap-slider.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/assets/js/plugins/swiper.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/assets/js/plugins/countdown.js') }}"></script>
    <script src="{{ asset('assets_frontend/assets/js/theme.js') }}"></script>

        {{-- GLightbox JS --}}
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        });
    </script>

    <script>

      document.addEventListener("DOMContentLoaded", function() {
        const activator = document.querySelector(".mobile-nav-activator");
        const mobileNav = document.querySelector(".header-mobile__navigation");

        if (activator && mobileNav) {
          activator.addEventListener("click", function(e) {
            e.preventDefault();
            mobileNav.classList.toggle("open");
          });
        }
      });
      </script>

      
    <script>

                /**
             * Update badge header desktop & mobile
             */
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

            // Hitung ulang saat halaman pertama kali dibuka
            // document.addEventListener('DOMContentLoaded', function () {
            //     recalcCart();
            // });
            </script>


          <!-- Tombol Scroll to Top -->
          <button id="scrollToTopBtn">
              <img src="{{ asset('assets_frontend/assets/images/icon/up.png') }}" alt="Up">
          </button>

          <style>
          #scrollToTopBtn {
              position: fixed;
              bottom: 20px;
              right: 20px; /* pindah ke kanan */
              width: 50px;
              height: 50px;
              border-radius: 50%;
              background: #fff;
              box-shadow: 0 4px 8px rgba(0,0,0,0.2);
              border: none;
              cursor: pointer;
              display: flex;               /* biar icon di tengah */
              align-items: center;         /* vertikal tengah */
              justify-content: center;     /* horizontal tengah */
              opacity: 0;                  /* awalnya transparan */
              visibility: hidden;          /* awalnya hidden */
              transition: opacity 0.3s ease, visibility 0.3s ease; /* animasi smooth */
              z-index: 9999;
          }

          #scrollToTopBtn.show {
              opacity: 1;
              visibility: visible;
          }

          #scrollToTopBtn img {
              width: 24px;
              height: 24px;
          }
          </style>

          <script>
              const scrollBtn = document.getElementById("scrollToTopBtn");

              window.addEventListener("scroll", () => {
                  if (window.scrollY > 200) {
                      scrollBtn.classList.add("show");
                  } else {
                      scrollBtn.classList.remove("show");
                  }
              });

              scrollBtn.addEventListener("click", () => {
                  window.scrollTo({ top: 0, behavior: "smooth" });
              });
          </script>


            {{-- Toastify --}}
            <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

            @if(session('success'))
            <script>
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#28a745",
                    close: true,
                }).showToast();
            </script>
            @endif

            @if($errors->any())
            <script>
                Toastify({
                    text: "{{ $errors->first() }}",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#dc3545",
                    close: true,
                }).showToast();
            </script>
            @endif


            {{-- ================= DEBUG CUSTOMER AUTH ================= --}}
                {{-- <div style="
                    position: fixed;
                    bottom: 80px;
                    right: 20px;
                    background: #111;
                    color: #fff;
                    padding: 8px 12px;
                    font-size: 12px;
                    border-radius: 6px;
                    z-index: 999999;
                ">
                    AUTH CUSTOMER :
                    <strong>
                        {{ auth('customer')->check() ? 'LOGIN' : 'GUEST' }}
                    </strong>
                </div> --}}
                {{-- ======================================================= --}}




                    {{-- Floating WhatsApp --}}
                    @php
                        $waNumber = $appSettings['store_phone'] ?? '6287738728252';
                        $storeName = $appSettings['store_name'] ?? 'Toko Kami';
                        $waMessage = urlencode("Halo {$storeName}, saya ingin bertanya tentang jasa konveksi. Terima kasih.");
                    @endphp

                    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text={{ $waMessage }}"
                    class="floating-wa"
                    target="_blank"
                    rel="noopener">
                        
                        <img src="{{ asset('assets_frontend/assets/images/icon/social.png') }}"
                            alt="WhatsApp {{ $storeName }}">

                        <span class="wa-text">Chat WhatsApp</span>
                    </a>


        <style>
                .floating-wa {
                    position: fixed;
                    bottom: 90px;
                    right: 20px;
                    z-index: 9999;

                    display: inline-flex;
                    align-items: center;

                    background: #25D366;
                    padding: 6px;
                    border-radius: 50%;

                    box-shadow: 0 4px 10px rgba(0,0,0,0.25);

                    transition:
                        background 0.3s ease,
                        box-shadow 0.3s ease,
                        border-radius 0.35s ease;
                }

                /* ICON */
                .floating-wa img {
                    width: 44px;
                    height: 44px;
                    flex-shrink: 0;

                    transition: transform 0.4s ease;
                }

                /* TEKS — DISEMBUNYIKAN DENGAN ANIMASI */
                .floating-wa .wa-text {
                    max-width: 0;
                    overflow: hidden;
                    white-space: nowrap;

                    margin-left: 0;

                    color: #fff;
                    font-size: 14px;
                    font-weight: 500;

                    opacity: 0;
                    transform: translateX(-8px);

                    transition:
                        max-width 0.45s ease,
                        opacity 0.3s ease,
                        transform 0.35s ease,
                        margin 0.35s ease;
                }

                /* HOVER */
                .floating-wa:hover {
                    background: #1ebe5d;
                    border-radius: 50px;
                    box-shadow: 0 8px 8px rgba(0,0,0,0.35);
                }

                .floating-wa:hover img {
                    transform: scale(1.08);
                }

                .floating-wa:hover .wa-text {
                    max-width: 160px;
                    margin-left: 8px;
                    opacity: 1;
                    transform: translateX(0);
                }


        </style>


</body>
</html>
