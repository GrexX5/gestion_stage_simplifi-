@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard entreprise</h2>
    <div class="row mb-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-primary">{{ $internshipsCount ?? 0 }}</div>
                    <div>Stages publiés</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-success">{{ $applicationsCount ?? 0 }}</div>
                    <div>Candidatures reçues</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <a href="{{ route('internships.create') }}" class="btn btn-primary me-2">Créer une offre de stage</a>
        <a href="{{ route('applications.index') }}" class="btn btn-outline-primary me-2">Voir les candidatures</a>
        <a href="#" class="btn btn-outline-success">Voir les conventions</a>
    </div>
</div>
@endsection
