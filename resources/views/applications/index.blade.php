@extends('layouts.app')

@section('title', Auth::user()->role === 'company' ? 'Candidatures reçues' : 'Mes candidatures')

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 fw-bold mb-0">
            <i class="fas fa-file-alt me-2"></i>
            {{ Auth::user()->role === 'company' ? 'Candidatures reçues' : 'Mes candidatures' }}
        </h2>
        @if(Auth::user()->role === 'student')
            <a href="{{ route('internships.index') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Postuler à un stage
            </a>
        @endif
    </div>

    {{-- Alertes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($applications->isEmpty())
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-inbox fa-4x text-muted"></i>
            </div>
            <h4 class="h5 text-muted mb-3">
                {{ Auth::user()->role === 'company' ? 'Aucune candidature reçue pour le moment' : 'Vous n\'avez pas encore postulé à un stage' }}
            </h4>
            @if(Auth::user()->role === 'student')
                <a href="{{ route('internships.index') }}" class="btn btn-primary">
                    <i class="fas fa-search me-1"></i> Voir les offres disponibles
                </a>
            @endif
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Stage</th>
                            <th>{{ Auth::user()->role === 'company' ? 'Candidat' : 'Entreprise' }}</th>
                            <th>Date de candidature</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold">{{ $application->internship->title ?? 'N/A' }}</div>
                                    <small class="text-muted">
                                        {{ $application->internship->company->name ?? '' }}
                                    </small>
                                </td>
                                <td>
                                    @if(Auth::user()->role === 'company')
                                        {{ $application->student->user->name ?? 'N/A' }}
                                        <div class="small text-muted">
                                            {{ $application->student->promotion ?? '' }}
                                        </div>
                                    @else
                                        {{ $application->internship->company->name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    {{ $application->created_at->format('d/m/Y') }}
                                    <div class="small text-muted">
                                        {{ $application->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
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
                                                'text' => 'Rejetée'
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
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('applications.show', $application->id) }}" 
                                           class="btn btn-sm btn-outline-primary"
                                           data-bs-toggle="tooltip" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(Auth::user()->role === 'company' && $application->status === 'pending')
                                            <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="tooltip"
                                                        title="Accepter la candidature"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir accepter cette candidature ?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger reject-application"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal"
                                                    data-application-id="{{ $application->id }}"
                                                    title="Refuser la candidature">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white border-top-0 text-muted small">
                {{ $applications->count() }} candidature(s) au total
            </div>
        </div>
    @endif
</div>

<!-- Modal de refus -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Refuser la candidature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
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

@push('scripts')
<script>
    // Gestion du modal de refus
    document.addEventListener('DOMContentLoaded', function() {
        var rejectModal = document.getElementById('rejectModal');
        var rejectButtons = document.querySelectorAll('.reject-application');
        var rejectForm = document.getElementById('rejectForm');
        
        rejectButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var applicationId = this.getAttribute('data-application-id');
                rejectForm.action = '/applications/' + applicationId + '/status';
            });
        });
        
        // Initialiser les tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
