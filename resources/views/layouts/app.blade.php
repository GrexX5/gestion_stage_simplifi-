<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Gestion de Stages'))</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link href="{{ asset('css/fontawesome.min.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-primary" href="{{ url('/') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                GestionStages
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active fw-bold' : '' }}" 
                               href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-1"></i> Tableau de bord
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('internships*') ? 'active fw-bold' : '' }}" 
                               href="{{ route('internships.index') }}">
                                <i class="fas fa-briefcase me-1"></i> Stages
                            </a>
                        </li>
                        
                        @if(in_array(Auth::user()->role, ['student', 'company', 'teacher']))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('applications*') ? 'active fw-bold' : '' }}" 
                               href="{{ route('applications.index') }}">
                                <i class="fas fa-file-alt me-1"></i> 
                                {{ Auth::user()->role === 'student' ? 'Mes candidatures' : 'Candidatures' }}
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('conventions*') ? 'active fw-bold' : '' }}" 
                               href="{{ route('conventions.index') }}">
                                <i class="fas fa-file-signature me-1"></i> Conventions
                            </a>
                        </li>
                        
                        @if(Auth::user()->role === 'company')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('internships/create') ? 'active fw-bold' : '' }}" 
                               href="{{ route('internships.create') }}">
                                <i class="fas fa-plus-circle me-1"></i> Nouveau stage
                            </a>
                        </li>
                        @endif
                    </ul>
                    
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" 
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="me-2 d-none d-sm-block">
                                    <div class="text-end">
                                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                                    </div>
                                </div>
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 36px; height: 36px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user-cog me-2"></i> Mon profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active fw-bold' : '' }}" 
                               href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Connexion
                            </a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active fw-bold' : '' }}" 
                               href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Inscription
                            </a>
                        </li>
                        @endif
                    </ul>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Des erreurs sont présentes :</h6>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 mt-auto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                        <span class="fw-bold">GestionStages</span>
                    </div>
                    <p class="text-muted small mb-0 mt-2">
                        Simplifiez la gestion de vos stages en entreprise.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="mb-2">
                        <a href="#" class="text-decoration-none text-muted me-3 small">
                            <i class="fas fa-info-circle me-1"></i> À propos
                        </a>
                        <a href="#" class="text-decoration-none text-muted me-3 small">
                            <i class="fas fa-question-circle me-1"></i> Aide
                        </a>
                        <a href="#" class="text-decoration-none text-muted small">
                            <i class="fas fa-envelope me-1"></i> Contact
                        </a>
                    </div>
                    <p class="text-muted small mb-0">
                        &copy; {{ date('Y') }} GestionStages. Tous droits réservés.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
    
    <script>
        // Activer les tooltips partout
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Gestion du thème clair/sombre
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', function() {
                    const html = document.documentElement;
                    const isDark = html.getAttribute('data-bs-theme') === 'dark';
                    html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
                    localStorage.setItem('theme', isDark ? 'light' : 'dark');
                });
            }
        });
    </script>
</body>
</html>
