@extends('layouts.app')

@section('title', 'Tableau de bord étudiant')

@section('content')
<div class="container py-4">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bold mb-1">Tableau de bord</h1>
            <p class="text-muted mb-0">Bienvenue, {{ Auth::user()->name }} !</p>
        </div>
        <div>
            <a href="{{ route('internships.index') }}" class="btn btn-primary px-4">
                <i class="fas fa-search me-2"></i> Trouver un stage
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-file-alt text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="h5 fw-bold mb-0">{{ $applicationsCount ?? 0 }}</h3>
                            <p class="text-muted small mb-0">Candidatures</p>
                        </div>
                    </div>
                    <a href="{{ route('applications.index') }}" class="stretched-link text-decoration-none"></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-file-signature text-success fs-4"></i>
                        </div>
                        <div>
                            <h3 class="h5 fw-bold mb-0">{{ $conventionsCount ?? 0 }}</h3>
                            <p class="text-muted small mb-0">Conventions</p>
                        </div>
                    </div>
                    <a href="{{ route('conventions.index') }}" class="stretched-link text-decoration-none"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières offres -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Dernières offres de stage</h5>
            <a href="{{ route('internships.index') }}" class="btn btn-sm btn-outline-primary">
                Voir tout <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body">
            @if(isset($recentInternships) && $recentInternships->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Poste</th>
                                <th>Entreprise</th>
                                <th>Localisation</th>
                                <th>Date de publication</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentInternships as $internship)
                            <tr>
                                <td>{{ $internship->title }}</td>
                                <td>{{ $internship->company->name }}</td>
                                <td>{{ $internship->location }}</td>
                                <td>{{ $internship->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('internships.show', $internship) }}" class="btn btn-sm btn-outline-primary">
                                        Voir <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('internships.index') }}" class="btn btn-link text-decoration-none">
                        Voir toutes les offres <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-briefcase fa-3x text-muted"></i>
                    </div>
                    <h5 class="mb-2">Aucune offre récente</h5>
                    <p class="text-muted mb-0">Consultez les offres de stage disponibles</p>
                    <a href="{{ route('internships.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-search me-1"></i> Voir les offres
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Espace pour contenu futur -->
</div>


@endsection
