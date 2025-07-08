@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Offres de stage</h2>
        @if(Auth::user()->role === 'company')
            <a href="{{ route('internships.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nouvelle offre
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Auth::user()->role === 'student')
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control" 
                               placeholder="Rechercher par mot-clé..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="skills" class="form-control" 
                               placeholder="Compétences..." value="{{ request('skills') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="fas fa-search me-1"></i> Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr class="table-light">
                    <th>Titre</th>
                    <th>Entreprise</th>
                    <th>Durée</th>
                    <th>Compétences</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($internships as $internship)
                    <tr>
                        <td>
                            <a href="{{ route('internships.show', $internship->id) }}" class="text-decoration-none">
                                {{ $internship->title }}
                            </a>
                        </td>
                        <td>{{ $internship->company->name ?? '-' }}</td>
                        <td>{{ $internship->duration }} mois</td>
                        <td>
                            <span class="badge bg-light text-dark">
                                {{ $internship->skills }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('internships.show', $internship->id) }}" 
                                   class="btn btn-sm btn-outline-primary"
                                   title="Voir les détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if(Auth::user()->role === 'student')
                                    @php
                                        $alreadyApplied = false;
                                        if (Auth::user()->student) {
                                            $alreadyApplied = $internship->applications->where('student_id', Auth::user()->student->id)->count() > 0;
                                        }
                                    @endphp
                                    @if($alreadyApplied)
                                        <button class="btn btn-sm btn-success" disabled>
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @else
                                        <form action="{{ route('applications.store') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="internship_id" value="{{ $internship->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary" title="Postuler">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif

                                @if(Auth::user()->role === 'company' && Auth::user()->company && Auth::user()->company->id == $internship->company_id)
                                    <a href="{{ route('internships.edit', $internship->id) }}" 
                                       class="btn btn-sm btn-outline-secondary"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Supprimer cette offre ?')"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('applications.index', ['internship_id' => $internship->id]) }}" 
                                       class="btn btn-sm btn-outline-info"
                                       title="Voir les candidatures">
                                        <i class="fas fa-users"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <p class="mb-0">Aucune offre disponible pour le moment</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-muted small">
        {{ $internships->count() }} offre(s) de stage au total
    </div>
</div>
@endsection
