<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Acheteur;
use App\Models\Achat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Achats", description: "Enregistrement des achats")]
class AchatController extends Controller
{
    #[OA\Post(
        path: "/acheteurs/{id}/acheter",
        summary: "Enregistrer un nouvel achat pour un acheteur",
        security: [["sanctum" => []]],
        tags: ["Achats"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", description: "ID de l'acheteur", required: true, schema: new OA\Schema(type: "integer")),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["produit_id", "quantite", "date_achat"],
                properties: [
                    new OA\Property(property: "produit_id", type: "integer", example: 1),
                    new OA\Property(property: "quantite", type: "integer", example: 2),
                    new OA\Property(property: "date_achat", type: "string", format: "date", example: "2026-07-28"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Achat enregistré"),
            new OA\Response(response: 401, description: "Non authentifié"),
            new OA\Response(response: 404, description: "Acheteur introuvable"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
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