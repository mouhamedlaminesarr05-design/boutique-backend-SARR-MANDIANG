<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index(): JsonResponse
    {
        $produits = Produit::with('categorie')->get();

        return response()->json($produits);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit = Produit::create($validated);
        $produit->load('categorie');

        return response()->json($produit, 201);
    }

    public function show(Produit $produit): JsonResponse
    {
        $produit->load('categorie', 'acheteurs');

        return response()->json($produit);
    }

    public function update(Request $request, Produit $produit): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit->update($validated);
        $produit->load('categorie');

        return response()->json($produit);
    }

    public function destroy(Produit $produit): JsonResponse
    {
        $produit->delete();

        return response()->json(null, 204);
    }
}