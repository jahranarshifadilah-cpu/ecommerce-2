{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-vh-100 py-5" style="background-color: #f8fafc;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- Header Profil --}}
                <div class="d-flex align-items-center mb-4">
                    <div class="rounded-3 d-flex align-items-center justify-content-center me-3" 
                         style="width: 45px; height: 45px; background-color: #0f172a; color: #fff;">
                        <i class="bi bi-person-gear fs-4"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0" style="color: #0f172a;">Pengaturan Profil</h3>
                        <p class="text-muted small mb-0">Kelola informasi akun dan keamanan Anda</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-grid gap-4">
                    
                    {{-- 1. Avatar Information --}}
                    <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 1px;">Foto Profil</h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            @include('profile.partials.update-avatar-form')
                        </div>
                    </section>

                    {{-- 2. Profile Information --}}
                    <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 1px;">Informasi Pribadi</h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </section>

                    {{-- 3. Update Password --}}
                    <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 1px;">Keamanan Kata Sandi</h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            @include('profile.partials.update-password-form')
                        </div>
                    </section>

                    {{-- 4. Connected Accounts --}}
                    <section class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-muted mb-0" style="letter-spacing: 1px;">Akun Terhubung</h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            @include('profile.partials.connected-accounts')
                        </div>
                    </section>

                    {{-- 5. Delete Account --}}
                    <section class="card border-0 shadow-sm rounded-4 overflow-hidden border-start border-danger border-4">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold text-uppercase small text-danger mb-0" style="letter-spacing: 1px;">Zona Bahaya</h6>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <p class="text-muted small mb-3">Setelah akun Anda dihapus, semua data akan dihapus secara permanen.</p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease;
    }
    
    .rounded-4 { border-radius: 1rem !important; }

    /* Styling internal untuk file partials jika mereka menggunakan class standar bootstrap */
    .card-body input.form-control {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        border-radius: 0.5rem;
    }

    .card-body input.form-control:focus {
        background-color: #fff;
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
    }

    .card-body button[type="submit"] {
        background-color: #0f172a;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .card-body button[type="submit"]:hover {
        background-color: #1e293b;
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 0.75rem;
    }
</style>
@endsection