@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Éditer une offre de stage</h2>
    <form method="POST" action="{{ route('internships.update', $internship->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $internship->title) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $internship->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Durée</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration', $internship->duration) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Compétences</label>
            <input type="text" name="skills" class="form-control" value="{{ old('skills', $internship->skills) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
