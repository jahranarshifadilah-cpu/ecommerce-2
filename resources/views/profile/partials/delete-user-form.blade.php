{{-- resources/views/profile/partials/delete-user-form.blade.php --}}
<div class="profile-header mb-4">
    <h5 class="fw-bold text-danger mb-1">Hapus Akun</h5>
    <p class="text-muted small">Tindakan ini permanen. Setelah akun dihapus, semua data pesanan, alamat, dan informasi lainnya akan dihapus dari server kami secara permanen.</p>
</div>

<div class="p-4 bg-danger-subtle rounded-4 border border-danger-subtle mt-3">
    <p class="small text-danger-emphasis fw-medium mb-3">
        <i class="bi bi-exclamation-octagon-fill me-2"></i> Begitu Anda menghapus akun, tidak ada jalan kembali. Mohon pastikan kembali keputusan Anda.
    </p>
    <button type="button" class="btn btn-danger px-4 fw-bold rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Hapus Akun Permanen
    </button>
</div>

<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('delete')

            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-navy" id="modalLabel">Konfirmasi Penghapusan Akun</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body px-4 pb-4">
                <div class="text-center mb-4">
                    <div class="display-4 text-danger opacity-25 mb-3">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <p class="text-muted small">
                        Demi keamanan, silakan masukkan password Anda untuk mengonfirmasi bahwa Anda adalah pemilik sah akun ini.
                    </p>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold text-slate-700 small">KONFIRMASI PASSWORD</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-muted"></i></span>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control bg-light border-0 @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="Masukkan password Anda"
                               required
                               style="border-radius: 0 10px 10px 0;">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 bg-light p-3 gap-2 justify-content-center" style="border-radius: 0 0 1rem 1rem;">
                <button type="button" class="btn btn-white border px-4 fw-bold text-muted rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger px-4 fw-bold rounded-3 shadow-sm">Ya, Hapus Akun Saya</button>
            </div>
        </form>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
            myModal.show();
        });
    </script>
@endif

<style>
    .bg-danger-subtle { background-color: #fef2f2 !important; }
    .text-danger-emphasis { color: #991b1b !important; }
    .border-danger-subtle { border-color: #fecaca !important; }
    .btn-white { background: white; border-color: #e2e8f0; }
    .btn-white:hover { background: #f8fafc; color: #64748b; }
    
    .modal-content {
        overflow: hidden;
    }

    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        border-color: #dc3545 !important;
    }
</style>