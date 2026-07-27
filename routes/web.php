<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\AcheteurController;
use App\Http\Controllers\AchatController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-test', function () {
    return 'Bienvenue admin !';
})->middleware(['auth', 'role:admin'])->name('admin.test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/categories', [CategorieController::class, 'index'])->name('categories.index');

    Route::middleware(['role:gestionnaire,admin'])->group(function () {
        Route::get('/categories/create', [CategorieController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategorieController::class, 'store'])->name('categories.store');
        Route::get('/categories/{categorie}/edit', [CategorieController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{categorie}', [CategorieController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{categorie}', [CategorieController::class, 'destroy'])->name('categories.destroy');
    });

    Route::get('/categories/{categorie}', [CategorieController::class, 'show'])->name('categories.show');
});


Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');

Route::middleware(['auth', 'role:gestionnaire,admin'])->group(function () {
    Route::get('/produits/create', [ProduitController::class, 'create'])->name('produits.create');
    Route::post('/produits', [ProduitController::class, 'store'])->name('produits.store');
    Route::get('/produits/{produit}/edit', [ProduitController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{produit}', [ProduitController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{produit}', [ProduitController::class, 'destroy'])->name('produits.destroy');
});

Route::get('/produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/acheteurs', [AcheteurController::class, 'index'])->name('acheteurs.index');

    Route::middleware(['role:gestionnaire,admin'])->group(function () {
        Route::get('/acheteurs/create', [AcheteurController::class, 'create'])->name('acheteurs.create');
        Route::post('/acheteurs', [AcheteurController::class, 'store'])->name('acheteurs.store');
        Route::get('/acheteurs/{acheteur}/edit', [AcheteurController::class, 'edit'])->name('acheteurs.edit');
        Route::put('/acheteurs/{acheteur}', [AcheteurController::class, 'update'])->name('acheteurs.update');
        Route::delete('/acheteurs/{acheteur}', [AcheteurController::class, 'destroy'])->name('acheteurs.destroy');
    });

    Route::post('/acheteurs/{acheteur}/acheter', [AchatController::class, 'store'])->name('achats.store');

    Route::get('/acheteurs/{acheteur}', [AcheteurController::class, 'show'])->name('acheteurs.show');
});

require __DIR__.'/auth.php';
