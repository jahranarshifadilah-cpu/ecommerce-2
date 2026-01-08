{{-- resources/views/profile/partials/update-avatar-form.blade.php --}}
<div class="profile-header mb-4">
    <h5 class="fw-bold text-navy mb-1">Foto Profil</h5>
    <p class="text-muted small">Upload foto terbaikmu. Format JPG, PNG, atau WebP (Maks. 2MB).</p>
</div>

<form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div class="d-flex align-items-center gap-4">
        {{-- Avatar Preview Container --}}
        <div class="position-relative group">
            <div class="avatar-wrapper rounded-circle border border-3 border-light shadow-sm overflow-hidden" 
                 style="width: 110px; height: 110px; cursor: pointer;"
                 onclick="document.getElementById('avatar').click()">
                
                <img id="avatar-preview"
                     class="w-100 h-100 object-fit-cover transition-all"
                     src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('images/default-avatar.png') }}"
                     alt="{{ $user->name }}">
                
                {{-- Overlay saat hover --}}
                <div class="avatar-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 opacity-0 transition-all">
                    <i class="bi bi-camera-fill text-white fs-4"></i>
                </div>
            </div>

            {{-- Tombol Hapus (Hanya muncul jika ada avatar) --}}
            @if($user->avatar)
                <button type="button"
                        onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                        class="btn btn-danger btn-sm rounded-circle position-absolute top-0 end-0 shadow-sm d-flex align-items-center justify-content-center"
                        style="width: 28px; height: 28px; border: 2px solid white;"
                        title="Hapus foto">
                        <i class="bi bi-trash3-fill" style="font-size: 0.75rem;"></i>
                </button>
            @endif
        </div>

        {{-- Upload Input Area --}}
        <div class="flex-grow-1">
            <div class="custom-file-upload">
                <input type="file"
                       name="avatar"
                       id="avatar"
                       accept="image/*"
                       onchange="previewAvatar(event)"
                       class="form-control bg-light border-0 shadow-none @error('avatar') is-invalid @enderror"
                       style="border-radius: 10px;">
                @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text small mt-2">
                    <i class="bi bi-info-circle me-1"></i> Tip: Gunakan foto kotak (1:1) agar tidak terpotong.
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-navy px-4 py-2 fw-bold shadow-sm rounded-3">
            Simpan Foto
        </button>
    </div>
</form>

{{-- Hidden Form Delete Avatar --}}
<form id="delete-avatar-form" action="{{ route('profile.avatar.destroy') }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('avatar-preview');
        
        if (file) {
            // Validasi ukuran file (opsional di sisi klien)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.add('fade-in-quick');
            }
            reader.readAsDataURL(file);
        }
    }
</script>

<style>
    .avatar-wrapper {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .avatar-wrapper:hover img {
        transform: scale(1.1);
    }

    .fade-in-quick {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0.5; }
        to { opacity: 1; }
    }

    .btn-navy { background-color: #0f172a; color: white; border: none; }
    .btn-navy:hover { background-color: #1e293b; color: white; }
    
    /* Mempercantik input file di Chrome/Edge */
    input[type=file]::file-selector-button {
        background: #e2e8f0;
        border: none;
        border-radius: 6px;
        padding: 4px 12px;
        margin-right: 10px;
        font-weight: 600;
        font-size: 0.85rem;
        cursor: pointer;
        transition: 0.2s;
    }
    
    input[type=file]::file-selector-button:hover {
        background: #cbd5e1;
    }
</style>