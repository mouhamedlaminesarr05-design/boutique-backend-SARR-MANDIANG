<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Categorie::withCount('produits')->get();

        return response()->json($categories);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::create($validated);

        return response()->json($categorie, 201);
    }

    public function show(Categorie $categorie): JsonResponse
    {
        $categorie->load('produits');

        return response()->json($categorie);
    }

    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
        ]);

        $categorie->update($validated);

        return response()->json($categorie);
    }

    public function destroy(Categorie $categorie): JsonResponse
    {
        $categorie->delete();

        return response()->json(null, 204);
    }
}