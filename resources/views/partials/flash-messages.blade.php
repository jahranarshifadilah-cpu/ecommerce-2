{{-- resources/views/partials/flash-messages.blade.php --}}

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    
    {{-- Success Message --}}
    @if(session('success'))
        <div class="toast show align-items-center text-white bg-success border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="toast show align-items-center text-white bg-danger border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body d-flex align-items-center">
                    <i class="bi bi-exclamation-octagon-fill fs-5 me-2"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Info Message --}}
    @if(session('info'))
        <div class="toast show align-items-center text-white bg-navy border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex p-2">
                <div class="toast-body d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-5 me-2"></i>
                    <div>{{ session('info') }}</div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="toast show align-items-center text-white bg-danger border-0 shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex p-2">
                <div class="toast-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                        <strong class="me-auto">Terjadi Kesalahan</strong>
                    </div>
                    <ul class="mb-0 small ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 mt-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

<style>
    .bg-navy { background-color: #0f172a !important; }
    
    .toast {
        border-radius: 12px;
        backdrop-filter: blur(10px);
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    /* Agar list error tidak ada bullet point jika hanya satu */
    .toast ul { list-style-type: none; padding-left: 0; }
    .toast ul li::before { content: "•"; color: white; display: inline-block; width: 1em; margin-left: -1em; }
</style>

<script>
    // Auto hide toast setelah 5 detik (kecuali error validasi)
    document.addEventListener('DOMContentLoaded', function () {
        const toasts = document.querySelectorAll('.toast:not([data-bs-autohide="false"])');
        toasts.forEach(el => {
            setTimeout(() => {
                const toast = bootstrap.Toast.getOrCreateInstance(el);
                toast.hide();
            }, 5000);
        });
    });
</script>