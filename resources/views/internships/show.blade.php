@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('internships.index') }}">Offres de stage</a></li>
            <li class="breadcrumb-item active" aria-current="page">Détails</li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="h5 mb-0">{{ $internship->title }}</h3>
                <span class="badge bg-light text-dark">{{ $internship->duration }} mois</span>
            </div>
            <p class="mb-0 mt-2">
                <i class="fas fa-building me-2"></i>
                {{ $internship->company->name ?? 'Entreprise non spécifiée' }}
            </p>
        </div>
        
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h5 class="border-bottom pb-2 mb-3">Description du poste</h5>
                    <div class="mb-4">
                        {!! nl2br(e($internship->description)) !!}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Détails</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                                    <strong>Durée :</strong> {{ $internship->duration }} mois
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>Lieu :</strong> {{ $internship->location ?? 'Non spécifié' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <strong>Publiée le :</strong> {{ $internship->created_at->format('d/m/Y') }}
                                </li>
                            </ul>
                            
                            @if(Auth::user()->role === 'company' && Auth::user()->company && Auth::user()->company->id == $internship->company_id)
                                <div class="mt-3 d-grid gap-2">
                                    <a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i> Modifier l'offre
                                    </a>
                                    <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                            <i class="fas fa-trash me-1"></i> Supprimer l'offre
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <h5 class="border-bottom pb-2 mb-3">Compétences requises</h5>
                <div class="d-flex flex-wrap gap-2">
                    @foreach(explode(',', $internship->skills) as $skill)
                        <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                            <i class="fas fa-check-circle me-1"></i>
                            {{ trim($skill) }}
                        </span>
                    @endforeach
                </div>
            </div>
            
            @if(!empty($internship->additional_info))
                <div class="mb-4">
                    <h5 class="border-bottom pb-2 mb-3">Informations complémentaires</h5>
                    <div class="p-3 bg-light rounded">
                        {!! nl2br(e($internship->additional_info)) !!}
                    </div>
                </div>
            @endif
        </div>
        
        <div class="card-footer bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Retour à la liste
                </a>
                
                @if(Auth::user()->role === 'student')
                    @php
                        $alreadyApplied = false;
                        if (Auth::user()->student) {
                            $alreadyApplied = $internship->applications->where('student_id', Auth::user()->student->id)->count() > 0;
                        }
                    @endphp
                    
                    @if($alreadyApplied)
                        <button class="btn btn-success" disabled>
                            <i class="fas fa-check-circle me-1"></i> Vous avez déjà postulé
                        </button>
                    @else
                        <form action="{{ route('applications.store') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="internship_id" value="{{ $internship->id }}">
                            <button type="submit" class="btn btn-primary btn-lg px-4" onclick="return confirm('Êtes-vous sûr de vouloir postuler à cette offre ?')">
                                <i class="fas fa-paper-plane me-2"></i> Postuler à cette offre
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
