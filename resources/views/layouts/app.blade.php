<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestion de Stages') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    <!-- CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="app-container">
        <!-- Navigation -->
        <nav class="main-nav">
            <div class="nav-container">
                <div class="logo">
                    <a href="{{ url('/') }}">GestionStages</a>
                </div>
                <button class="mobile-menu-button" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <ul class="nav-links">
    @auth
        {{-- Dashboard selon le rôle --}}
        <li><a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a></li>

        {{-- Stages (pour tous) --}}
        <li><a href="{{ route('internships.index') }}" class="{{ request()->is('internships*') ? 'active' : '' }}">Stages</a></li>

        {{-- Candidatures --}}
        @if(Auth::user()->role === 'student' || Auth::user()->role === 'company' || Auth::user()->role === 'teacher')
            <li><a href="{{ route('applications.index') }}" class="{{ request()->is('applications*') ? 'active' : '' }}">Candidatures</a></li>
        @endif

        {{-- Conventions --}}
        <li><a href="{{ route('conventions.index') }}" class="{{ request()->is('conventions*') ? 'active' : '' }}">Conventions</a></li>

        {{-- Actions spécifiques entreprise --}}
        @if(Auth::user()->role === 'company')
            <li><a href="{{ route('internships.create') }}" class="{{ request()->is('internships/create') ? 'active' : '' }}">Créer un stage</a></li>
        @endif

        {{-- Actions spécifiques étudiant --}}
        @if(Auth::user()->role === 'student')
            <li><a href="{{ route('applications.index') }}" class="{{ request()->is('applications*') ? 'active' : '' }}">Mes candidatures</a></li>
        @endif

        {{-- Dropdown utilisateur --}}
        <li class="nav-item dropdown">
            <a id="navbarDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Déconnexion') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    @else
        <li><a href="{{ route('login') }}">Connexion</a></li>
        @if (Route::has('register'))
            <li><a href="{{ route('register') }}">Inscription</a></li>
        @endif
    @endauth
</ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-content">
                <p>&copy; {{ date('Y') }} Gestion de Stages. Tous droits réservés.</p>
            </div>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
