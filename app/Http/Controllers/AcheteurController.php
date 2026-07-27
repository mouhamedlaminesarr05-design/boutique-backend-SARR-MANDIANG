<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcheteurController extends Controller
{
    public function index(): View
    {
        $acheteurs = Acheteur::withCount('achats')->get();

        return view('acheteurs.index', compact('acheteurs'));
    }

    public function create(): View
    {
        return view('acheteurs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);

        Acheteur::create($validated);

        return redirect()->route('acheteurs.index')
                          ->with('success', 'Acheteur créé avec succès.');
    }

    public function show(Acheteur $acheteur): View
    {
        $acheteur->load('achats.produit');
        $produits = Produit::orderBy('nom')->get();

        return view('acheteurs.show', compact('acheteur', 'produits'));
    }

    public function edit(Acheteur $acheteur): View
    {
        return view('acheteurs.edit', compact('acheteur'));
    }

    public function update(Request $request, Acheteur $acheteur): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email,' . $acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $acheteur->update($validated);

        return redirect()->route('acheteurs.index')
                          ->with('success', 'Acheteur modifié avec succès.');
    }

    public function destroy(Acheteur $acheteur): RedirectResponse
    {
        $acheteur->delete();

        return redirect()->route('acheteurs.index')
                          ->with('success', 'Acheteur supprimé avec succès.');
    }
}