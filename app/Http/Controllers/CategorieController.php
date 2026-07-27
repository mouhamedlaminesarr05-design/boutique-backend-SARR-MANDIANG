<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategorieController extends Controller
{
    public function index(): View
    {
        $categories = Categorie::withCount('produits')->get();

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        Categorie::create($validated);

        return redirect()->route('categories.index')
                          ->with('success', 'Catégorie créée avec succès.');
    }

    public function show(Categorie $categorie): View
    {
        $categorie->load('produits');

        return view('categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie): View
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
        ]);

        $categorie->update($validated);

        return redirect()->route('categories.index')
                          ->with('success', 'Catégorie modifiée avec succès.');
    }

    public function destroy(Categorie $categorie): RedirectResponse
    {
        $categorie->delete();

        return redirect()->route('categories.index')
                          ->with('success', 'Catégorie supprimée avec succès.');
    }
}