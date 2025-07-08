@extends('layouts.app')

@section('title', 'Éditer l\'offre : ' . $internship->title)

@push('styles')
<style>
    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .skill-tag {
        display: inline-flex;
        align-items: center;
        background-color: #e9ecef;
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        font-size: 0.875rem;
    }
    .skill-tag .remove-skill {
        margin-left: 0.5rem;
        cursor: pointer;
        color: #6c757d;
    }
    .skill-tag .remove-skill:hover {
        color: #dc3545;
    }
    .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__rendered {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Tableau de bord</a></li>
            <li class="breadcrumb-item"><a href="{{ route('internships.index') }}">Offres de stage</a></li>
            <li class="breadcrumb-item active" aria-current="page">Éditer</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h5 mb-0">
                            <i class="fas fa-edit text-primary me-2"></i>Éditer l'offre de stage
                        </h1>
                        <div>
                            <a href="{{ route('internships.show', $internship) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i> Aperçu
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Erreur</h5>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('internships.update', $internship) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <label for="title" class="form-label fw-bold">Titre du stage <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $internship->title) }}" 
                                           required
                                           placeholder="Ex: Développeur Web Full Stack">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="form-label fw-bold">Description détaillée <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="8" 
                                              required
                                              placeholder="Décrivez en détail la mission, les responsabilités, l'environnement de travail...">{{ old('description', $internship->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="skills" class="form-label fw-bold">Compétences requises <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('skills') is-invalid @enderror" 
                                           id="skills" 
                                           name="skills" 
                                           value="{{ old('skills', $internship->skills) }}" 
                                           required
                                           placeholder="Séparez les compétences par des virgules">
                                    <div class="form-text">Ex: PHP, JavaScript, HTML, CSS, MySQL, Git</div>
                                    @error('skills')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-2" id="skills-preview">
                                        @if(old('skills', $internship->skills))
                                            @foreach(explode(',', old('skills', $internship->skills)) as $skill)
                                                @if(trim($skill) !== '')
                                                    <span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">
                                                        {{ trim($skill) }}
                                                    </span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card border-0 bg-light mb-4">
                                    <div class="card-body">
                                        <h6 class="card-title border-bottom pb-2 mb-3">
                                            <i class="fas fa-info-circle me-2"></i>Informations complémentaires
                                        </h6>
                                        
                                        <div class="mb-3">
                                            <label for="start_date" class="form-label fw-bold">Date de début <span class="text-danger">*</span></label>
                                            <input type="date" 
                                                   class="form-control @error('start_date') is-invalid @enderror" 
                                                   id="start_date" 
                                                   name="start_date" 
                                                   value="{{ old('start_date', $internship->start_date ? $internship->start_date->format('Y-m-d') : '') }}" 
                                                   required>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="duration" class="form-label fw-bold">Durée (en mois) <span class="text-danger">*</span></label>
                                            <input type="number" 
                                                   class="form-control @error('duration') is-invalid @enderror" 
                                                   id="duration" 
                                                   name="duration" 
                                                   min="1" 
                                                   max="12" 
                                                   value="{{ old('duration', $internship->duration) }}" 
                                                   required>
                                            @error('duration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="location" class="form-label fw-bold">Lieu <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('location') is-invalid @enderror" 
                                                   id="location" 
                                                   name="location" 
                                                   value="{{ old('location', $internship->location) }}" 
                                                   required
                                                   placeholder="Ex: Paris (75)">
                                            @error('location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="remuneration" class="form-label fw-bold">Rémunération</label>
                                            <div class="input-group">
                                                <input type="number" 
                                                       class="form-control @error('remuneration') is-invalid @enderror" 
                                                       id="remuneration" 
                                                       name="remuneration" 
                                                       min="0" 
                                                       step="0.01"
                                                       value="{{ old('remuneration', $internship->remuneration) }}" 
                                                       placeholder="Montant">
                                                <span class="input-group-text">€ / mois</span>
                                            </div>
                                            @error('remuneration')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="remote" 
                                                   name="remote" 
                                                   value="1"
                                                   {{ old('remote', $internship->remote) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remote">Télétravail possible</label>
                                        </div>
                                        
                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1"
                                                   {{ old('is_active', $internship->is_active) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">Offre active</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Enregistrer les modifications
                                    </button>
                                    <a href="{{ route('internships.show', $internship) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i> Annuler
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Aperçu des compétences en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        const skillsInput = document.getElementById('skills');
        const skillsPreview = document.getElementById('skills-preview');
        
        function updateSkillsPreview() {
            const skills = skillsInput.value.split(',').map(skill => skill.trim()).filter(skill => skill !== '');
            
            skillsPreview.innerHTML = skills.map(skill => 
                `<span class="badge bg-primary bg-opacity-10 text-primary me-1 mb-1">${skill}</span>`
            ).join('');
        }
        
        skillsInput.addEventListener('input', updateSkillsPreview);
        
        // Initial preview
        updateSkillsPreview();
        
        // Initialisation des tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
