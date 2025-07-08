@props([
    'status' => 'warning', // warning, success, danger, primary, secondary, info
    'rejectionReason' => null,
    'showTooltip' => true,
    'size' => 'md' // sm, md, lg
])

@php
    // Configuration des icônes et textes par défaut selon le statut
    $statusConfig = [
        'warning' => [
            'icon' => 'clock',
            'text' => 'En attente',
            'iconClass' => 'text-warning'
        ],
        'success' => [
            'icon' => 'check-circle',
            'text' => 'Accepté',
            'iconClass' => 'text-success'
        ],
        'danger' => [
            'icon' => 'times-circle',
            'text' => 'Refusé',
            'iconClass' => 'text-danger',
            'tooltip' => $rejectionReason ? 'Motif: ' . $rejectionReason : ''
        ],
        'primary' => [
            'icon' => 'check-double',
            'text' => 'Validé',
            'iconClass' => 'text-primary'
        ],
        'info' => [
            'icon' => 'info-circle',
            'text' => 'Information',
            'iconClass' => 'text-info'
        ],
        'secondary' => [
            'icon' => 'circle',
            'text' => 'Inactif',
            'iconClass' => 'text-secondary'
        ]
    ];

    $statusData = $statusConfig[$status] ?? $statusConfig['secondary'];
    
    // Classes de taille
    $sizeClasses = [
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base'
    ][$size];
    
    // Classes de couleur de fond et de bordure
    $bgClass = "bg-{$status}-bg-subtle";
    $borderClass = "border border-{$status}";
    $textClass = "text-{$status} fw-medium";
@endphp

<div class="d-inline-flex align-items-center">
    <span 
        class="badge {{ $bgClass }} {{ $borderClass }} {{ $textClass }} rounded-pill {{ $sizeClasses }} d-inline-flex align-items-center status-badge"
        @if($showTooltip && !empty($statusData['tooltip'])) 
            data-bs-toggle="tooltip" 
            data-bs-placement="top" 
            title="{{ $statusData['tooltip'] }}"
        @endif>
        <i class="fas fa-{{ $statusData['icon'] }} me-2 {{ $statusData['iconClass'] }}"></i>
        <span class="fw-medium">{{ $slot->isNotEmpty() ? $slot : $statusData['text'] }}</span>
    </span>
    
    @if($status === 'danger' && $rejectionReason && $showTooltip)
        <button 
            type="button" 
            class="btn btn-link p-0 ms-1 text-danger"
            data-bs-toggle="tooltip"
            title="Voir le motif de refus"
            onclick="alert('Motif de refus: {{ addslashes($rejectionReason) }}')">
            <i class="fas fa-info-circle"></i>
        </button>
    @endif
</div>
