{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<div class="profile-header mb-4">
    <h5 class="fw-bold text-navy mb-1">Keamanan Akun</h5>
    <p class="text-muted small">Pastikan akun Anda tetap aman dengan menggunakan password yang kuat (kombinasi huruf, angka, dan simbol).</p>
</div>

<form method="post" action="{{ route('profile.password.update') }}">
    @csrf
    @method('put')

    {{-- Current Password --}}
    <div class="mb-3">
        <label for="update_password_current_password" class="form-label fw-semibold text-slate-700 small">PASSWORD SAAT INI</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-muted"></i></span>
            <input type="password"
                   name="current_password"
                   id="update_password_current_password"
                   class="form-control bg-light border-0 @error('current_password', 'updatePassword') is-invalid @enderror"
                   autocomplete="current-password"
                   style="border-radius: 0 10px 10px 0;">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- New Password --}}
    <div class="mb-3">
        <label for="update_password_password" class="form-label fw-semibold text-slate-700 small">PASSWORD BARU</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="bi bi-key text-muted"></i></span>
            <input type="password"
                   name="password"
                   id="update_password_password"
                   class="form-control bg-light border-0 @error('password', 'updatePassword') is-invalid @enderror"
                   autocomplete="new-password"
                   style="border-radius: 0 10px 10px 0;">
            <button class="btn btn-light border-0 px-3" type="button" onclick="togglePasswordVisibility('update_password_password')">
                <i class="bi bi-eye-slash text-muted" id="icon-update_password_password"></i>
            </button>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Confirm Password --}}
    <div class="mb-4">
        <label for="update_password_password_confirmation" class="form-label fw-semibold text-slate-700 small">KONFIRMASI PASSWORD BARU</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-0"><i class="bi bi-check2-circle text-muted"></i></span>
            <input type="password"
                   name="password_confirmation"
                   id="update_password_password_confirmation"
                   class="form-control bg-light border-0 @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                   autocomplete="new-password"
                   style="border-radius: 0 10px 10px 0;">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-navy px-4 py-2 fw-bold shadow-sm rounded-3">
            Perbarui Password
        </button>

        @if (session('status') === 'password-updated')
            <span class="text-success small fw-medium animate-fade-out">
                <i class="bi bi-shield-check me-1"></i> Berhasil diperbarui
            </span>
        @endif
    </div>
</form>

<script>
    function togglePasswordVisibility(fieldId) {
        const input = document.getElementById(fieldId);
        const icon = document.getElementById('icon-' + fieldId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }
</script>

<style>
    /* Menggunakan variabel warna yang sama dengan form sebelumnya */
    .animate-fade-out {
        animation: fadeOutEffect 3s forwards;
    }

    @keyframes fadeOutEffect {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }

    /* Memperhalus tampilan tombol show/hide */
    .btn-light:focus {
        box-shadow: none;
        background-color: #f1f5f9;
    }
</style>