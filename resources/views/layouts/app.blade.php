{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Toko Online') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Toko online terpercaya dengan produk berkualitas')">

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    {{-- Fonts: Plus Jakarta Sans untuk tampilan modern --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    {{-- Vite CSS & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --navy-dark: #0f172a;
            --slate-light: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--slate-light);
            color: var(--navy-dark);
            overflow-x: hidden;
        }

        .min-vh-100 { min-height: 100vh !important; }

        /* Smooth scroll untuk link internal */
        html { scroll-behavior: smooth; }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Toast Notification Styling */
        .toast-container { z-index: 1060; }
    </style>
    @stack('styles')
</head>
<body>
    
    {{-- Top Loading Bar (Hanya muncul saat transisi page jika memakai Turbo/Livewire) --}}
    <div id="loading-bar" style="position:fixed; top:0; left:0; height:3px; background:#0f172a; width:0; z-index:9999; transition: width 0.3s ease;"></div>

    {{-- NAVBAR --}}
    @include('partials.navbar')

    {{-- MAIN CONTENT --}}
    <main class="min-vh-100 mt-2">
        {{-- Flash Messages Container --}}
        <div class="container mt-3">
            @include('partials.flash-messages')
        </div>
        
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('partials.footer')

    {{-- Toast Container untuk Notifikasi AJAX --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast align-items-center border-0 shadow-lg rounded-3" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toast-message">
                    {{-- Pesan otomatis muncul di sini --}}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{-- JS Global --}}
    @stack('scripts')

    <script>
        /**
         * Fungsi Notifikasi Toast Sederhana
         */
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('liveToast');
            const toastMsg = document.getElementById('toast-message');
            
            // Set warna berdasarkan tipe
            toastEl.className = `toast align-items-center text-white border-0 shadow-lg rounded-3 ${type === 'success' ? 'bg-dark' : 'bg-danger'}`;
            toastMsg.innerText = message;
            
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        /**
         * AJAX Wishlist Toggle
         */
        async function toggleWishlist(productId) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;
                const response = await fetch(`/wishlist/toggle/${productId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json"
                    },
                });

                if (response.status === 401) {
                    window.location.href = "/login";
                    return;
                }

                const data = await response.json();

                if (data.status === "success") {
                    updateWishlistUI(productId, data.added);
                    updateWishlistCounter(data.count);
                    showToast(data.message);
                }
            } catch (error) {
                console.error("Error:", error);
                showToast("Terjadi kesalahan sistem.", "error");
            }
        }

        function updateWishlistUI(productId, isAdded) {
            const buttons = document.querySelectorAll(`.wishlist-btn-${productId}`);
            buttons.forEach((btn) => {
                const icon = btn.querySelector("i");
                if (isAdded) {
                    icon.className = "bi bi-heart-fill text-danger";
                    if(btn.innerText.trim() !== "") btn.innerHTML = '<i class="bi bi-heart-fill text-danger me-2"></i> Hapus dari Wishlist';
                } else {
                    icon.className = "bi bi-heart text-secondary";
                    if(btn.innerText.trim() !== "") btn.innerHTML = '<i class="bi bi-heart me-2"></i> Tambah ke Wishlist';
                }
            });
        }

        function updateWishlistCounter(count) {
            const badge = document.getElementById("wishlist-count");
            if (badge) {
                badge.innerText = count;
                badge.classList.toggle('d-none', count === 0);
            }
        }
    </script>
</body>
</html>