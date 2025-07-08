@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('conventions.index') }}">Conventions</a></li>
            <li class="breadcrumb-item active" aria-current="page">Détails</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">Convention de stage</h3>
                @php
                    $statusConfig = [
                        'pending' => [
                            'text' => 'En attente de validation',
                            'type' => 'warning'
                        ],
                        'validated' => [
                            'text' => 'Validée',
                            'type' => 'success'
                        ],
                        'rejected' => [
                            'text' => 'Rejetée',
                            'type' => 'danger'
                        ],
                        'pending_teacher' => [
                            'text' => 'En attente enseignant',
                            'type' => 'warning'
                        ],
                        'pending_company' => [
                            'text' => 'En attente entreprise',
                            'type' => 'warning'
                        ],
                        'draft' => [
                            'text' => 'Brouillon',
                            'type' => 'secondary'
                        ]
                    ];
                    $statusInfo = $statusConfig[$convention->status] ?? ['text' => 'Inconnu', 'type' => 'secondary'];
                @endphp
                <x-status-badge 
                    status="{{ $statusInfo['type'] }}"
                    size="md"
                >
                    {{ $statusInfo['text'] }}
                </x-status-badge>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h4 class="border-bottom pb-2 mb-3">{{ $convention->application->internship->title ?? 'Titre non spécifié' }}</h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Informations du stage</h5>
                            <p class="mb-2">
                                <i class="fas fa-building me-2 text-primary"></i>
                                <strong>Entreprise :</strong> {{ $convention->application->internship->company->name ?? 'Non spécifiée' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                <strong>Étudiant :</strong> {{ $convention->application->student->user->name ?? 'Non spécifié' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <strong>Date de début :</strong> {{ $convention->application->internship->start_date ? $convention->application->internship->start_date->format('d/m/Y') : 'Non spécifiée' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-clock me-2 text-primary"></i>
                                <strong>Durée :</strong> {{ $convention->application->internship->duration }} mois
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Validation</h5>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span><i class="fas fa-user-tie me-2"></i> Enseignant</span>
                                        <x-status-badge 
                                            status="{{ $convention->teacher_validated ? 'success' : 'warning' }}"
                                            size="sm"
                                        >
                                            <i class="fas fa-{{ $convention->teacher_validated ? 'check-circle' : 'clock' }} me-1"></i>
                                            {{ $convention->teacher_validated ? 'Validé le ' . $convention->updated_at->format('d/m/Y') : 'En attente' }}
                                        </x-status-badge>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-building me-2"></i> Entreprise</span>
                                        <x-status-badge 
                                            status="{{ $convention->company_validated ? 'success' : 'warning' }}"
                                            size="sm"
                                        >
                                            <i class="fas fa-{{ $convention->company_validated ? 'check-circle' : 'clock' }} me-1"></i>
                                            {{ $convention->company_validated ? 'Validé le ' . $convention->updated_at->format('d/m/Y') : 'En attente' }}
                                        </x-status-badge>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Générée le {{ $convention->created_at->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    @if(!empty($convention->rejection_reason))
                        <div class="alert alert-danger">
                            <h5><i class="fas fa-exclamation-triangle me-2"></i>Motif du rejet :</h5>
                            <p class="mb-0">{{ $convention->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Actions</h5>
                        </div>
                        <div class="card-body">
                            @if($convention->status === 'pending')
                                @if((Auth::user()->role === 'teacher' && !$convention->teacher_validated) || 
                                    (Auth::user()->role === 'company' && !$convention->company_validated))
                                    <form method="POST" action="{{ route('conventions.validate', $convention->id) }}" class="mb-3">
                                        @csrf
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-check-circle me-2"></i> Valider la convention
                                        </button>
                                    </form>
                                @endif
                                
                                @if(in_array(Auth::user()->role, ['teacher', 'admin']) && !$convention->rejection_reason)
                                    <button type="button" class="btn btn-outline-danger w-100 mb-3" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                        <i class="fas fa-times-circle me-2"></i> Rejeter la convention
                                    </button>
                                @endif
                            @endif
                            
                            <a href="{{ route('conventions.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                            </a>
                            
                            @if($convention->status === 'validated')
                                <a href="#" class="btn btn-primary w-100 mt-3" onclick="window.print()">
                                    <i class="fas fa-print me-2"></i> Imprimer la convention
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Rejeter la convention</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('conventions.reject', $convention->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Veuillez indiquer la raison du rejet :</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success')) 
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <strong class="me-auto">Succès</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-danger text-white">
                <strong class="me-auto">Erreur</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        </div>
    </div>
@endif

@push('scripts')
<script>
    // Fermer automatiquement les toasts après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl, {autohide: true, delay: 5000});
        });
        toastList.forEach(toast => toast.show());
    });
</script>
@endpush

@endsection
