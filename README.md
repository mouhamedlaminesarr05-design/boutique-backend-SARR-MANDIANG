# Boutique — Backend (Laravel)

Backend de l'application de gestion de boutique : administration des catégories, produits et acheteurs, avec gestion des rôles et une API REST documentée via Swagger.

Projet réalisé dans le cadre de l'examen **CCP 2026 — Gestion de boutique**.

## Auteurs

- Mouhamed Lamine Sarr
- Malang Mandiang

## Stack technique

- Laravel 12
- PHP 8.3
- MySQL
- Blade + Tailwind CSS (Laravel Breeze)
- Laravel Sanctum (authentification API par token)
- L5-Swagger (documentation API)

## Fonctionnalités

- Authentification (inscription, connexion, déconnexion)
- Gestion des rôles : `employe`, `gestionnaire`, `admin`
- CRUD Catégories, Produits, Acheteurs (selon le rôle)
- Enregistrement d'achats (produit, quantité, date) depuis la fiche acheteur
- Catalogue produits consultable sans connexion (lecture seule)
- API REST complète (`/api`), sécurisée par token (Sanctum)
- Documentation interactive Swagger

## Rôles et permissions

| Fonctionnalité | Non connecté | Employé | Gestionnaire | Admin |
|---|---|---|---|---|
| Consulter la page d'accueil | ✅ | ✅ | ✅ | ✅ |
| Consulter le catalogue produits | ✅ | ✅ | ✅ | ✅ |
| Consulter les catégories | ❌ | ✅ | ✅ | ✅ |
| Consulter les acheteurs | ❌ | ✅ | ✅ | ✅ |
| Enregistrer un achat | ❌ | ✅ | ✅ | ✅ |
| Créer / modifier / supprimer une catégorie | ❌ | ❌ | ✅ | ✅ |
| Créer / modifier / supprimer un produit | ❌ | ❌ | ✅ | ✅ |
| Créer / modifier / supprimer un acheteur | ❌ | ❌ | ✅ | ✅ |
| Gérer les utilisateurs et leurs rôles | ❌ | ❌ | ❌ | ✅ |

## Installation

### Prérequis

- PHP >= 8.2, Composer
- MySQL (ex: via XAMPP)
- Node.js + npm

### Étapes

1. Cloner le dépôt et installer les dépendances

```bash
git clone https://github.com/mouhamedlaminesarr05-design/boutique-backend-SARR-MANDIANG.git
cd boutique-backend-SARR-MANDIANG
composer install
npm install
```

2. Configurer l'environnement

```bash
copy .env.example .env
php artisan key:generate
```

Dans le fichier `.env`, configurer la base de données :

Créer la base `boutique` (ex: via phpMyAdmin).

3. Lancer les migrations et charger les données de démonstration

```bash
php artisan migrate:fresh --seed
```

4. Compiler les assets front

```bash
npm run build
```

5. Générer la documentation Swagger

```bash
php artisan l5-swagger:generate
```

6. Lancer le serveur

```bash
php artisan serve
```

L'application est accessible sur **http://127.0.0.1:8000**

## Comptes de test

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@boutique.com | password123 |
| Gestionnaire | gestionnaire@boutique.com | password123 |
| Employé | employe@boutique.com | password123 |

Le seeder crée également 2 catégories, 3 produits, 2 acheteurs et 2 achats de démonstration.

## URLs utiles

| Ressource | URL |
|---|---|
| Application web | http://127.0.0.1:8000 |
| Connexion | http://127.0.0.1:8000/login |
| Inscription | http://127.0.0.1:8000/register |
| Catégories | http://127.0.0.1:8000/categories |
| Produits | http://127.0.0.1:8000/produits |
| Acheteurs | http://127.0.0.1:8000/acheteurs |
| Documentation API (Swagger) | http://127.0.0.1:8000/api/documentation |
| Base de l'API REST | http://127.0.0.1:8000/api |

## Authentification API

L'API utilise Laravel Sanctum (token Bearer).

1. `POST /api/login` avec `email` et `password` → retourne un `token`
2. Envoyer ce token dans l'en-tête de chaque requête protégée :
   `Authorization: Bearer {token}`

Le catalogue produits (`GET /api/produits`, `GET /api/produits/{id}`) est accessible sans authentification.

