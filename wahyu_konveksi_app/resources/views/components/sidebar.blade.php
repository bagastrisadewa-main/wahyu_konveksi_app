@php
    $role = auth()->user()->roles;
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">

        <!-- Logo Besar -->
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center justify-content-center">
        <img src="{{ isset($appSettings['store_logo']) ? asset('storage/settings/' . $appSettings['store_logo']) : asset('img/default-logo.png') }}"
             alt="Logo" style="height: 30px; margin-right: 8px;">

        <span class="sidebar-title font-weight-bold">
            {{ $appSettings['store_name'] ?? '' }}
        </span>
  
                {{-- <img src="{{ asset('img/yans_logo.png') }}" alt="Logo" style="height: 30px; margin-right: 8px;">
                <span class="sidebar-title font-weight-bold">Yans POS</span> --}}
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

            {{-- ✅ Tambahan Menu Home dengan Submenu --}}
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-home"></i><span>Home</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link" href="{{ route('navigation-menus.index') }}">
                            <i class="fas fa-bars"></i> Navigation Menu
                        </a>
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
                    </li>
                    {{-- nanti bisa ditambah submenu lain di sini --}}
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
                        {{-- nanti --}}
                        {{-- 
                        <li>
                            <a class="nav-link" href="#">
                                <i class="fas fa-shopping-bag"></i> Customer Orders
                            </a>
                        </li>
                        --}}
                    </ul>
                </li>

                    {{-- ✅ Menu Gallery baru --}}
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
