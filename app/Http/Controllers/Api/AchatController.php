<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acheteur;
use App\Models\Achat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AchatController extends Controller
{
    public function store(Request $request, Acheteur $acheteur): JsonResponse
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'date_achat' => 'required|date',
        ]);

        $achat = Achat::create([
            'acheteur_id' => $acheteur->id,
            'produit_id' => $validated['produit_id'],
            'quantite' => $validated['quantite'],
            'date_achat' => $validated['date_achat'],
        ]);

        $achat->load('produit');

        return response()->json($achat, 201);
    }
}