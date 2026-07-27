<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduitController extends Controller
{
    public function index(): View
    {
        $produits = Produit::with('categorie')->get();

        return view('produits.index', compact('produits'));
    }

    public function create(): View
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('produits.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        Produit::create($validated);

        return redirect()->route('produits.index')
                          ->with('success', 'Produit créé avec succès.');
    }

    public function show(Produit $produit): View
    {
        $produit->load('categorie', 'acheteurs');

        return view('produits.show', compact('produit'));
    }

    public function edit(Produit $produit): View
    {
        $categories = Categorie::orderBy('nom')->get();

        return view('produits.edit', compact('produit', 'categories'));
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit->update($validated);

        return redirect()->route('produits.index')
                          ->with('success', 'Produit modifié avec succès.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $produit->delete();

        return redirect()->route('produits.index')
                          ->with('success', 'Produit supprimé avec succès.');
    }
}