@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Détail de l'offre de stage</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">{{ $internship->title }}</h4>
            <p class="card-text"><strong>Entreprise :</strong> {{ $internship->company->name ?? '-' }}</p>
            <p class="card-text"><strong>Description :</strong> {{ $internship->description }}</p>
            <p class="card-text"><strong>Durée :</strong> {{ $internship->duration }}</p>
            <p class="card-text"><strong>Compétences :</strong> {{ $internship->skills }}</p>
        </div>
    </div>
    @if(Auth::user()->role === 'student')
        <form method="POST" action="{{ route('applications.store') }}">
            @csrf
            <input type="hidden" name="internship_id" value="{{ $internship->id }}">
            <button type="submit" class="btn btn-primary">Postuler à ce stage</button>
        </form>
    @endif
    <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary mt-3">Retour à la liste</a>
</div>
@endsection
