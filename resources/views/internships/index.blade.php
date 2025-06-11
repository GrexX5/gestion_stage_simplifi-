@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des offres de stage</h2>

    {{-- Feedback messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(Auth::user()->role === 'student')
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Recherche titre, description, compétences" value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="duration" class="form-control" placeholder="Durée" value="{{ request('duration') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="skills" class="form-control" placeholder="Compétences" value="{{ request('skills') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary w-100">Filtrer</button>
            </div>
        </form>
    @endif

    @if(Auth::user()->role === 'company')
        <a href="{{ route('internships.create') }}" class="btn btn-primary mb-3">Créer une offre</a>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Titre</th>
                    <th>Entreprise</th>
                    <th>Durée</th>
                    <th>Compétences</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($internships as $internship)
                    <tr>
                        <td>{{ $internship->title }}</td>
                        <td>{{ $internship->company->name ?? '-' }}</td>
                        <td>{{ $internship->duration }}</td>
                        <td>{{ $internship->skills }}</td>
                        <td>
                            <a href="{{ route('internships.show', $internship->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            @if(Auth::user()->role === 'student')
                                @php
                                    $alreadyApplied = false;
                                    if (Auth::user()->student) {
                                        $alreadyApplied = $internship->applications->where('student_id', Auth::user()->student->id)->count() > 0;
                                    }
                                @endphp
                                @if($alreadyApplied)
                                    <button class="btn btn-sm btn-success" disabled>Déjà postulé</button>
                                @else
                                    <form action="{{ route('applications.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="internship_id" value="{{ $internship->id }}">
                                        <button type="submit" class="btn btn-sm btn-primary">Postuler</button>
                                    </form>
                                @endif
                            @endif
                            @if(Auth::user()->role === 'company' && Auth::user()->company && Auth::user()->company->id == $internship->company_id)
                                <a href="{{ route('internships.edit', $internship->id) }}" class="btn btn-sm btn-outline-secondary">Éditer</a>
                                <form action="{{ route('internships.destroy', $internship->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer cette offre ?')">Supprimer</button>
                                </form>
                                <a href="{{ route('applications.index', ['internship_id' => $internship->id]) }}" class="btn btn-sm btn-info ms-1">Voir candidatures</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Aucune offre disponible.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
