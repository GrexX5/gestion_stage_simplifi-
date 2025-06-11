/**
 * Gestion des interactions principales de l'application
 */

document.addEventListener('DOMContentLoaded', function() {
    // Menu mobile
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const navLinks = document.querySelector('.nav-links');
    
    if (mobileMenuButton && navLinks) {
        mobileMenuButton.addEventListener('click', function() {
            this.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
    }
    
    // Fermer le menu mobile quand on clique sur un lien
    const navItems = document.querySelectorAll('.nav-links a');
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            if (navLinks.classList.contains('active')) {
                mobileMenuButton.classList.remove('active');
                navLinks.classList.remove('active');
            }
        });
    });
    
    // Gestion des messages flash
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 500);
        }, 5000);
    });
    
    // Confirmation avant suppression
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.')) {
                e.preventDefault();
            }
        });
    });
});

/**
 * Affiche un message de notification
 * @param {string} message - Le message à afficher
 * @param {string} type - Le type de message (success, error, warning, info)
 */
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 100);
    
    // Disparaît après 5 secondes
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-100%)';
        
        // Supprime l'élément après l'animation
        setTimeout(() => {
            notification.remove();
        }, 500);
    }, 5000);
}

/**
 * Met en surbrillance un champ de formulaire invalide
 * @param {HTMLElement} input - L'élément input à mettre en surbrillance
 */
function highlightError(input) {
    input.classList.add('is-invalid');
    input.focus();
    
    // Supprime la classe d'erreur après correction
    input.addEventListener('input', function clearError() {
        this.classList.remove('is-invalid');
        this.removeEventListener('input', clearError);
    });
}

/**
 * Gère la soumission des formulaires avec validation
 * @param {string} formSelector - Sélecteur CSS du formulaire
 * @param {Function} callback - Fonction à exécuter si la validation réussit
 */
function handleFormSubmit(formSelector, callback) {
    const form = document.querySelector(formSelector);
    
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        // Réinitialise les erreurs
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        // Validation des champs requis
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                highlightError(input);
            }
        });
        
        // Validation des emails
        const emailInputs = form.querySelectorAll('input[type="email"]');
        emailInputs.forEach(input => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (input.value && !emailRegex.test(input.value)) {
                isValid = false;
                highlightError(input);
                showNotification('Veuillez entrer une adresse email valide', 'error');
            }
        });
        
        // Si le formulaire est valide, exécute le callback
        if (isValid && typeof callback === 'function') {
            callback(form);
        }
    });
}

// Exporte les fonctions pour une utilisation globale
window.App = {
    showNotification,
    highlightError,
    handleFormSubmit
};
