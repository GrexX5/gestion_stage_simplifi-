@extends('layouts.app')

@section('title', 'Créer une offre de stage')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Créer une nouvelle offre de stage</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('internships.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Titre du stage</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="duration">Durée (en mois)</label>
                            <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required>
                            @error('duration')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="skills">Compétences requises <span class="text-danger">*</span></label>
                            <select name="skills[]" id="skills" class="form-select @error('skills') is-invalid @enderror" multiple required>
                                @php
                                    $commonSkills = ['HTML/CSS', 'JavaScript', 'PHP', 'Python', 'Java', 'React', 'Vue.js', 'Laravel', 'Symfony', 'Node.js', 'SQL', 'Git', 'Docker', 'API REST', 'Méthodes Agiles'];
                                    $oldSkills = old('skills', []);
                                @endphp
                                @foreach($commonSkills as $skill)
                                    <option value="{{ $skill }}" {{ in_array($skill, $oldSkills) ? 'selected' : '' }}>{{ $skill }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Maintenez la touche Ctrl (ou Cmd sur Mac) pour sélectionner plusieurs compétences</div>
                            @error('skills')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                Créer l'offre
                            </button>
                            <a href="{{ route('internships.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
