<aside class="left-sidebar shadow-sm" style="background-color: #fff; border-right: 1px solid #f1f5f9;">
    <div class="scroll-sidebar">
        <div class="brand-logo d-flex align-items-center justify-content-between px-4 py-3">
            <a href="{{ route('home') }}" class="text-nowrap logo-img">
                {{-- Ganti dengan logo Anda atau teks Navy yang bold --}}
                <h4 class="fw-bold mb-0" style="color: #0f172a; letter-spacing: -1px;">
                    <i class="ti ti-shopping-cart-plus me-2"></i>ADMIN<span class="text-primary">PANEL</span>
                </h4>
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>

        <nav class="sidebar-nav px-3" data-simplebar="">
            <ul id="sidebarnav" class="mb-0">
                
                {{-- Section: Dashboard --}}
                <li class="nav-small-cap mt-4">
                    <span class="hide-menu text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Home</span>
                </li>
                
                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ request()->is('admin/dashboard*') ? 'active' : '' }}" 
                       href="{{ url('admin/dashboard') }}" aria-expanded="false">
                        <i class="ti ti-layout-dashboard fs-5"></i>
                        <span class="hide-menu fw-medium">Dashboard</span>
                    </a>
                </li>

                {{-- Section: Management --}}
                <li class="nav-small-cap mt-4">
                    <span class="hide-menu text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Manajemen Toko</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ request()->is('admin/categories*') ? 'active' : '' }}" 
                       href="{{ url('admin/categories') }}" aria-expanded="false">
                        <i class="ti ti-category fs-5"></i>
                        <span class="hide-menu fw-medium">Kategori</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ request()->is('admin/products*') ? 'active' : '' }}" 
                       href="{{ route('admin.products.index') }}" aria-expanded="false">
                        <i class="ti ti-package fs-5"></i>
                        <span class="hide-menu fw-medium">Produk</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ request()->is('admin/orders*') ? 'active' : '' }}" 
                       href="{{ url('admin/orders') }}" aria-expanded="false">
                        <i class="ti ti-shopping-cart fs-5"></i>
                        <span class="hide-menu fw-medium">Pesanan</span>
                    </a>
                </li>

                {{-- Section: Reports --}}
                <li class="nav-small-cap mt-4">
                    <span class="hide-menu text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Analitik</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link rounded-3 mb-1 {{ request()->is('admin/reports*') ? 'active' : '' }}" 
                       href="{{ route('admin.reports.sales') }}" aria-expanded="false">
                        <i class="ti ti-chart-bar fs-5"></i>
                        <span class="hide-menu fw-medium">Laporan Penjualan</span>
                    </a>
                </li>

                {{-- Section: Account --}}
                <li class="nav-small-cap mt-4">
                    <span class="hide-menu text-uppercase small fw-bold text-muted" style="letter-spacing: 1px;">Akun</span>
                </li>

                <li class="sidebar-item">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form-sidebar">
                        @csrf
                        <a class="sidebar-link rounded-3 mb-1 text-danger logout-link" 
                           href="javascript:void(0)" onclick="document.getElementById('logout-form-sidebar').submit()">
                            <i class="ti ti-logout fs-5"></i>
                            <span class="hide-menu fw-medium">Keluar</span>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
        </div>
</aside>

<style>
    /* Styling Navigasi */
    .sidebar-nav ul .sidebar-item .sidebar-link {
        color: #64748b;
        display: flex;
        align-items: center;
        padding: 10px 15px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .sidebar-nav ul .sidebar-item .sidebar-link i {
        margin-right: 12px;
        transition: all 0.3s ease;
    }

    /* Active & Hover State */
    .sidebar-nav ul .sidebar-item .sidebar-link:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    .sidebar-nav ul .sidebar-item .sidebar-link.active {
        background-color: #0f172a !important;
        color: #fff !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
    }

    .sidebar-nav ul .sidebar-item .sidebar-link.active i {
        color: #fff;
    }

    .nav-small-cap {
        padding: 10px 15px 5px;
    }

    .text-danger.sidebar-link:hover {
        background-color: #fff1f2 !important;
        color: #e11d48 !important;
    }

    /* Sidebar Logo Text */
    .brand-logo h4 span {
        color: #3b82f6; /* Aksen biru untuk kata 'PANEL' */
    }
</style>