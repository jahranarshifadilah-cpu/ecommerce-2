<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} | Vonduct web Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc; /* Slate Light */
            color: #0f172a; /* Navy Dark */
        }
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
</head>

<body class="antialiased">
    <nav class="flex items-center justify-between px-6 py-4 bg-white shadow-sm lg:px-20">
        <div class="text-xl font-bold tracking-tighter text-navy-900">
            {{ config('app.name', 'TOKO') }}<span class="text-blue-600">KITA</span>
        </div>
        
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-sm font-semibold hover:text-blue-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold hover:text-blue-600">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-bold text-white transition rounded-full hero-gradient hover:opacity-90">
                            Daftar Sekarang
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main>
        <div class="relative overflow-hidden bg-white">
            <div class="container px-6 py-16 mx-auto lg:px-20 lg:py-24">
                <div class="flex flex-col items-center lg:flex-row">
                    <div class="w-full lg:w-1/2">
                        <span class="inline-block px-3 py-1 mb-4 text-xs font-bold tracking-widest text-blue-600 uppercase bg-blue-50 rounded-full">
                            Koleksi Terbaru vonduct 2026
                        </span>
                        <h1 class="mb-6 text-5xl font-extrabold leading-tight lg:text-6xl text-slate-900">
                            Belanja Produk <br> <span class="text-transparent bg-clip-text hero-gradient">Kualitas Premium</span>
                        </h1>
                        <p class="mb-8 text-lg text-slate-600 lg:max-w-md">
                            Temukan berbagai pilihan produk terbaik dengan harga kompetitif dan pengiriman cepat ke seluruh Indonesia.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="#produk" class="px-8 py-4 font-bold text-white transition shadow-lg hero-gradient rounded-2xl hover:scale-105">
                                Mulai Belanja
                            </a>
                            <a href="#" class="px-8 py-4 font-bold transition border rounded-2xl border-slate-200 text-slate-700 hover:bg-slate-50">
                                Pelajari Fitur
                            </a>
                        </div>
                    </div>
                    
                    <div class="relative w-full mt-12 lg:w-1/2 lg:mt-0">
                        <div class="relative p-4 rounded-3xl bg-slate-100 aspect-square lg:aspect-video flex items-center justify-center border-4 border-white shadow-2xl">
                             <i class="bi bi-bag-check text-slate-300" style="font-size: 8rem;"></i>
                             <div class="absolute p-4 bg-white shadow-xl -bottom-6 -left-6 rounded-2xl animate-bounce">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-full">
                                        <i class="bi bi-star-fill text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold">Terpercaya</p>
                                        <p class="text-[10px] text-slate-500">10k+ Ulasan Positif</p>
                                    </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12 bg-slate-50 border-y border-slate-100">
            <div class="container px-6 mx-auto lg:px-20">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="flex items-center gap-4">
                        <i class="text-3xl bi bi-truck text-blue-600"></i>
                        <div>
                            <h4 class="font-bold">Gratis Ongkir</h4>
                            <p class="text-sm text-slate-500">Min. belanja Rp 500rb</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <i class="text-3xl bi bi-shield-check text-blue-600"></i>
                        <div>
                            <h4 class="font-bold">Pembayaran Aman</h4>
                            <p class="text-sm text-slate-500">Enkripsi SSL 256-bit</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <i class="text-3xl bi bi-arrow-repeat text-blue-600"></i>
                        <div>
                            <h4 class="font-bold">Garansi Retur</h4>
                            <p class="text-sm text-slate-500">Kembalikan dalam 7 hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-8 text-center bg-white">
        <p class="text-sm text-slate-400">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Dibuat dengan Laravel & Tailwind CSS.
        </p>
    </footer>
</body>
</html>