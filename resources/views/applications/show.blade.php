@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Détail de la candidature</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Stage : {{ $application->internship->title ?? '-' }}</h4>
            <p class="card-text"><strong>Entreprise :</strong> {{ $application->internship->company->name ?? '-' }}</p>
            <p class="card-text"><strong>Statut :</strong> 
                @if($application->status === 'pending')
                    <span class="badge bg-secondary">En attente</span>
                @elseif($application->status === 'accepted')
                    <span class="badge bg-success">Acceptée</span>
                @elseif($application->status === 'rejected')
                    <span class="badge bg-danger">Refusée</span>
                @endif
            </p>
            <p class="card-text"><strong>Étudiant :</strong> {{ $application->student->user->name ?? '-' }}</p>
        </div>
    </div>
    <a href="{{ route('applications.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
</div>
@endsection
