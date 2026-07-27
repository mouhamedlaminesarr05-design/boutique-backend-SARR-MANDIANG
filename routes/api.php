<?php

use App\Http\Controllers\Api\AcheteurController;
use App\Http\Controllers\Api\AchatController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\ProduitController;
use Illuminate\Support\Facades\Route;

// Authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Produits : consultation publique (lecture seule), même sans connexion
Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/{produit}', [ProduitController::class, 'show']);

// Catégories : consultation réservée aux utilisateurs connectés
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CategorieController::class, 'index']);
    Route::get('/categories/{categorie}', [CategorieController::class, 'show']);

    Route::get('/acheteurs', [AcheteurController::class, 'index']);
    Route::get('/acheteurs/{acheteur}', [AcheteurController::class, 'show']);

    // Enregistrer un achat : autorisé à tout utilisateur connecté (employé compris)
    Route::post('/acheteurs/{acheteur}/acheter', [AchatController::class, 'store']);

    // Écriture : réservée aux gestionnaires et admins
    Route::middleware('role:gestionnaire,admin')->group(function () {
        Route::post('/categories', [CategorieController::class, 'store']);
        Route::put('/categories/{categorie}', [CategorieController::class, 'update']);
        Route::patch('/categories/{categorie}', [CategorieController::class, 'update']);
        Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy']);

        Route::post('/produits', [ProduitController::class, 'store']);
        Route::put('/produits/{produit}', [ProduitController::class, 'update']);
        Route::patch('/produits/{produit}', [ProduitController::class, 'update']);
        Route::delete('/produits/{produit}', [ProduitController::class, 'destroy']);

        Route::post('/acheteurs', [AcheteurController::class, 'store']);
        Route::put('/acheteurs/{acheteur}', [AcheteurController::class, 'update']);
        Route::patch('/acheteurs/{acheteur}', [AcheteurController::class, 'update']);
        Route::delete('/acheteurs/{acheteur}', [AcheteurController::class, 'destroy']);
    });
});