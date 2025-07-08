@extends('layouts.app')

@section('title', 'Détails de la candidature - ' . ($application->internship->title ?? 'Stage'))

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">
                {{ Auth::user()->role === 'company' ? 'Candidatures reçues' : 'Mes candidatures' }}
            </a></li>
            <li class="breadcrumb-item active" aria-current="page">Détails</li>
        </ol>
    </nav>

    <div class="card shadow-sm border-0 overflow-hidden mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">{{ $application->internship->title ?? 'Candidature de stage' }}</h3>
                @php
                    $statusConfig = [
                        'pending' => [
                            'type' => 'warning',
                            'icon' => 'clock',
                            'text' => 'En attente'
                        ],
                        'accepted' => [
                            'type' => 'success',
                            'icon' => 'check-circle',
                            'text' => 'Acceptée'
                        ],
                        'rejected' => [
                            'type' => 'danger',
                            'icon' => 'times-circle',
                            'text' => 'Refusée'
                        ]
                    ];
                    $config = $statusConfig[$application->status] ?? ['type' => 'secondary', 'icon' => 'circle', 'text' => 'Inconnu'];
                @endphp
                <x-status-badge 
                    status="{{ $config['type'] }}"
                    :rejectionReason="$application->rejection_reason"
                    size="md"
                >
                    <i class="fas fa-{{ $config['icon'] }} me-2"></i>{{ $config['text'] }}
                </x-status-badge>
            </div>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2 mb-3">Informations sur le stage</h5>
                        <div class="mb-3">
                            <h6 class="mb-1">{{ $application->internship->title ?? 'Non spécifié' }}</h6>
                            <p class="text-muted mb-2">{{ $application->internship->description ? Str::limit($application->internship->description, 200) : 'Aucune description disponible' }}</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @if(!empty($application->internship->skills))
                                    @foreach(explode(',', $application->internship->skills) as $skill)
                                        <span class="badge bg-primary-bg-subtle text-primary border border-primary rounded-pill px-2 py-1">
                                            <i class="fas fa-tag me-1"></i>{{ trim($skill) }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="d-flex flex-wrap gap-3 text-muted small">
                                <span><i class="fas fa-building me-1"></i> {{ $application->internship->company->name ?? 'Entreprise non spécifiée' }}</span>
                                <span><i class="fas fa-map-marker-alt me-1"></i> {{ $application->internship->location ?? 'Lieu non spécifié' }}</span>
                                <span><i class="fas fa-clock me-1"></i> {{ $application->internship->duration }} mois</span>
                                @if($application->internship->start_date)
                                    <span><i class="fas fa-calendar-alt me-1"></i> Début : {{ $application->internship->start_date->format('d/m/Y') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="border-bottom pb-2 mb-3">
                            @if(Auth::user()->role === 'company')
                                Candidat
                            @else
                                Votre candidature
                            @endif
                        </h5>
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-light text-primary rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user-graduate fa-2x"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $application->student->user->name ?? 'Non spécifié' }}</h6>
                                <p class="text-muted mb-1">{{ $application->student->promotion ?? 'Promotion non spécifiée' }}</p>
                                <p class="text-muted small mb-0">
                                    <i class="far fa-envelope me-1"></i> {{ $application->student->user->email ?? 'Email non disponible' }}
                                    @if($application->student->phone)
                                        <span class="ms-2"><i class="fas fa-phone me-1"></i> {{ $application->student->phone }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        @if(Auth::user()->role === 'student')
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle me-2"></i>Statut de votre candidature</h6>
                                <p class="mb-0">
                                    @if($application->status === 'pending')
                                        Votre candidature est en cours d'examen par l'entreprise. Vous serez notifié dès qu'un changement de statut sera effectué.
                                    @elseif($application->status === 'accepted')
                                        Félicitations ! Votre candidature a été acceptée. L'entreprise devrait vous contacter prochainement pour les prochaines étapes.
                                    @elseif($application->status === 'rejected')
                                        Votre candidature n'a pas été retenue pour ce stage. Nous vous encourageons à postuler à d'autres offres.
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                    
                    @if($application->status === 'accepted' && $application->convention)
                        <div class="alert alert-success">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><i class="fas fa-file-contract me-2"></i>Convention de stage</h6>
                                    <p class="mb-0">Votre convention de stage est disponible. Veuillez la consulter et la signer.</p>
                                </div>
                                <a href="{{ route('conventions.show', $application->convention->id) }}" class="btn btn-sm btn-success">
                                    <i class="fas fa-eye me-1"></i> Voir la convention
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Détails de la candidature</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <h6 class="small text-muted mb-1">Date de candidature</h6>
                                    <div>{{ $application->created_at->format('d/m/Y à H:i') }}</div>
                                    <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                                </li>
                                <li class="mb-3">
                                    <h6 class="small text-muted mb-1">Dernière mise à jour</h6>
                                    <div>{{ $application->updated_at->format('d/m/Y à H:i') }}</div>
                                    <small class="text-muted">{{ $application->updated_at->diffForHumans() }}</small>
                                </li>
                                @if($application->status === 'rejected' && $application->rejection_reason)
                                    <li class="border-top pt-3 mt-3">
                                        <h6 class="small text-muted mb-1">Motif du refus</h6>
                                        <p class="mb-0">{{ $application->rejection_reason }}</p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @if(Auth::user()->role === 'company' && $application->status === 'pending')
                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="w-100">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i class="fas fa-check-circle me-2"></i> Accepter la candidature
                                </button>
                            </form>
                            
                            <button type="button" 
                                    class="btn btn-outline-danger w-100"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal">
                                <i class="fas fa-times-circle me-2"></i> Refuser la candidature
                            </button>
                        @else
                            <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                            </a>
                            
                            @if(Auth::user()->role === 'student' && $application->status === 'accepted' && !$application->convention)
                                <form action="{{ route('conventions.generate') }}" method="POST" class="w-100 mt-2">
                                    @csrf
                                    <input type="hidden" name="application_id" value="{{ $application->id }}">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-file-contract me-2"></i> Générer la convention
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de refus -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Refuser la candidature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('applications.updateStatus', $application) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Motif du refus (optionnel) :</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" placeholder="Précisez la raison du refus..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Confirmer le refus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
