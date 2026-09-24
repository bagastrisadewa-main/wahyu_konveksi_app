@php
    $role = auth()->user()->roles;
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <!-- Logo Besar -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center justify-content-center">
                <img src="{{ isset($appSettings['store_logo']) ? asset('storage/settings/' . $appSettings['store_logo']) : asset('img/default-logo.png') }}"
                     alt="{{ $appSettings['store_name'] ?? 'Logo' }}"
                     class="sidebar-brand__logo">
            </a>
        </div>

        <!-- Logo Kecil -->
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img src="{{ isset($appSettings['store_logo']) ? asset('storage/settings/' . $appSettings['store_logo']) : asset('img/default-logo.png') }}"
                     alt="Logo" style="height: 30px;">
            </a>
        </div>

        <!-- Menu Sidebar -->
        <ul class="sidebar-menu">

            {{-- Umum --}}
            <li class="menu-header">Menu WHS</li>

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>

            {{-- ✅ Menu Home dengan Submenu --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-home"></i><span>Home</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('navigation-menus.index') }}">
                            <i class="fas fa-bars"></i> Navigation Menu
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('sliders.index') }}">
                            <i class="fas fa-image"></i> Slider Images
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('about.index') }}">
                            <i class="fas fa-info-circle"></i> Tentang Kami
                        </a>
                    </li>
                </ul>
            </li>

            @if(in_array($role, ['admin', 'karyawan']))
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link">
                        <i class="fas fa-list-alt"></i><span>Categories</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('product.index') }}" class="nav-link">
                        <i class="fas fa-boxes"></i><span>Products</span>
                    </a>
                </li>

                {{-- ✅ Menu Customers --}}
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link has-dropdown">
                        <i class="fas fa-user-friends"></i><span>Customers</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('customers.index') }}">
                                <i class="fas fa-users"></i> Data Customers
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ✅ Menu Gallery --}}
                <li class="nav-item">
                    <a href="{{ route('galleries.index') }}" class="nav-link">
                        <i class="fas fa-images"></i><span>Gallery</span>
                    </a>
                </li>

                {{-- ✅ Menu Artikel --}}
                <li class="nav-item">
                    <a href="{{ route('admin.articles.index') }}" class="nav-link">
                        <i class="fas fa-newspaper"></i><span>Artikel</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <i class="fas fa-shopping-cart"></i><span>Orders</span>
                    </a>
                </li>
            @endif

            {{-- Admin only --}}
            @if($role === 'admin')
                <li class="menu-header">Menu Admin</li>

                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link">
                        <i class="fas fa-users"></i><span>Users</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('report.index') }}" class="nav-link">
                        <i class="fas fa-file-alt"></i><span>Laporan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('database.index') }}" class="nav-link">
                        <i class="fas fa-database"></i><span>Database</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link">
                        <i class="fas fa-cogs"></i><span>Pengaturan</span>
                    </a>
                </li>
            @endif

        </ul>
    </aside>
</div>

<style>
/* ===== Sidebar Brand ===== */
.sidebar-brand__logo {
    height: 34px;
    width: auto;
    max-width: 85%;
    object-fit: contain;
}

.main-sidebar .sidebar-brand {
    padding: 18px 0;
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

/* ===== Sidebar base look ===== */
.main-sidebar {
    box-shadow: 2px 0 12px rgba(0,0,0,0.08);
}

.main-sidebar .sidebar-menu {
    padding: 8px 0;
}

.main-sidebar .sidebar-menu .menu-header {
    font-size: 0.72rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    opacity: 0.55;
    padding: 18px 20px 8px;
}

/* ===== Menu item level 1 ===== */
.main-sidebar .sidebar-menu li.nav-item > a.nav-link {
    border-radius: 10px;
    margin: 3px 12px;
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    transition: background 0.2s ease, transform 0.15s ease;
    cursor: pointer;
}

.main-sidebar .sidebar-menu li.nav-item > a.nav-link i {
    width: 20px;
    text-align: center;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.main-sidebar .sidebar-menu li.nav-item > a.nav-link:hover {
    background: rgba(255,255,255,0.08);
    transform: translateX(2px);
}

.main-sidebar .sidebar-menu li.nav-item.active > a.nav-link {
    background: rgba(255,255,255,0.15);
    font-weight: 600;
}

/* ===== Dropdown chevron ===== */
.main-sidebar .sidebar-menu li.nav-item.dropdown > a.nav-link.has-dropdown {
    position: relative;
}

.main-sidebar .sidebar-menu li.nav-item.dropdown > a.nav-link.has-dropdown::after {
    content: "\f107"; /* fa-chevron-down */
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 0.75rem;
    margin-left: auto;
    transition: transform 0.25s ease;
    opacity: 0.6;
}

.main-sidebar .sidebar-menu li.nav-item.dropdown.js-open > a.nav-link.has-dropdown::after {
    transform: rotate(180deg);
}

/* ===== Dropdown submenu — collapsed by default, toggled via JS ===== */
.main-sidebar .sidebar-menu li.nav-item.dropdown > ul.dropdown-menu {
    position: static;
    display: block;
    float: none;
    width: 100%;
    background: rgba(0,0,0,0.15);
    border: none;
    box-shadow: none;
    padding: 0;
    margin: 0;

    max-height: 0;
    overflow: hidden;
    opacity: 0;
    transition: max-height 0.3s ease, opacity 0.25s ease, padding 0.3s ease;
}

.main-sidebar .sidebar-menu li.nav-item.dropdown.js-open > ul.dropdown-menu {
    max-height: 500px;
    opacity: 1;
    padding: 4px 0 6px;
}

.main-sidebar .sidebar-menu .dropdown-menu li {
    list-style: none;
}

.main-sidebar .sidebar-menu .dropdown-menu li a.nav-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 14px 9px 42px;
    margin: 2px 10px;
    border-radius: 8px;
    font-size: 0.85rem;
    opacity: 0.85;
    transition: background 0.2s ease, opacity 0.2s ease;
}

.main-sidebar .sidebar-menu .dropdown-menu li a.nav-link i {
    width: 16px;
    text-align: center;
    font-size: 0.8rem;
    flex-shrink: 0;
}

.main-sidebar .sidebar-menu .dropdown-menu li a.nav-link:hover {
    background: rgba(255,255,255,0.1);
    opacity: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle submenu sidebar (Home, Customers, dll) — manual, tidak bergantung script bawaan tema
    document.querySelectorAll('.main-sidebar .sidebar-menu li.nav-item.dropdown > a.has-dropdown')
        .forEach(function (toggle) {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const parentLi = toggle.closest('li.nav-item.dropdown');

                // Tutup dropdown lain yang sedang terbuka (accordion style)
                document.querySelectorAll('.main-sidebar .sidebar-menu li.nav-item.dropdown.js-open')
                    .forEach(function (openLi) {
                        if (openLi !== parentLi) openLi.classList.remove('js-open');
                    });

                parentLi.classList.toggle('js-open');
            });
        });
});
</script>