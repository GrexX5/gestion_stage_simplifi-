@extends('layouts.app')

@section('title', 'Accueil - Gestion des Stages')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Simplifiez la gestion de vos <span class="text-primary">stages</span></h1>
                <p class="lead text-muted mb-4">La plateforme tout-en-un pour gérer facilement vos stages, vos candidatures et suivre votre progression en temps réel.</p>
                <div class="d-flex flex-wrap gap-3 justify-content-center">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-rocket me-2"></i> Commencer maintenant
                        </a>
                        <a href="#features" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-info-circle me-2"></i> Découvrir
                        </a>
                        <div class="w-100 text-center mt-2">
                            <small class="text-muted">Déjà inscrit ? 
                                <a href="{{ route('login') }}" class="text-primary text-decoration-none">Se connecter</a>
                            </small>
                        </div>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-tachometer-alt me-2"></i> Tableau de bord
                        </a>
                    @endguest
                </div>
                <div class="mt-4 text-center">
                    <p class="mb-0 text-muted">Rejoignez plus de <span class="fw-bold">1 500</span> utilisateurs satisfaits</p>
                    <div class="text-warning">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                        <span class="text-muted ms-1">4.8/5</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Une solution complète pour la <span class="text-primary">gestion des stages</span></h2>
            <p class="lead text-muted">Découvrez comment notre plateforme peut vous aider à simplifier et optimiser la gestion de vos stages.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-search text-primary fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Trouvez le stage idéal</h3>
                        <p class="text-muted mb-0">Accédez à des centaines d'offres de stages dans votre domaine d'études et trouvez celui qui correspond à vos aspirations professionnelles.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-success bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-file-upload text-success fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Gérez vos candidatures</h3>
                        <p class="text-muted mb-0">Suivez l'état de vos candidatures en temps réel et recevez des notifications pour ne rien manquer.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-info bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-file-signature text-info fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Conventions simplifiées</h3>
                        <p class="text-muted mb-0">Gérez facilement vos conventions de stage avec un processus simplifié et entièrement numérique.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-warning bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-tasks text-warning fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Suivi de stage</h3>
                        <p class="text-muted mb-0">Planifiez vos tâches et suivez votre progression tout au long de votre stage.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-comments text-danger fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Communication facilitée</h3>
                        <p class="text-muted mb-0">Échangez facilement avec votre tuteur et votre établissement via notre messagerie intégrée.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="bg-purple bg-opacity-10 p-3 rounded-3 d-inline-block mb-4">
                            <i class="fas fa-mobile-alt text-purple fs-2"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-3">Accès mobile</h3>
                        <p class="text-muted mb-0">Accédez à votre espace depuis n'importe quel appareil, où que vous soyez.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5">
                <h2 class="display-6 fw-bold mb-4">Comment ça marche ?</h2>
                <p class="lead text-muted">Découvrez en quelques étapes comment notre plateforme peut vous simplifier la vie</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <span class="fw-bold">1</span>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="h5 fw-bold">Créez votre compte</h4>
                        <p class="text-muted mb-0">Inscrivez-vous en quelques secondes en tant qu'étudiant, enseignant ou entreprise.</p>
                    </div>
                </div>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <span class="fw-bold">2</span>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="h5 fw-bold">Trouvez ou proposez un stage</h4>
                        <p class="text-muted mb-0">Parcourez les offres ou déposez votre annonce en quelques clics.</p>
                    </div>
                </div>
                
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <span class="fw-bold">3</span>
                        </div>
                    </div>
                    <div class="ms-4">
                        <h4 class="h5 fw-bold">Gérez votre expérience</h4>
                        <p class="text-muted mb-0">Suivez vos candidatures, signez vos conventions et échangez avec les autres utilisateurs.</p>
                    </div>
                </div>
                
                <div class="mt-5">
                    <a href="{{ route('register') }}" class="btn btn-outline-primary px-4">
                        <i class="fas fa-arrow-right me-2"></i> Découvrir plus
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container py-5">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold mb-4">Prêt à commencer ?</h2>
                <p class="lead mb-5">Rejoignez dès maintenant notre communauté d'étudiants, d'enseignants et d'entreprises et simplifiez la gestion de vos stages.</p>
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 mb-3">
                        <i class="fas fa-rocket me-2"></i> Commencer maintenant
                    </a>
                    <div>
                        <small class="text-white-50">Déjà un compte ? 
                            <a href="{{ route('login') }}" class="text-white text-decoration-underline">Se connecter</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    :root {
        --bs-purple: #6f42c1;
    }
    
    .bg-purple {
        background-color: var(--bs-purple) !important;
    }
    
    .text-purple {
        color: var(--bs-purple) !important;
    }
    
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .btn-primary {
        --bs-btn-bg: #0d6efd;
        --bs-btn-border-color: #0d6efd;
        --bs-btn-hover-bg: #0b5ed7;
        --bs-btn-hover-border-color: #0a58ca;
        --bs-btn-active-bg: #0a58ca;
        --bs-btn-active-border-color: #0a53be;
    }
</style>
@endpush

@push('scripts')
<script>
    // Animation pour les éléments au défilement
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation des tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Animation au défilement
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.hover-lift, .card, .btn');
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }
        
        // Appliquer l'animation au chargement
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
@endpush
@endsection
