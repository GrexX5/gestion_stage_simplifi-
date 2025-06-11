@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Détail de la convention</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Stage : {{ $convention->application->internship->title ?? '-' }}</h4>
            <p class="card-text"><strong>Étudiant :</strong> {{ $convention->application->student->user->name ?? '-' }}</p>
            <p class="card-text"><strong>Entreprise :</strong> {{ $convention->application->internship->company->name ?? '-' }}</p>
            <p class="card-text"><strong>Statut global :</strong> 
                @if($convention->status === 'pending')
                    <span class="badge bg-secondary">En attente de validation</span>
                @elseif($convention->status === 'validated')
                    <span class="badge bg-success">Validée</span>
                @elseif($convention->status === 'rejected')
                    <span class="badge bg-danger">Rejetée</span>
                @endif
            </p>
            
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Validation Enseignant</h5>
                            @if($convention->teacher_validated)
                                <p class="text-success"><i class="fas fa-check-circle"></i> Validé le {{ $convention->updated_at->format('d/m/Y') }}</p>
                            @else
                                <p class="text-warning"><i class="fas fa-clock"></i> En attente</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Validation Entreprise</h5>
                            @if($convention->company_validated)
                                <p class="text-success"><i class="fas fa-check-circle"></i> Validé le {{ $convention->updated_at->format('d/m/Y') }}</p>
                            @else
                                <p class="text-warning"><i class="fas fa-clock"></i> En attente</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="card-text mt-3"><small class="text-muted">Générée le {{ $convention->created_at->format('d/m/Y à H:i') }}</small></p>
        </div>
    </div>

    <div class="d-flex gap-2">
        @if($convention->status === 'pending')
            @if((Auth::user()->role === 'teacher' && !$convention->teacher_validated) || 
                (Auth::user()->role === 'company' && !$convention->company_validated))
                <form method="POST" action="{{ route('conventions.validate', $convention->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Valider
                    </button>
                </form>
            @endif
            
            @if(in_array(Auth::user()->role, ['teacher', 'admin']))
                <form method="POST" action="{{ route('conventions.reject', $convention->id) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette convention ?')">
                        <i class="fas fa-times"></i> Rejeter
                    </button>
                </form>
            @endif
        @endif
        
        <a href="{{ route('conventions.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
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
                {{ session('success') }}
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
                {{ session('error') }}
            </div>
        </div>
    </div>
@endif

@endsection
