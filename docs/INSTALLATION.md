# Guide d'Installation et de Configuration

## Prérequis

- PHP 8.2 ou supérieur
- Composer (dernière version)
- Node.js 16+ et NPM
- Base de données (MySQL 8.0+ recommandé)
- Serveur web (Apache/Nginx)
- Git

## Installation

### 1. Clonage du dépôt

```bash
git clone [URL_DU_REPO] gestion_stage_simplifi-
cd gestion_stage_simplifi-
```

### 2. Installation des dépendances PHP

```bash
composer install --optimize-autoloader --no-dev
```

### 3. Installation des dépendances JavaScript

```bash
npm install
npm run build
```

### 4. Configuration de l'environnement

1. Copier le fichier `.env.example` vers `.env` :
   ```bash
   cp .env.example .env
   ```

2. Générer une clé d'application :
   ```bash
   php artisan key:generate
   ```

3. Configurer la base de données dans `.env` :
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nom_de_la_base
   DB_USERNAME=utilisateur
   DB_PASSWORD=secret
   ```

### 5. Configuration du stockage

1. Créer un lien symbolique pour le stockage public :
   ```bash
   php artisan storage:link
   ```

2. Assurez-vous que les dossiers suivants sont accessibles en écriture :
   - `storage/`
   - `bootstrap/cache/`
   - `public/storage`

### 6. Migration et remplissage de la base de données

```bash
php artisan migrate --seed
```

### 7. Configuration du planificateur de tâches (optionnel)

Ajoutez cette ligne à votre crontab :

```
* * * * * cd /chemin/vers/votre/projet && php artisan schedule:run >> /dev/null 2>&1
```

## Configuration du serveur web

### Apache

Assurez-vous que le module `mod_rewrite` est activé et ajoutez ceci à votre configuration :

```apache
<Directory "/chemin/vers/votre/projet/public">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

### Nginx

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /chemin/vers/votre/projet/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Configuration des mails

Modifiez la section mail dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Configuration du cache

Pour de meilleures performances, activez le cache des vues et des routes :

```bash
php artisan view:cache
php artisan route:cache
php artisan config:cache
```

## Création d'un utilisateur administrateur

Exécutez la commande suivante et suivez les instructions :

```bash
php artisan make:admin
```

## Vérification de l'installation

1. Lancez le serveur de développement :
   ```bash
   php artisan serve
   ```

2. Ouvrez votre navigateur à l'adresse : `http://localhost:8000`

3. Connectez-vous avec les identifiants de l'administrateur créé

## Mise à jour

Pour mettre à jour l'application :

```bash
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan view:cache
php artisan route:cache
php artisan config:cache
```

## Dépannage

### Erreurs de permissions

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/framework/
chown -R $USER:www-data storage bootstrap/cache
```

### Effacer le cache

```bash
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

## Environnements

- **Développement** : `.env` avec `APP_DEBUG=true`
- **Production** : `.env` avec `APP_DEBUG=false` et `APP_ENV=production`

## Sécurité en production

1. Mettez à jour `APP_KEY` avec une nouvelle clé
2. Définissez `APP_DEBUG=false`
3. Configurez HTTPS
4. Mettez à jour les dépendances régulièrement
5. Configurez une sauvegarde automatique de la base de données
