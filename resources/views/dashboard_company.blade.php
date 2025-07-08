@extends('layouts.app')

@section('title', 'Tableau de bord - ' . (Auth::user()->company->name ?? 'Espace entreprise'))

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-left: 4px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    .stat-card i {
        font-size: 2rem;
        opacity: 0.8;
    }
    .stat-card .stat-value {
        font-size: 2rem;
        font-weight: 600;
        line-height: 1.2;
    }
    .stat-card .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .quick-actions .btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem 0.5rem;
        border-radius: 0.5rem;
        text-align: center;
        transition: all 0.2s;
    }
    .quick-actions .btn i {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    .recent-activity {
        position: relative;
        padding-left: 1.5rem;
    }
    .recent-activity::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e9ecef;
    }
    .activity-item {
        position: relative;
        padding-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .activity-item:last-child {
        padding-bottom: 0;
    }
    .activity-item::before {
        content: '';
        position: absolute;
        left: -1.5rem;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #0d6efd;
        border: 2px solid #fff;
    }
    .activity-date {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .activity-content {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 0.5rem;
    }
    .progress-thin {
        height: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-tachometer-alt text-primary me-2"></i>Tableau de bord
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('internships.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nouvelle offre de stage
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-start border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value text-primary">{{ $internshipsCount ?? 0 }}</div>
                            <div class="stat-label">Stages publiés</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-briefcase text-primary"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('internships.index') }}" class="small text-primary text-decoration-none">
                            Voir tous les stages <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-start border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value text-success">{{ $applicationsCount ?? 0 }}</div>
                            <div class="stat-label">Candidatures reçues</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-file-alt text-success"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('applications.index') }}" class="small text-success text-decoration-none">
                            Voir les candidatures <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-start border-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value text-info">{{ $activeInternshipsCount ?? 0 }}</div>
                            <div class="stat-label">Stages actifs</div>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-check-circle text-info"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('internships.index', ['status' => 'active']) }}" class="small text-info text-decoration-none">
                            Voir les stages actifs <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
            <div class="card stat-card border-start border-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-value text-warning">{{ $pendingConventionsCount ?? 0 }}</div>
                            <div class="stat-label">Conventions en attente</div>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-file-contract text-warning"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('conventions.index', ['status' => 'pending']) }}" class="small text-warning text-decoration-none">
                            Voir les conventions <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Dernières candidatures -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-file-alt text-primary me-2"></i>Dernières candidatures
                        </h5>
                        <a href="{{ route('applications.index') }}" class="btn btn-sm btn-outline-primary">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentApplications && $recentApplications->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentApplications as $application)
                                <a href="{{ route('applications.show', $application) }}" class="list-group-item list-group-item-action border-0 py-3 px-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light text-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $application->student->user->name ?? 'Candidat' }}</h6>
                                                <small class="text-muted">{{ $application->internship->title ?? 'Stage' }}</small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $application->status === 'accepted' ? 'success' : ($application->status === 'rejected' ? 'danger' : 'warning') }}">
                                                {{ $application->status === 'pending' ? 'En attente' : ($application->status === 'accepted' ? 'Acceptée' : 'Refusée') }}
                                            </span>
                                            <div class="text-muted small mt-1">
                                                {{ $application->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-inbox fa-3x text-muted"></i>
                            </div>
                            <h5 class="text-muted">Aucune candidature récente</h5>
                            <p class="text-muted small">Les candidatures apparaîtront ici</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Actions rapides et activités -->
        <div class="col-lg-4">
            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>Actions rapides
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div class="row g-2 text-center quick-actions">
                        <div class="col-6">
                            <a href="{{ route('internships.create') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus"></i>
                                <span>Nouvelle offre</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('applications.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-file-alt"></i>
                                <span>Candidatures</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('conventions.index') }}" class="btn btn-outline-info">
                                <i class="fas fa-file-contract"></i>
                                <span>Conventions</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Activités récentes -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-primary me-2"></i>Activité récente
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentActivities && $recentActivities->count() > 0)
                        <div class="recent-activity">
                            @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-date small text-muted">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </div>
                                    <div class="activity-content">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-2">
                                                @if($activity->type === 'internship_created')
                                                    <i class="fas fa-briefcase text-primary"></i>
                                                @elseif($activity->type === 'application_received')
                                                    <i class="fas fa-file-import text-success"></i>
                                                @elseif($activity->type === 'convention_signed')
                                                    <i class="fas fa-file-signature text-info"></i>
                                                @else
                                                    <i class="fas fa-info-circle text-secondary"></i>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small">
                                                    @if($activity->type === 'internship_created')
                                                        Nouvelle offre publiée : {{ $activity->data['title'] ?? '' }}
                                                    @elseif($activity->type === 'application_received')
                                                        Nouvelle candidature reçue
                                                    @elseif($activity->type === 'convention_signed')
                                                        Convention signée par l'étudiant
                                                    @else
                                                        {{ $activity->description }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted small mb-0">Aucune activité récente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Initialisation des tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection
