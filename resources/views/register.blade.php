@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h2>Inscription</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus>
            @error('name')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div class="form-group">
            <label for="role">Rôle</label>
            <select name="role" id="role" required>
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Étudiant</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Enseignant</option>
                <option value="company" {{ old('role') == 'company' ? 'selected' : '' }}>Entreprise</option>
            </select>
            @error('role')<span class="error">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <p class="auth-link">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
</div>
@endsection
