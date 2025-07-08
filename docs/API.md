# Documentation de l'API

## Table des matières
1. [Authentification](#authentification)
2. [Endpoints](#endpoints)
   - [Offres de Stage](#offres-de-stage)
   - [Candidatures](#candidatures)
   - [Conventions](#conventions)
   - [Utilisateurs](#utilisateurs)
3. [Format des réponses](#format-des-réponses)
4. [Codes d'erreur](#codes-derreur)
5. [Pagination](#pagination)
6. [Filtres](#filtres)
7. [Exemples](#exemples)

## Authentification

L'API utilise l'authentification par token JWT. Pour s'authentifier :

1. Faire une requête POST à `/api/auth/login` avec email et mot de passe
2. Utiliser le token reçu dans le header `Authorization: Bearer {token}`

## Endpoints

### Offres de Stage

#### Liste des offres
```
GET /api/internships
```

#### Détails d'une offre
```
GET /api/internships/{id}
```

#### Créer une offre (Entreprise)
```
POST /api/internships
```

### Candidatures

#### Lister les candidatures
```
GET /api/applications
```

#### Postuler à une offre (Étudiant)
```
POST /api/internships/{id}/apply
```

### Conventions

#### Liste des conventions
```
GET /api/conventions
```

#### Valider une convention (Enseignant/Entreprise)
```
POST /api/conventions/{id}/validate
```

## Format des réponses

### Succès
```json
{
    "success": true,
    "data": {
        // Données de la ressource
    },
    "message": "Opération réussie"
}
```

### Erreur
```json
{
    "success": false,
    "message": "Description de l'erreur",
    "errors": {
        "champ": ["Message d'erreur"]
    }
}
```

## Codes d'erreur

- 200 : Succès
- 201 : Créé avec succès
- 400 : Requête incorrecte
- 401 : Non autorisé
- 403 : Accès refusé
- 404 : Ressource non trouvée
- 422 : Erreur de validation
- 500 : Erreur serveur

## Pagination

Les listes sont paginées par défaut (15 éléments par page)

### Paramètres
- `page` : Numéro de page (par défaut: 1)
- `per_page` : Nombre d'éléments par page (max: 100)

### Réponse paginée
```json
{
    "data": [],
    "links": {
        "first": "http://...?page=1",
        "last": "http://...?page=5",
        "prev": null,
        "next": "http://...?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 5,
        "path": "http://...",
        "per_page": 15,
        "to": 15,
        "total": 75
    }
}
```

## Filtres

### Offres de stage
- `company_id` : Filtrer par entreprise
- `status` : Filtrer par statut
- `title` : Recherche dans le titre
- `location` : Localisation

### Candidatures
- `student_id` : Étudiant
- `internship_id` : Offre de stage
- `status` : Statut de la candidature

## Exemples

### Créer une offre de stage
```http
POST /api/internships
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "Développeur Full Stack",
    "description": "Description du poste...",
    "location": "Paris",
    "duration": "6 mois",
    "start_date": "2023-09-01",
    "end_date": "2024-02-28",
    "remuneration": 600,
    "skills_required": ["PHP", "JavaScript", "Laravel", "Vue.js"]
}
```

### Valider une convention
```http
POST /api/conventions/42/validate
Authorization: Bearer {token}
Content-Type: application/json

{
    "validated": true,
    "comments": "Convention approuvée"
}
```

## Sécurité

- Tous les endpoints nécessit une authentification
- Utilisation de HTTPS obligatoire
- Protection contre les attaques CSRF
- Validation des entrées
- Rate limiting (100 requêtes/minute par IP)

## Versioning

L'API est versionnée. La version actuelle est v1.

```
/api/v1/ressources
```

## Support

Pour toute question ou problème, veuillez contacter l'équipe technique à support@votredomaine.com
