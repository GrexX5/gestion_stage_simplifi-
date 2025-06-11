@extends('layouts.app')

@section('content')
<div class="auth-container">
    <h2>Connexion</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required>
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
    <p class="auth-link">Pas de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
</div>
@endsection
