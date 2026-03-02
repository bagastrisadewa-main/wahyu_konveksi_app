<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
@php
    $storeName = \App\Models\Setting::getValue('store_name') ?? '';
    $storeLogo = \App\Models\Setting::getValue('store_logo') ?? 'default-logo.png';
@endphp

<title>@yield('title') &mdash; {{ $storeName }}</title>
<link rel="icon" type="image/png" href="{{ asset('storage/settings/' . $storeLogo) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet"href="{{ asset('css/components.css') }}">
    <link id="theme-style" rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="{{ asset('css/style-dark.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    {{-- Summernote CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css" rel="stylesheet">


<meta http-equiv="Content-Security-Policy" 
      content="frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com; child-src https://www.youtube.com https://www.youtube-nocookie.com;">


</head>


<body>
    <div id="app">
        <div class="main-wrapper">
            <!-- Header -->
            @include('components.header')

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Content -->
            @yield('main')

            <!-- Footer -->
            @include('components.footer')
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/tooltip.js/dist/umd/tooltip.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('library/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('library/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

{{-- untuk grafik chart --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

{{-- Summernote JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>



@stack('scripts')

        <!-- notifikasi refresh setiap 1 menit supaya realtime -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>



    {{-- 🌗 Script Dark Mode --}}


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const theme = localStorage.getItem("theme");
        const icon = document.getElementById("theme-icon");

        if (theme === "dark") {
            document.body.classList.add("dark-mode");
            icon?.classList.replace("fa-moon", "fa-sun");
        }
    });

    function toggleTheme() {
        const body = document.body;
        const icon = document.getElementById("theme-icon");

        body.classList.toggle("dark-mode");

        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("theme", "dark");
            icon?.classList.replace("fa-moon", "fa-sun");
        } else {
            localStorage.setItem("theme", "light");
            icon?.classList.replace("fa-sun", "fa-moon");
        }
    }
</script>





{{-- fungsi ajax untuk notifikasi  --}}
<script>
let badge = document.querySelector('.badge-notif');
let dropdown = document.querySelector('.dropdown-menu-notif');

// Fungsi load notifikasi dari server
async function loadNotifications() {
    try {
        const res = await fetch("{{ route('notifications.orders') }}");
        const data = await res.json();

        // Update badge
        if (data.count > 0) {
            badge.style.display = 'inline-block';
            badge.textContent = data.count;
        } else {
            badge.style.display = 'none';
        }

        // Jika dropdown terbuka, update kontennya
        if (dropdown.classList.contains('show') || dropdown.style.display === 'block') {
            updateDropdown(data.orders);
        }

        console.log("DEBUG: data notifikasi diterima:", data); // untuk debug
    } catch (err) {
        console.error(err);
    }
}

// Update konten dropdown
function updateDropdown(orders) {
    if (orders.length > 0) {
        let html = '';
        orders.forEach(o => {
            html += `<a href="${o.url}" class="dropdown-item" data-id="${o.id}">
                        <div class="dropdown-item-desc">
                            <b>${o.customer}</b> - <span class="text-primary">${o.order_code}</span>
                        </div>
                        <div class="dropdown-time text-muted">${o.status}</div>
                    </a>`;
        });
        dropdown.innerHTML = html;
    } else {
        dropdown.innerHTML = '<div class="dropdown-title text-center text-muted">Tidak ada notifikasi</div>';
    }
}

// Event klik icon bell
document.querySelector('.fa-bell').addEventListener('click', async () => {
    try {
        // Ambil notifikasi terbaru saat diklik
        const res = await fetch("{{ route('notifications.orders') }}");
        const data = await res.json();

        // Tampilkan dropdown
        updateDropdown(data.orders);

        // Tandai semua yang muncul sebagai sudah dibaca
        if (data.orders.length > 0) {
            const idsToMark = data.orders.map(o => o.id);
            await fetch("{{ route('notifications.markAsRead') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ ids: idsToMark })
            });
            badge.style.display = 'none';
        }
    } catch (err) {
        console.error(err);
    }
});

// Load pertama kali saat halaman dibuka
document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
