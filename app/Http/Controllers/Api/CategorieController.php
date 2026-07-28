<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Catégories", description: "Gestion des catégories de produits")]
class CategorieController extends Controller
{
    #[OA\Get(
        path: "/categories",
        summary: "Lister toutes les catégories",
        security: [["sanctum" => []]],
        tags: ["Catégories"],
        responses: [
            new OA\Response(response: 200, description: "Liste des catégories"),
            new OA\Response(response: 401, description: "Non authentifié"),
        ]
    )]
    public function index(): JsonResponse
    {
        $categories = Categorie::withCount('produits')->get();

        return response()->json($categories);
    }

    #[OA\Post(
        path: "/categories",
        summary: "Créer une nouvelle catégorie",
        security: [["sanctum" => []]],
        tags: ["Catégories"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Chaussures"),
                    new OA\Property(property: "description", type: "string", example: "Toutes les chaussures de sport"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Catégorie créée"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé (réservé gestionnaire/admin)"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom',
            'description' => 'nullable|string',
        ]);

        $categorie = Categorie::create($validated);

        return response()->json($categorie, 201);
    }

    #[OA\Get(
        path: "/categories/{id}",
        summary: "Afficher le détail d'une catégorie (avec ses produits)",
        security: [["sanctum" => []]],
        tags: ["Catégories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail de la catégorie"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 404, description: "Catégorie introuvable"),
        ]
    )]
    public function show(Categorie $categorie): JsonResponse
    {
        $categorie->load('produits');

        return response()->json($categorie);
    }

    #[OA\Put(
        path: "/categories/{id}",
        summary: "Modifier une catégorie",
        security: [["sanctum" => []]],
        tags: ["Catégories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Chaussures de sport"),
                    new OA\Property(property: "description", type: "string", example: "Description mise à jour"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Catégorie modifiée"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Catégorie introuvable"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255|unique:categories,nom,' . $categorie->id,
            'description' => 'nullable|string',
        ]);

        $categorie->update($validated);

        return response()->json($categorie);
    }

    #[OA\Delete(
        path: "/categories/{id}",
        summary: "Supprimer une catégorie",
        security: [["sanctum" => []]],
        tags: ["Catégories"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 204, description: "Catégorie supprimée"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Catégorie introuvable"),
        ]
    )]
    public function destroy(Categorie $categorie): JsonResponse
    {
        $categorie->delete();

        return response()->json(null, 204);
    }
}