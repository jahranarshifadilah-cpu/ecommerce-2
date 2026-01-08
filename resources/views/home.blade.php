{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Elegant dengan Palet Navy & Slate (Berwarna tapi Berkelas)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section: Deep Navy Background --}}
    <section class="py-5" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: #f8fafc;">
        <div class="container py-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="badge mb-3 px-3 py-2" style="background-color: #38bdf8; color: #0f172a; font-weight: 600;">NEW COLLECTION 2026</span>
                    <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">
                        Belanja Cerdas dengan <span style="color: #38bdf8;">Kualitas Terbaik.</span>
                    </h1>
                    <p class="lead mb-4" style="color: #cbd5e1; font-weight: 300;">
                        Dapatkan produk pilihan dengan standar kualitas tinggi dan pengiriman tercepat ke seluruh Indonesia.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg px-4" style="background-color: #38bdf8; border: none; color: #0f172a; font-weight: 600;">
                            Mulai Belanja
                        </a>
                        <a href="#terbaru" class="btn btn-outline-light btn-lg px-4">
                            Lihat Promo
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/images/A new chapter unfolds in the heart of Jakarta.Welcome to the new Von Dutch experience.🕙 Operati.jpg') }}" 
                         alt="Shopping" class="img-fluid" style="max-height: 380px; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.3));">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori: Clean Blue Tones --}}
    <section class="py-5 bg-white">
        <div class="container">
            <h3 class="fw-bold mb-4" style="color: #1e293b;">Telusuri Kategori</h3>
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none group">
                            <div class="card border-0 shadow-sm text-center py-4 h-100 category-card" style="background-color: #f1f5f9; border-radius: 15px; transition: 0.3s;">
                                <div class="card-body">
                                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                         class="rounded-circle mb-3 shadow-sm" width="70" height="70" style="object-fit: cover; border: 3px solid white;">
                                    <h6 class="text-dark fw-bold mb-1">{{ $category->name }}</h6>
                                    <p class="text-primary small mb-0" style="font-weight: 500;">{{ $category->products_count }} Produk</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Produk Unggulan: Light Slate Background --}}
    <section class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0" style="color: #1e293b;">Produk</h3>
                <a href="{{ route('catalog.index') }}" class="btn btn-sm px-3 fw-bold" style="color: #0284c7; background: #e0f2fe; border-radius: 20px;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm h-100 p-card">
                             @include('partials.product-card', ['product' => $product])
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner: Vibrant but Deep Colors --}}
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 text-white shadow-lg overflow-hidden" style="background: #0369a1; border-radius: 20px;">
                        <div class="card-body p-5">
                            <h3 class="fw-bold">Flash Sale Akhir Pekan</h3>
                            <p style="color: #bae6fd;">Diskon hingga 50% untuk kategori Elektronik & Fashion.</p>
                            <a href="#" class="btn btn-light fw-bold text-primary mt-2">Klaim Promo</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 text-white shadow-lg overflow-hidden" style="background: #475569; border-radius: 20px;">
                        <div class="card-body p-5">
                            <h3 class="fw-bold">Privilege Member</h3>
                            <p style="color: #cbd5e1;">Gratis ongkir tanpa minimum belanja untuk member baru.</p>
                            <a href="{{ route('register') }}" class="btn btn-outline-light fw-bold mt-2">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Efek Hover yang halus, tidak alay */
        .category-card:hover {
            background-color: #e2e8f0 !important;
            transform: translateY(-5px);
        }
        .p-card {
            transition: transform 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }
        .p-card:hover {
            transform: translateY(-8px);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }
        h1, h2, h3, h4 {
            letter-spacing: -0.5px;
        }
    </style>
@endsection