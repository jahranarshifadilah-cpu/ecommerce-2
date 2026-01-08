{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<div class="profile-header mb-4">
    <h5 class="fw-bold text-navy mb-1">Informasi Pribadi</h5>
    <p class="text-muted small">Kelola informasi dasar dan alamat pengiriman Anda untuk memudahkan proses checkout.</p>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="needs-validation">
    @csrf
    @method('patch')

    <div class="row">
        {{-- Nama --}}
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label fw-semibold text-slate-700 small">NAMA LENGKAP</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control bg-light border-0 @error('name') is-invalid @enderror"
                       value="{{ old('name', $user->name) }}"
                       required autofocus autocomplete="name"
                       style="border-radius: 0 10px 10px 0;">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label fw-semibold text-slate-700 small">ALAMAT EMAIL</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-envelope text-muted"></i></span>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control bg-light border-0 @error('email') is-invalid @enderror"
                       value="{{ old('email', $user->email) }}"
                       required autocomplete="username"
                       style="border-radius: 0 10px 10px 0;">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email Verification Notice --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 p-2 bg-warning-subtle rounded-3 border border-warning-subtle">
                    <p class="text-warning-emphasis small mb-0">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Email belum diverifikasi.
                        <button form="send-verification" class="btn btn-link p-0 align-baseline text-decoration-none small fw-bold text-warning-emphasis">
                            Kirim Ulang Verifikasi
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small fw-bold mt-1 mb-0">
                            <i class="bi bi-check-circle-fill me-1"></i> Link baru telah terkirim!
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Phone --}}
        <div class="col-md-12 mb-3">
            <label for="phone" class="form-label fw-semibold text-slate-700 small">NOMOR TELEPON</label>
            <div class="input-group">
                <span class="input-group-text bg-light border-0"><i class="bi bi-phone text-muted"></i></span>
                <input type="tel"
                       name="phone"
                       id="phone"
                       class="form-control bg-light border-0 @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}"
                       placeholder="08xxxxxxxxxx"
                       style="border-radius: 0 10px 10px 0;">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-text x-small">Pastikan nomor aktif untuk konfirmasi kurir.</div>
        </div>

        {{-- Address --}}
        <div class="col-md-12 mb-4">
            <label for="address" class="form-label fw-semibold text-slate-700 small">ALAMAT PENGIRIMAN</label>
            <textarea name="address"
                      id="address"
                      rows="3"
                      class="form-control bg-light border-0 @error('address') is-invalid @enderror"
                      placeholder="Contoh: Jl. Merdeka No. 10, RT 01/RW 02, Jakarta Pusat"
                      style="border-radius: 10px;">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-navy px-4 py-2 fw-bold shadow-sm rounded-3">
            Simpan Perubahan
        </button>
        
        @if (session('status') === 'profile-updated')
            <span class="text-success small fw-medium fade-out">
                <i class="bi bi-check2-all me-1"></i> Berhasil disimpan
            </span>
        @endif
    </div>
</form>

<style>
    .text-navy { color: #0f172a; }
    .btn-navy { background-color: #0f172a; color: white; border: none; }
    .btn-navy:hover { background-color: #1e293b; color: white; }
    .bg-warning-subtle { background-color: #fffbeb !important; }
    .text-warning-emphasis { color: #92400e !important; }
    .x-small { font-size: 0.75rem; }

    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.1);
        border-color: #0f172a !important;
    }

    .input-group-text {
        border-right: 1px solid #e2e8f0 !important;
    }

    .fade-out {
        animation: fadeOut 3s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>