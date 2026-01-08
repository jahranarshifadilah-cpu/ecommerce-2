{{-- components/order-status-badge.blade.php --}}
@props(['status'])

@php
    // Mapping warna yang lebih modern dengan palet Slate & Vibrant
    $config = [
        'pending' => [
            'class' => 'bg-warning-subtle text-warning border-warning-subtle',
            'icon' => 'bi-clock-history',
            'label' => 'Menunggu'
        ],
        'processing' => [
            'class' => 'bg-info-subtle text-info border-info-subtle',
            'icon' => 'bi-gear-fill',
            'label' => 'Diproses'
        ],
        'completed' => [
            'class' => 'bg-success-subtle text-success border-success-subtle',
            'icon' => 'bi-check-all',
            'label' => 'Selesai'
        ],
        'cancelled' => [
            'class' => 'bg-danger-subtle text-danger border-danger-subtle',
            'icon' => 'bi-x-circle',
            'label' => 'Dibatalkan'
        ],
        'shipped' => [
            'class' => 'bg-primary-subtle text-primary border-primary-subtle',
            'icon' => 'bi-truck',
            'label' => 'Dikirim'
        ],
    ];

    $current = $config[$status] ?? [
        'class' => 'bg-secondary-subtle text-secondary border-secondary-subtle',
        'icon' => 'bi-question-circle',
        'label' => ucfirst($status)
    ];
@endphp

<span class="badge {{ $current['class'] }} d-inline-flex align-items-center px-2 py-1 rounded-pill border fw-bold shadow-xs badge-animate" 
      style="font-size: 0.72rem; letter-spacing: 0.3px;">
    <i class="bi {{ $current['icon'] }} me-1"></i>
    {{ $current['label'] }}
</span>

<style>
    /* Animasi halus untuk badge agar lebih dinamis */
    .badge-animate {
        transition: all 0.2s ease;
    }
    
    .badge-animate:hover {
        filter: brightness(0.95);
        transform: scale(1.02);
    }

    /* Khusus untuk status 'processing' kita bisa berikan efek berputar tipis pada ikon */
    .bi-gear-fill {
        display: inline-block;
    }
    .bg-info-subtle .bi-gear-fill {
        animation: spin 3s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Warna subtel tambahan jika belum didefinisikan di CSS utama */
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.12) !important; }
    .bg-info-subtle { background-color: rgba(13, 202, 240, 0.12) !important; }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.12) !important; }
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.12) !important; }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.12) !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>