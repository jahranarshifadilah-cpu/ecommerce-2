@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-5">
            {{-- Logo atau Nama Brand (Opsional) --}}
            <div class="text-center mb-4">
                <h1 class="fw-bold text-navy" style="letter-spacing: -1px;">
                    <i class="bi bi-bag-check-fill me-2"></i>Vonduct web Store
                </h1>
                <p class="text-muted">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
            </div>

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    {{-- Form Login Utama --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-slate-700 small">ALAMAT EMAIL</label>
                            <input id="email" type="email" 
                                class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autofocus
                                placeholder="nama@email.com" style="font-size: 1rem; border-radius: 12px;">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-semibold text-slate-700 small">PASSWORD</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-medium text-primary" href="{{ route('password.request') }}">
                                        Lupa?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" 
                                class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" 
                                name="password" required 
                                placeholder="••••••••" style="font-size: 1rem; border-radius: 12px;">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted small" for="remember">
                                Tetap masuk selama 30 hari
                            </label>
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-navy btn-lg fw-bold py-3 shadow-sm rounded-3">
                                Masuk Sekarang
                            </button>
                        </div>

                        {{-- Divider --}}
                        <div class="position-relative mb-4">
                            <hr class="text-slate-200">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau masuk dengan</span>
                        </div>

                        {{-- Google Login Button --}}
                        <div class="d-grid mb-4">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-light btn-lg border border-slate-200 text-slate-700 py-3 rounded-3 d-flex align-items-center justify-content-center fw-medium">
                                <svg class="me-3" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                                Lanjutkan dengan Google
                            </a>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="mb-0 text-muted small">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-navy fw-bold text-decoration-none">Daftar Gratis</a>
                        </p>
                    </div>
                </div>
            </div>
            
            {{-- Footer Bawah --}}
            <div class="mt-4 text-center">
                <p class="text-muted small">&copy; {{ date('Y') }} Vonduct web store. Seluruh hak cipta dilindungi.</p>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    .text-navy { color: #0f172a; }
    .btn-navy { background-color: #0f172a; color: white; border: none; }
    .btn-navy:hover { background-color: #1e293b; color: white; }
    .text-slate-700 { color: #334155; }
    .text-slate-200 { color: #e2e8f0; }
    .min-vh-75 { min-height: 75vh; }
    
    /* Soft Focus Effect */
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.1);
        border-color: #0f172a !important;
    }

    .btn-outline-light:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1 !important;
    }
</style>
@endsection