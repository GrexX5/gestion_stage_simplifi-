# Gestion des Conventions de Stage

## Table des matières
1. [Introduction](#introduction)
2. [Workflow des Conventions](#workflow-des-conventions)
3. [Modèle de Données](#modèle-de-données)
4. [Contrôleur](#contrôleur)
5. [Vues](#vues)
6. [Validation](#validation)
7. [Sécurité](#sécurité)
8. [Tests](#tests)

## Introduction

Le module de gestion des conventions permet de gérer le cycle de vie complet d'une convention de stage, de sa création à sa validation finale par les différentes parties prenantes (étudiant, entreprise, enseignant).

## Workflow des Conventions

1. **Création** : Une convention est créée automatiquement lors de la création d'une candidature
2. **Étapes de validation** :
   - Validation par l'enseignant référent
   - Validation par l'entreprise
   - Validation finale par l'administration
3. **États possibles** :
   - `pending` : En attente de validation
   - `teacher_validated` : Validée par l'enseignant
   - `company_validated` : Validée par l'entreprise
   - `validated` : Convention finalisée
   - `rejected` : Convention refusée

## Modèle de Données

### Convention

```php
class Convention extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'document',
        'teacher_validated',
        'company_validated',
        'teacher_validation_date',
        'company_validation_date',
        'rejection_reason'
    ];

    protected $casts = [
        'teacher_validated' => 'boolean',
        'company_validated' => 'boolean',
        'teacher_validation_date' => 'datetime',
        'company_validation_date' => 'datetime'
    ];

    // Relations
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
```

## Contrôleur

### Méthodes principales

1. **index()** : Liste les conventions selon le rôle de l'utilisateur
2. **show($id)** : Affiche les détails d'une convention
3. **validateByTeacher(Request $request, $id)** : Validation par l'enseignant
4. **validateByCompany(Request $request, $id)** : Validation par l'entreprise
5. **downloadDocument($id)** : Téléchargement du document de convention

## Vues

### Liste des conventions (`conventions/index.blade.php`)
- Affichage des conventions avec leur statut
- Filtres par statut
- Actions disponibles selon le rôle

### Détail d'une convention (`conventions/show.blade.php`)
- Informations détaillées
- Historique des validations
- Boutons d'action (valider/refuser) selon les droits
- Zone de commentaires

## Validation

### Règles de validation

```php
$request->validate([
    'validation' => 'required|boolean',
    'comments' => 'nullable|string|max:1000',
    'document' => 'sometimes|required|file|mimes:pdf,doc,docx|max:5120'
]);
```

## Sécurité

### Middleware
- `auth` : Authentification requise
- `role:teacher` : Accès réservé aux enseignants
- `role:company` : Accès réservé aux entreprises
- `can:validate,convention` : Vérifie les droits de validation

### Politiques
- `ConventionPolicy` : Définit les autorisations pour chaque action

## Tests

### Scénarios à tester
1. Création d'une convention
2. Validation par l'enseignant
3. Validation par l'entreprise
4. Téléchargement des documents
5. Gestion des erreurs et validations

### Exemple de test

```php
public function test_teacher_can_validate_convention()
{
    $teacher = User::factory()->create(['role' => 'teacher']);
    $convention = Convention::factory()->create();

    $response = $this->actingAs($teacher)
        ->post(route('conventions.validate.teacher', $convention), [
            'validation' => true,
            'comments' => 'Convention approuvée'
        ]);

    $response->assertRedirect();
    $this->assertTrue($convention->fresh()->teacher_validated);
}
```

## Bonnes Pratiques

1. Toujours vérifier les autorisations avant chaque action
2. Journaliser les actions importantes
3. Utiliser des événements pour les changements d'état
4. Valider rigoureusement les entrées utilisateur
5. Fournir des messages d'erreur clairs et précis

## Développement Futur

1. Notifications par email pour les changements d'état
2. Génération automatique des documents PDF
3. Signature électronique
4. Tableau de bord de suivi des conventions
5. Rappels automatiques pour les validations en attente
