<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acheteur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Acheteurs", description: "Gestion des acheteurs")]
class AcheteurController extends Controller
{
    #[OA\Get(
        path: "/acheteurs",
        summary: "Lister tous les acheteurs",
        security: [["sanctum" => []]],
        tags: ["Acheteurs"],
        responses: [
            new OA\Response(response: 200, description: "Liste des acheteurs"),
            new OA\Response(response: 401, description: "Non authentifié"),
        ]
    )]
    public function index(): JsonResponse
    {
        $acheteurs = Acheteur::withCount('achats')->get();

        return response()->json($acheteurs);
    }

    #[OA\Post(
        path: "/acheteurs",
        summary: "Créer un nouvel acheteur",
        security: [["sanctum" => []]],
        tags: ["Acheteurs"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "email"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Fatou Diop"),
                    new OA\Property(property: "email", type: "string", example: "fatou.diop@example.com"),
                    new OA\Property(property: "telephone", type: "string", example: "771234567"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Acheteur créé"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé (réservé gestionnaire/admin)"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
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

    #[OA\Get(
        path: "/acheteurs/{id}",
        summary: "Afficher le détail d'un acheteur (avec son historique d'achats)",
        security: [["sanctum" => []]],
        tags: ["Acheteurs"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 200, description: "Détail de l'acheteur"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 404, description: "Acheteur introuvable"),
        ]
    )]
    public function show(Acheteur $acheteur): JsonResponse
    {
        $acheteur->load('achats.produit');

        return response()->json($acheteur);
    }

    #[OA\Put(
        path: "/acheteurs/{id}",
        summary: "Modifier un acheteur",
        security: [["sanctum" => []]],
        tags: ["Acheteurs"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "email"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Fatou Diop Ndiaye"),
                    new OA\Property(property: "email", type: "string", example: "fatou.ndiaye@example.com"),
                    new OA\Property(property: "telephone", type: "string", example: "771234567"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Acheteur modifié"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Acheteur introuvable"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
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

    #[OA\Delete(
        path: "/acheteurs/{id}",
        summary: "Supprimer un acheteur",
        security: [["sanctum" => []]],
        tags: ["Acheteurs"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer")),
        ],
        responses: [
            new OA\Response(response: 204, description: "Acheteur supprimé"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 403, description: "Accès non autorisé"),
            new OA\Response(response: 404, description: "Acheteur introuvable"),
        ]
    )]
    public function destroy(Acheteur $acheteur): JsonResponse
    {
        $acheteur->delete();

        return response()->json(null, 204);
    }
}