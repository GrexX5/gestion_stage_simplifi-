# Gestion des Stages Simplifiée

## Description
Application de gestion des stages permettant aux étudiants de trouver des offres de stage, de postuler et de gérer leurs conventions de stage. Les entreprises peuvent publier des offres et gérer les candidatures, tandis que les enseignants peuvent suivre et valider les conventions.

## Fonctionnalités principales

### Pour les Étudiants
- Consultation des offres de stage
- Candidature en ligne
- Suivi de l'état des candidatures
- Gestion des conventions de stage
- Téléchargement des documents

### Pour les Entreprises
- Publication d'offres de stage
- Gestion des candidatures
- Validation des conventions
- Profil d'entreprise

### Pour les Enseignants
- Validation des conventions
- Suivi des stages
- Tableau de bord de suivi

## Prérequis

- PHP 8.2 ou supérieur
- Composer
- Base de données (MySQL/PostgreSQL/SQLite)
- Node.js et NPM (pour les assets frontend)

## Installation

1. Cloner le dépôt :
   ```bash
   git clone [URL_DU_REPO]
   cd gestion_stage_simplifi-
   ```

2. Installer les dépendances PHP :
   ```bash
   composer install
   ```

3. Installer les dépendances JavaScript :
   ```bash
   npm install
   npm run dev
   ```

4. Copier le fichier d'environnement :
   ```bash
   cp .env.example .env
   ```

5. Générer la clé d'application :
   ```bash
   php artisan key:generate
   ```

6. Configurer la base de données dans le fichier `.env`

7. Exécuter les migrations et les seeders :
   ```bash
   php artisan migrate --seed
   ```

8. Démarrer le serveur de développement :
   ```bash
   php artisan serve
   ```

## Structure du Projet

```
app/
├── Http
│   ├── Controllers/    # Contrôleurs de l'application
│   └── Middleware/     # Middleware personnalisés
├── Models/             # Modèles Eloquent
├── Services/           # Logique métier
resources/
├── views/             # Vues Blade
├── js/                # Fichiers JavaScript
└── scss/              # Fichiers SCSS
routes/
├── web.php            # Routes web
└── api.php            # Routes API
database/
├── migrations/        # Migrations de base de données
└── seeders/           # Données de test
```

## Rôles et Permissions

- **Étudiant** : Peut consulter les offres, postuler, gérer ses candidatures et conventions
- **Entreprise** : Peut publier des offres, gérer les candidatures, valider les conventions
- **Enseignant** : Peut valider les conventions, suivre les stages
- **Administrateur** : Gestion complète de l'application

## Sécurité

- Authentification Laravel
- Protection CSRF
- Validation des données
- Gestion des rôles et permissions

## Contribution

1. Forkez le projet
2. Créez une branche pour votre fonctionnalité
3. Committez vos changements
4. Poussez vers la branche
5. Créez une Pull Request

## Licence

Ce projet est sous licence MIT.

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
