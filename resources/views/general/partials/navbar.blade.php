<!-- Navbar Start -->
<style>
    .user-box {
        background-color: #0d6efd;
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-icon {
        width: 36px;
        height: 36px;
        background-color: #fff;
        color: #0d6efd;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        font-size: 1rem;
    }

    .user-info .btn {
        font-size: 0.75rem;
        padding: 0.2rem 0.5rem;
    }

    .user-info .fw-bold {
        font-size: 0.85rem;
    }

    .navbar-brand h1 {
        font-size: 1rem;
        margin: 0;
    }

    @media (max-width: 991.98px) {
        .user-box {
            margin-top: 0.5rem;
        }
    }
</style>

<div class="container-fluid nav-bar bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 px-lg-4 py-2">
        <!-- Mobile Brand -->
        <a href="#" class="navbar-brand d-lg-none">
            <h1 class="text-primary m-0">Access Computer Shop</h1>
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <!-- Left Menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a href="{{ route('general.home') }}" class="nav-link active">Beranda</a></li>
                <li class="nav-item"><a href="{{ route('general.service') }}" class="nav-link">Pelayanan</a></li>
                <li class="nav-item"><a href="{{ route('general.live-chat') }}" class="nav-link">Live Chat</a></li>
                <li class="nav-item"><a href="{{ route('general.faq') }}" class="nav-link">FAQ</a></li>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <li class="nav-item"><a href="{{ route('admin.home') }}" class="nav-link">Dashboard Admin</a></li>
                    @endif
                    @if (Auth::user()->role === 'technician')
                        <li class="nav-item"><a href="{{ route('technician.home') }}" class="nav-link">Dashboard Teknisi</a></li>
                    @endif
                @endauth
            </ul>

            <!-- Right User Info / Login -->
                <div class="user-box">
                    <div class="user-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="user-info text-white">
                        @guest
                            <a href="{{ route('general.login') }}" class="btn btn-sm btn-light text-primary fw-semibold" style="width: 130px">Login</a>
                            <small class="text-white d-block mt-1" style="font-size: 0.55rem; opacity: 0.8;">*hanya untuk Admin dan Teknisi</small>
                        @else
                            <div class="mb-1 small">Selamat datang,</div>
                            <div class="fw-bold text-white">{{ Auth::user()->name }}</div>

                            @php
                                $role = Auth::user()->role;
                                $profileRoute = match ($role) {
                                    'admin' => route('admin.profile'),
                                    'technician' => route('technician.profile'),                                    
                                    default => '#',
                                };
                            @endphp

                            <a href="{{ $profileRoute }}" class="btn btn-sm btn-outline-light mt-1">Lihat Profil</a>
                            <form action="{{ route('general.logout') }}" method="POST" class="d-inline mt-1">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                            </form>
                        @endguest
                    </div>
                </div>

    </nav>
</div>
<!-- Navbar End -->
