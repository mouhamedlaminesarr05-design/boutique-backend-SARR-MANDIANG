<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Produits", description: "Gestion des produits du catalogue")]
class ProduitController extends Controller
{
    #[OA\Get(
        path: "/produits",
        summary: "Lister tous les produits (accessible sans connexion)",
        tags: ["Produits"],
        responses: [
            new OA\Response(response: 200, description: "Liste des produits, avec leur catégorie"),
        ]
    )]
    public function index(): JsonResponse
    {
        $produits = Produit::with('categorie')->get();

        return response()->json($produits);
    }

    #[OA\Post(
        path: "/produits",
        summary: "Créer un nouveau produit",
        security: [["sanctum" => []]],
        tags: ["Produits"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "prix", "stock", "categorie_id"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "T-shirt Nike"),
                    new OA\Property(property: "prix", type: "number", format: "float", example: 29.99),
                    new OA\Property(property: "stock", type: "integer", example: 100),
                    new OA\Property(property: "description", type: "string", example: "T-shirt 100% coton"),
                    new OA\Property(property: "categorie_id", type: "integer", example: 1),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Produit créé"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé (réservé gestionnaire/admin)"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
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

    #[OA\Get(
        path: "/produits/{id}",
        summary: "Afficher le détail d'un produit (avec sa catégorie et ses acheteurs)",
        tags: ["Produits"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail du produit"),
            new OA\Response(response: 404, description: "Produit introuvable"),
        ]
    )]
    public function show(Produit $produit): JsonResponse
    {
        $produit->load('categorie', 'acheteurs');

        return response()->json($produit);
    }

    #[OA\Put(
        path: "/produits/{id}",
        summary: "Modifier un produit",
        security: [["sanctum" => []]],
        tags: ["Produits"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "prix", "stock", "categorie_id"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "T-shirt Nike Pro"),
                    new OA\Property(property: "prix", type: "number", format: "float", example: 34.99),
                    new OA\Property(property: "stock", type: "integer", example: 80),
                    new OA\Property(property: "description", type: "string", example: "Version mise à jour"),
                    new OA\Property(property: "categorie_id", type: "integer", example: 1),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Produit modifié"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Produit introuvable"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
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

    #[OA\Delete(
        path: "/produits/{id}",
        summary: "Supprimer un produit",
        security: [["sanctum" => []]],
        tags: ["Produits"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 204, description: "Produit supprimé"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Produit introuvable"),
        ]
    )]
    public function destroy(Produit $produit): JsonResponse
    {
        $produit->delete();

        return response()->json(null, 204);
    }
}