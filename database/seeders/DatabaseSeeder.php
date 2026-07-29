<?php

namespace Database\Seeders;

use App\Models\Acheteur;
use App\Models\Achat;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Comptes de test (les 3 rôles)
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $gestionnaire = User::create([
            'name' => 'Gestionnaire',
            'email' => 'gestionnaire@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'gestionnaire',
        ]);

        $employe = User::create([
            'name' => 'Employe',
            'email' => 'employe@boutique.com',
            'password' => Hash::make('password123'),
            'role' => 'employe',
        ]);

        // Catégories
        $vetements = Categorie::create([
            'nom' => 'Vêtements',
            'description' => 'Tenues et articles vestimentaires',
        ]);

        $chaussures = Categorie::create([
            'nom' => 'Chaussures',
            'description' => 'Chaussures de sport et de ville',
        ]);

        // Produits
       // Produits
        $produit1 = Produit::create([
            'nom' => 'T-shirt Nike',
            'prix' => 12000,
            'stock' => 150,
            'description' => 'T-shirt 100% coton, coupe classique',
            'categorie_id' => $vetements->id,
        ]);

        $produit2 = Produit::create([
            'nom' => 'Short de sport',
            'prix' => 2500,
            'stock' => 80,
            'description' => 'Short léger et respirant',
            'categorie_id' => $vetements->id,
        ]);

        $produit3 = Produit::create([
            'nom' => 'Baskets Adidas',
            'prix' => 35000,
            'stock' => 40,
            'description' => 'Baskets running, semelle amortissante',
            'categorie_id' => $chaussures->id,
        ]);

        // Acheteurs
        $acheteur1 = Acheteur::create([
            'nom' => 'awa gueye',
            'email' => 'gueyeawa@example.com',
            'telephone' => '771234567',
        ]);

        $acheteur2 = Acheteur::create([
            'nom' => 'sadio mane',
            'email' => 'sadio.mane@example.com',
            'telephone' => '772345678',
        ]);

        // Achats
        Achat::create([
            'acheteur_id' => $acheteur1->id,
            'produit_id' => $produit1->id,
            'quantite' => 2,
            'date_achat' => now()->subDays(5),
        ]);

        Achat::create([
            'acheteur_id' => $acheteur2->id,
            'produit_id' => $produit3->id,
            'quantite' => 1,
            'date_achat' => now()->subDays(2),
        ]);
    }
}