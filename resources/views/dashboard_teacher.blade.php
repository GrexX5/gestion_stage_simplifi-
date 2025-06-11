@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Dashboard enseignant</h2>
    <div class="row mb-4">
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-primary">{{ $studentsCount ?? 0 }}</div>
                    <div>Étudiants</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="h1 mb-2 text-success">{{ $internshipsCount ?? 0 }}</div>
                    <div>Stages proposés</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <a href="{{ route('applications.index') }}" class="btn btn-primary me-2">Voir les candidatures</a>
        <a href="{{ route('internships.index') }}" class="btn btn-outline-primary me-2">Voir les stages</a>
        <a href="#" class="btn btn-outline-success">Voir les conventions</a>
    </div>
</div>
@endsection
