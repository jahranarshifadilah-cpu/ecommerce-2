@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-5 text-center">
            {{-- Ilustrasi Ikon --}}
            <div class="mb-4">
                <div class="display-1 text-primary opacity-25">
                    <i class="bi bi-envelope-check"></i>
                </div>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <h2 class="fw-bold text-navy mb-3">Verifikasi Email Anda</h2>
                    
                    <p class="text-muted mb-4">
                        Hampir selesai! Kami telah mengirimkan tautan verifikasi ke alamat email Anda. 
                        Silakan periksa kotak masuk (atau folder spam) untuk melanjutkan.
                    </p>

                    @if (session('resent'))
                        <div class="alert alert-success border-0 rounded-3 shadow-sm mb-4 small" role="alert">
                            <i class="bi bi-send-check me-2"></i>
                            Tautan verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <div class="bg-light p-4 rounded-4 mb-4">
                        <p class="small text-slate-600 mb-3">
                            Tidak menerima email? Pastikan alamat email sudah benar atau klik tombol di bawah untuk mengirim ulang.
                        </p>
                        
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-navy w-100 py-2 rounded-3 fw-bold">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </form>
                    </div>

                    <a href="{{ url('/') }}" class="text-decoration-none small fw-bold text-muted">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            {{-- Support Info --}}
            <p class="mt-4 text-muted small">
                Butuh bantuan? <a href="#" class="text-navy fw-bold text-decoration-none">Hubungi Support</a>
            </p>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    .text-navy { color: #0f172a; }
    .btn-navy { background-color: #0f172a; color: white; border: none; transition: all 0.2s; }
    .btn-navy:hover { background-color: #1e293b; transform: translateY(-1px); }
    .text-slate-600 { color: #475569; }
    .min-vh-75 { min-height: 75vh; }
    
    .card {
        transition: transform 0.3s ease;
    }
</style>
@endsection