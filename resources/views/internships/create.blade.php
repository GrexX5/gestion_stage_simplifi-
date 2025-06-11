@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Créer une offre de stage</h2>
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
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
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
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
<form method="POST" action="{{ route('internships.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Durée</label>
            <input type="text" name="duration" class="form-control" value="{{ old('duration') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Compétences</label>
            <input type="text" name="skills" class="form-control" value="{{ old('skills') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('internships.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
    </form>
</div>
@endsection
