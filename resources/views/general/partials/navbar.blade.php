<!-- Navbar Start -->
<div class="container-fluid nav-bar bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white p-3 py-lg-0 px-lg-4">
        <a href="" class="navbar-brand d-flex align-items-center m-0 p-0 d-lg-none">
            <h1 class="text-primary m-0">Access Computer Shop</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto">
                <a href="{{ route('general.home') }}" class="nav-item nav-link active">Beranda</a>
                <a href="{{ route('general.service') }}" class="nav-item nav-link">Pelayanan</a>
                <a href="{{ route('general.live-chat') }}" class="nav-item nav-link">Live Chat</a>
                <a href="{{ route('general.faq') }}" class="nav-item nav-link">FAQ</a>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.home') }}" class="nav-item nav-link">Dashboard Admin</a>
                    @endif
                    @if (Auth::user()->role === 'technician')
                        <a href="{{ route('technician.home') }}" class="nav-item nav-link">Dashboard Teknisi</a>
                    @endif
                @endauth

            </div>
            <div class="mt-4 mt-lg-0 me-lg-n4 py-3 px-4 bg-primary d-flex align-items-center">
                <div class="d-flex flex-shrink-0 align-items-center justify-content-center bg-white"
                    style="width: 45px; height: 45px;">
                    <i class="fa fa-user text-primary"></i>
                </div>
                <div class="ms-3">
                    @guest
                        <div class="d-flex gap-2">
                            <a href="{{ route('general.login') }}" class="btn btn-sm btn-light text-primary fw-bold">
                                Login
                            </a>

                        </div>
                    @else
                        <p class="mb-1 text-white">Selamat datang,</p>
                        <h5 class="m-0 text-secondary">{{ Auth::user()->name }}</h5>

                        {{-- Link to profile based on role --}}
                        @php
                            $role = Auth::user()->role;
                            $profileRoute = match ($role) {
                                'admin' => route('admin.profile'),
                                'technician' => route('technician.profile'),
                                'customer' => route('customer.profile'),
                                default => '#',
                            };
                        @endphp

                        <a href="{{ $profileRoute }}" class="btn btn-sm btn-outline-light fw-bold mt-2">
                            Lihat Profil
                        </a>

                        <form action="{{ route('general.logout') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-light fw-bold">Logout</button>
                        </form>
                    @endguest

                </div>
            </div>



        </div>
    </nav>
</div>
<!-- Navbar End -->
