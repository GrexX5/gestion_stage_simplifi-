@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard étudiant</h2>
    <div class="row mb-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-primary">{{ $applicationsCount ?? 0 }}</div>
                    <div>Candidatures</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-success">{{ $conventionsCount ?? 0 }}</div>
                    <div>Conventions</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <a href="{{ route('internships.index') }}" class="btn btn-primary me-2">Voir les offres de stage</a>
        <a href="{{ route('applications.index') }}" class="btn btn-outline-primary me-2">Mes candidatures</a>
        <a href="#" class="btn btn-outline-success">Mes conventions</a>
    </div>
</div>
@endsection
