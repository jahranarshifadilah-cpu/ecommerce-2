<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') | {{ config('app.name') }}</title>
    
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    
    {{-- Google Fonts untuk kesan premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    {{-- CSS Framework & Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            background-color: #f8fafc;
        }

        /* Merapikan transisi sidebar */
        .page-wrapper {
            transition: all 0.3s ease;
        }

        .container-fluid {
            padding: 25px !important;
            max-width: 1400px;
        }

        /* Custom Scrollbar untuk Sidebar */
        .simplebar-track.simplebar-vertical {
            width: 7px;
        }
        .simplebar-scrollbar:before {
            background: #cbd5e1;
        }

        /* Loading Overlay (Opsional) */
        #loader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
        }
    </style>
    @stack('styles')
</head>

<body>
    {{-- Body Wrapper --}}
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        
        @include('layouts.partials.sidebar')
        <div class="body-wrapper">
            @include('layouts.partials.navbar')
            <div class="container-fluid">
                {{-- Breadcrumb Otomatis atau Judul Halaman --}}
                <div class="mb-4">
                    @yield('header')
                </div>

                {{-- Alert Flash Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                        <i class="ti ti-check me-2 fs-5"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Konten Utama --}}
                @yield('content')
            </div>
            
            {{-- Footer Admin (Opsional) --}}
            <footer class="py-4 text-center">
                <p class="mb-0 fs-2 text-muted">© {{ date('Y') }} {{ config('app.name') }}. Built with ❤️ for Business.</p>
            </footer>
        </div>
    </div>

    {{-- Core Scripts --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    
    {{-- Script Tambahan per Halaman --}}
    @stack('scripts')
</body>

</html>