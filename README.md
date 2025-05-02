# INTIA - Système de Gestion de client et d'Assurance

## Prérequis

-   PHP 8.1 ou supérieur
-   Composer
-   MySQL 5.7 ou supérieur
-   Node.js et NPM
-   Git

## Installation

1. **Cloner le projet**

```bash
git clone [URL_DU_REPO]
cd intia
```

2. **Installer les dépendances PHP**

```bash
composer install
```

3. **Copier le fichier d'environnement**

```bash
cp .env.example .env
```

4. **Configurer la base de données**
   Ouvrir le fichier `.env` et modifier les paramètres suivants :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=intia
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

5. **Générer la clé d'application**

```bash
php artisan key:generate
```

6. **Exécuter les migrations et les seeders**

```bash
php artisan migrate --seed
```

7. **Installer les dépendances NPM**

```bash
npm install
```

8. **Compiler les assets**

```bash
npm run dev
```

## Configuration des rôles

L'application utilise Spatie Laravel Permissions. Les rôles sont créés automatiquement lors de l'exécution des seeders.

Rôles disponibles :

-   Admin : Accès complet à toutes les fonctionnalités
-   Agent : Accès limité aux fonctionnalités de sa branche

## Données de test

Les seeders créent les données suivantes :

-   1 administrateur (email: admin@intia.com, mot de passe: password)
-   3 branches
-   5 agents (1 par branche, emails: agent1@intia.com à agent5@intia.com, mot de passe: password)
-   10 clients par branche
-   5 types d'assurance
-   3 polices d'assurance par client

## Démarrage du serveur

```bash
php artisan serve
```

L'application sera accessible à l'adresse : http://localhost:8000

## Tests

Pour exécuter les tests :

```bash
php artisan test
```

## Fonctionnalités principales

-   Gestion des branches
-   Gestion des clients
-   Gestion des types d'assurance
-   Gestion des polices d'assurance
-   Tableau de bord avec statistiques

## Structure des dossiers

```
app/
├── Http/
│   ├── Controllers/
│   └── Middleware/
├── Models/
├── Policies/
└── Services/

database/
├── factories/
├── migrations/
└── seeders/

resources/
├── views/
│   ├── layouts/
│   ├── components/
│   └── [autres vues]
└── js/

tests/
└── Feature/
```

## Dépendances principales

-   Laravel 10.x
-   Spatie Laravel Permissions
-   Tailwind CSS
-   Alpine.js
-   Laravel Sanctum

## Support

Pour toute question ou problème, veuillez contacter l'équipe de développement.
By MBIDA NDANGA Jacques Stephan
