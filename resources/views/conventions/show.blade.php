@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Détail de la convention</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">Stage : {{ $convention->application->internship->title ?? '-' }}</h4>
            <p class="card-text"><strong>Étudiant :</strong> {{ $convention->application->student->user->name ?? '-' }}</p>
            <p class="card-text"><strong>Statut :</strong> 
                @if($convention->status === 'pending')
                    <span class="badge bg-secondary">En attente</span>
                @elseif($convention->status === 'validated')
                    <span class="badge bg-success">Validée</span>
                @elseif($convention->status === 'rejected')
                    <span class="badge bg-danger">Rejetée</span>
                @endif
            </p>
            <p class="card-text"><strong>Date de génération :</strong> {{ $convention->created_at->format('d/m/Y') }}</p>
        </div>
    </div>
    @if(Auth::user()->role === 'teacher' && $convention->status === 'pending')
        <form method="POST" action="{{ route('conventions.validate', $convention->id) }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Valider</button>
        </form>
        <form method="POST" action="{{ route('conventions.reject', $convention->id) }}" class="d-inline ms-2">
            @csrf
            <button type="submit" class="btn btn-danger">Rejeter</button>
        </form>
    @endif
    <a href="{{ route('conventions.index') }}" class="btn btn-outline-secondary mt-3">Retour à la liste</a>
</div>
@endsection
