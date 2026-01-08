{{-- ================================================
     FILE: resources/views/partials/navbar.blade.php
     FUNGSI: Navigation bar dengan gaya Modern & Elegant
     ================================================ --}}

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top py-3">
    <div class="container">
        {{-- Logo & Brand: Menggunakan warna Navy yang solid --}}
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('home') }}" style="color: #0f172a; letter-spacing: -0.5px;">
            <div class="bg-dark text-white rounded-3 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="bi bi-bag-heart-fill" style="font-size: 1.1rem;"></i>
            </div>
            <span>Vonduct web Store<span style="color: #38bdf8;">.</span></span>
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler border-0" type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navbar Content --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            {{-- Search Form: Dibuat lebih subtle (lembut) --}}
            <form class="d-flex mx-auto mt-3 mt-lg-0" style="max-width: 450px; width: 100%;" 
                  action="{{ route('catalog.index') }}" method="GET">
                <div class="input-group border rounded-3 overflow-hidden" style="background: #f8fafc;">
                    <span class="input-group-text border-0 bg-transparent text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="q" 
                           class="form-control border-0 bg-transparent ps-0" 
                           placeholder="Cari koleksi terbaik..." 
                           style="box-shadow: none; font-size: 0.9rem;"
                           value="{{ request('q') }}">
                </div>
            </form>

            {{-- Right Menu --}}
            <ul class="navbar-nav ms-auto align-items-center pt-2 pt-lg-0">
                {{-- Katalog --}}
                <li class="nav-item">
                    <a class="nav-link fw-medium px-3" href="{{ route('catalog.index') }}" style="color: #475569;">
                        Katalog
                    </a>
                </li>

                @auth
                    {{-- Wishlist --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 position-relative" href="{{ route('wishlist.index') }}" style="color: #475569;">
                            <i class="bi bi-heart" style="font-size: 1.2rem;"></i>
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="position-absolute top-1 start-50 badge rounded-pill bg-danger border border-white" style="font-size: 0.55rem; padding: 0.35em 0.5em;">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Cart: Badge menggunakan warna Sky Blue --}}
                    <li class="nav-item">
                        <a class="nav-link px-3 position-relative" href="{{ route('cart.index') }}" style="color: #475569;">
                            <i class="bi bi-bag" style="font-size: 1.2rem;"></i>
                            @php
                                $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-1 start-50 badge rounded-pill border border-white" 
                                      style="font-size: 0.55rem; padding: 0.35em 0.5em; background-color: #0ea5e9;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- User Dropdown --}}
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-1 px-lg-2" 
                           href="#" id="userDropdown" 
                           data-bs-toggle="dropdown" style="border-radius: 50px; background: #f1f5f9;">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 class="rounded-circle me-lg-2" 
                                 width="28" height="28" 
                                 style="object-fit: cover;"
                                 alt="{{ auth()->user()->name }}">
                            <span class="d-none d-lg-inline fw-semibold text-dark" style="font-size: 0.85rem;">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 p-2" style="min-width: 200px; border-radius: 12px;">
                            <li><h6 class="dropdown-header text-uppercase small" style="letter-spacing: 1px;">Menu</h6></li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2 text-muted"></i> Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item rounded-2 py-2" href="{{ route('orders.index') }}">
                                    <i class="bi bi-clock-history me-2 text-muted"></i> Pesanan
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <a class="dropdown-item rounded-2 py-2 text-primary fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider opacity-50"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-2 py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    {{-- Guest Links --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium text-dark px-3" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn px-4 py-2 text-white fw-bold" href="{{ route('register') }}" 
                           style="background-color: #0f172a; border-radius: 8px; font-size: 0.9rem;">
                            Daftar
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>