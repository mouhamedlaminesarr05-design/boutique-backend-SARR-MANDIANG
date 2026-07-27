<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acheteur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcheteurController extends Controller
{
    public function index(): JsonResponse
    {
        $acheteurs = Acheteur::withCount('achats')->get();

        return response()->json($acheteurs);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email',
            'telephone' => 'nullable|string|max:20',
        ]);

        $acheteur = Acheteur::create($validated);

        return response()->json($acheteur, 201);
    }

    public function show(Acheteur $acheteur): JsonResponse
    {
        $acheteur->load('achats.produit');

        return response()->json($acheteur);
    }

    public function update(Request $request, Acheteur $acheteur): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:acheteurs,email,' . $acheteur->id,
            'telephone' => 'nullable|string|max:20',
        ]);

        $acheteur->update($validated);

        return response()->json($acheteur);
    }

    public function destroy(Acheteur $acheteur): JsonResponse
    {
        $acheteur->delete();

        return response()->json(null, 204);
    }
}