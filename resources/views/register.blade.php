@extends('layouts.app')

@section('title', 'Inscription - Gestion des Stages')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Commencez dès maintenant</h2>
                <p class="text-muted">Créez votre compte en quelques étapes simples</p>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Créer un compte</h4>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div class="small">{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">Nom complet</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Votre nom complet"
                                       required 
                                       autofocus>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Adresse email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-envelope text-muted"></i>
                                </span>
                                <input type="email" 
                                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="votre@email.com"
                                       required 
                                       autocomplete="email">
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="••••••••"
                                       required 
                                       autocomplete="new-password">
                            </div>
                            <div class="form-text small text-muted">Minimum 8 caractères</div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-medium">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control form-control-lg" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       placeholder="Confirmez votre mot de passe"
                                       required 
                                       autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label fw-medium">Je suis</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-user-tag text-muted"></i>
                                </span>
                                <select class="form-select form-select-lg @error('role') is-invalid @enderror" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Sélectionnez un rôle</option>
                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Étudiant</option>
                                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Enseignant</option>
                                    <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Entreprise</option>
                                </select>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-medium py-2">
                                <i class="fas fa-user-plus me-2"></i>Créer mon compte
                            </button>
                            
                            <div class="position-relative my-3">
                                <hr class="my-0">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">ou</span>
                            </div>
                            
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg py-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </a>
                        </div>

                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">
                                En vous inscrivant, vous acceptez nos 
                                <a href="#" class="text-decoration-none">conditions d'utilisation</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
