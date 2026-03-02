<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>

        </div>
    </form>
 
<ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle">
        <a href="#" data-toggle="dropdown" class="nav-link nav-link-lg beep">
            <i class="fas fa-bell"></i>
            <span class="badge badge-danger badge-notif" style="display: none;">0</span>
        </a>

        {{-- Ini adalah kontainer dropdown, akan diisi oleh AJAX --}}
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-notif">
            <div class="dropdown-title">Memuat notifikasi...</div>
        </div>
    </li>
    <li class="dropdown dropdown-list-toggle" id="notif-dropdown">

</ul>





        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image"
                src="@if (auth()->user()->photo)
                        {{ asset('storage/users/' . auth()->user()->photo) }}
                    @elseif (auth()->user()->roles === 'admin')
                        {{ asset('img/avatar/avatar-1.png') }}
                    @else
                        {{ asset('img/avatar/avatar-2.png') }}
                    @endif"
                class="rounded-circle mr-1" width="30" height="30">

                {{-- <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1"> --}}
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-user"">
                <div class="dropdown-title">Logged in 5 min ago</div>
                <a href="{{ route('user.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="{{ route('user.activities') }}" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>

                {{-- <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a> --}}
                <a href="#" class="dropdown-item has-icon" onclick="toggleTheme()" id="theme-toggle">
                    <i id="theme-icon" class="fas fa-moon"></i> Ganti Thema
                </a>
                <div class="dropdown-divider"></div>
                
                    <a href="#" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

{{-- @push('scripts')
<script>

</script>
@endpush --}}