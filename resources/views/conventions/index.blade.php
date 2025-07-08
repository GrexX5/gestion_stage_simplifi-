@extends('layouts.app')

@section('title', 'Gestion des conventions de stage')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item active" aria-current="page">Conventions de stage</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0">
            <i class="fas fa-file-contract text-primary me-2"></i>Gestion des conventions
        </h1>
        
        @if(Auth::user()->role === 'student' && $hasPendingApplication)
            <a href="{{ route('internships.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-search me-2"></i>Voir les offres de stage
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($conventions->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-file-contract fa-4x text-muted mb-4"></i>
                    <h3 class="h5 mb-3">Aucune convention disponible</h3>
                    <p class="text-muted mb-4">
                        @if(Auth::user()->role === 'student')
                            Vous n'avez pas encore de convention de stage. Commencez par postuler à une offre de stage.
                        @else
                            Aucune convention n'a encore été créée pour le moment.
                        @endif
                    </p>
                    @if(Auth::user()->role === 'student')
                        <a href="{{ route('internships.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Voir les offres de stage
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h6 class="mb-0">
                            <i class="fas fa-list-ul text-primary me-2"></i>
                            {{ $conventions->count() }} convention(s) au total
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <div class="input-group input-group-sm" style="max-width: 300px;">
                                <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3">Étudiant</th>
                            <th class="py-3">Entreprise</th>
                            <th class="py-3">Stage</th>
                            <th class="py-3 text-center">Statut</th>
                            <th class="py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conventions as $convention)
                            @php
                                $studentName = $convention->application->student->user->name ?? 'Non spécifié';
                                $companyName = $convention->application->internship->company->name ?? 'Non spécifiée';
                                $internshipTitle = $convention->application->internship->title ?? 'Non spécifié';
                                $studentId = $convention->application->student_id ?? null;
                                $companyId = $convention->application->internship->company_id ?? null;
                            @endphp
                            
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm bg-light text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-user-graduate"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">{{ $studentName }}</h6>
                                            <small class="text-muted">{{ $convention->application->student->promotion ?? 'Promotion non spécifiée' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="avatar avatar-sm bg-light text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <h6 class="mb-0">{{ $companyName }}</h6>
                                            <small class="text-muted">{{ $convention->application->internship->location ?? 'Lieu non spécifié' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ Str::limit($internshipTitle, 30) }}</h6>
                                    <small class="text-muted">
                                        {{ $convention->application->internship->start_date ? $convention->application->internship->start_date->format('d/m/Y') : 'Date non définie' }}
                                        - 
                                        {{ $convention->application->internship->duration ?? '?' }} mois
                                    </small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusConfig = [
                                            'draft' => [
                                                'text' => 'Brouillon',
                                                'icon' => 'file',
                                                'type' => 'secondary'
                                            ],
                                            'pending_teacher' => [
                                                'text' => 'En attente enseignant',
                                                'icon' => 'user-tie',
                                                'type' => 'warning'
                                            ],
                                            'pending_company' => [
                                                'text' => 'En attente entreprise',
                                                'icon' => 'building',
                                                'type' => 'warning'
                                            ],
                                            'validated' => [
                                                'text' => 'Validée',
                                                'icon' => 'check-double',
                                                'type' => 'success'
                                            ],
                                            'rejected' => [
                                                'text' => 'Rejetée',
                                                'icon' => 'times-circle',
                                                'type' => 'danger'
                                            ]
                                        ];
                                        $statusInfo = $statusConfig[$convention->status] ?? ['text' => 'Inconnu', 'icon' => 'question-circle', 'type' => 'secondary'];
                                    @endphp
                                    
                                    <div class="d-flex flex-column align-items-center">
                                        <x-status-badge 
                                            status="{{ $statusInfo['type'] }}"
                                            size="md"
                                        >
                                            <i class="fas fa-{{ $statusInfo['icon'] }} me-2"></i>{{ $statusInfo['text'] }}
                                        </x-status-badge>
                                        
                                        @if($convention->status === 'validated' && $convention->validated_at)
                                            <div class="small text-muted mt-1">
                                                <i class="far fa-calendar-check me-1"></i>
                                                {{ $convention->validated_at->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('conventions.show', $convention) }}" 
                                           class="btn btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(Auth::user()->role === 'admin' || (Auth::user()->role === 'teacher' && $convention->status === 'pending_teacher') || (Auth::user()->role === 'company' && $convention->status === 'pending_company' && Auth::id() === $companyId))
                                            <button type="button" 
                                                    class="btn btn-outline-success"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#validateModal{{ $convention->id }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Valider la convention">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            
                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $convention->id }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Refuser la convention">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Modal de validation -->
                            <div class="modal fade" id="validateModal{{ $convention->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Valider la convention</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('conventions.validate', $convention) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Confirmez-vous la validation de cette convention de stage ?</p>
                                                <p class="mb-0"><strong>Étudiant :</strong> {{ $studentName }}</p>
                                                <p class="mb-0"><strong>Entreprise :</strong> {{ $companyName }}</p>
                                                <p><strong>Stage :</strong> {{ $internshipTitle }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check-circle me-1"></i> Confirmer la validation
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Modal de rejet -->
                            <div class="modal fade" id="rejectModal{{ $convention->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Refuser la convention</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('conventions.reject', $convention) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <p>Veuillez indiquer la raison du refus de cette convention :</p>
                                                <div class="mb-3">
                                                    <label for="rejection_reason" class="form-label">Motif du refus :</label>
                                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times-circle me-1"></i> Confirmer le refus
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top-0">
                <div class="text-muted small">
                    Nombre total de conventions : <strong>{{ $conventions->count() }}</strong>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Initialisation des tooltips Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Filtrage des conventions
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
@endsection
