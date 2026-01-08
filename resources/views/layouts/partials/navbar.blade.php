<header class="app-header shadow-sm" style="background-color: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border-bottom: 1px solid #f1f5f9;">
    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <ul class="navbar-nav">
            {{-- Toggle Sidebar Mobile --}}
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2" style="color: #0f172a;"></i>
                </a>
            </li>
            {{-- Notifikasi --}}
            <li class="nav-item">
                <a class="nav-link nav-icon-hover position-relative" href="javascript:void(0)">
                    <i class="ti ti-bell-ringing" style="color: #0f172a;"></i>
                    <span class="notification bg-danger rounded-circle position-absolute" 
                          style="width: 8px; height: 8px; top: 12px; right: 10px; border: 2px solid #fff;"></span>
                </a>
            </li>
        </ul>

        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                {{-- Info Nama Admin (Opsional) --}}
                <li class="nav-item d-none d-md-block me-3">
                    <div class="text-end">
                        <p class="mb-0 fw-bold small" style="color: #0f172a;">{{ Auth::user()->name }}</p>
                        <p class="mb-0 text-muted small" style="font-size: 0.7rem;">Administrator</p>
                    </div>
                </li>

                {{-- User Dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->avatar_url ?? asset('assets/images/profile/user-1.jpg') }}" 
                             alt="Profile" width="38" height="38" class="rounded-circle border border-2 border-light shadow-sm">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up border-0 shadow-lg rounded-4 mt-2" aria-labelledby="drop2" style="min-width: 220px;">
                        <div class="message-body p-3">
                            <div class="px-3 py-2 mb-2 rounded-3" style="background-color: #f8fafc;">
                                <p class="mb-0 small text-muted">Login sebagai:</p>
                                <p class="mb-0 fw-bold truncate" style="color: #0f172a;">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}" class="d-flex align-items-center gap-3 dropdown-item rounded-3 py-2">
                                <i class="ti ti-user fs-5 text-primary"></i>
                                <p class="mb-0 small">Profil Saya</p>
                            </a>
                            <a href="{{ route('home') }}" class="d-flex align-items-center gap-3 dropdown-item rounded-3 py-2">
                                <i class="ti ti-world fs-5 text-success"></i>
                                <p class="mb-0 small">Lihat Toko</p>
                            </a>
                            
                            <hr class="my-2 border-light">

                            {{-- Logout Form --}}
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-dark w-100 mt-2 rounded-3 fw-bold small py-2" 
                                        style="border-color: #e2e8f0;">
                                    <i class="ti ti-power me-1"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>

<style>
    /* Styling Hover Dropdown */
    .dropdown-item:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        transform: translateX(5px);
        transition: all 0.2s ease;
    }

    .truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    /* Efek Header saat Scroll */
    .app-header {
        transition: all 0.3s ease;
        z-index: 10;
    }

    .nav-icon-hover:hover i {
        color: #3b82f6 !important; /* Biru cerah saat hover */
        transform: scale(1.1);
        transition: all 0.2s ease;
    }
</style>