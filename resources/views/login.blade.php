@extends('layouts.app')

@section('title', 'Connexion - Gestion des Stages')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-75">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3">Bienvenue !</h2>
                <p class="text-muted">Connectez-vous pour accéder à votre espace personnel</p>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Connexion</h4>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div class="small">{{ session('error') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
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
                                       autocomplete="email" 
                                       autofocus>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label for="password" class="form-label fw-medium mb-0">Mot de passe</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="small text-decoration-none">
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>
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
                                       autocomplete="current-password">
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    <small>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-medium py-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                            </button>
                            
                            <div class="position-relative my-3">
                                <hr class="my-0">
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">ou</span>
                            </div>
                            
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg py-2">
                                <i class="fas fa-user-plus me-2"></i>Créer un compte
                            </a>
                        </div>

                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="small text-muted mb-0">
                                En vous connectant, vous acceptez nos 
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
