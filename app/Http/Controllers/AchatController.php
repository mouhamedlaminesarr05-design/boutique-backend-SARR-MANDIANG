<?php

namespace App\Http\Controllers;

use App\Models\Acheteur;
use App\Models\Achat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function store(Request $request, Acheteur $acheteur): RedirectResponse
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'required|date',
        ]);

        Achat::create([
            'acheteur_id' => $acheteur->id,
            'produit_id' => $validated['produit_id'],
            'quantite' => $validated['quantite'],
            'date_achat' => $validated['date_achat'],
        ]);

        return redirect()->route('acheteurs.show', $acheteur)
                          ->with('success', 'Achat enregistré avec succès.');
    }
}