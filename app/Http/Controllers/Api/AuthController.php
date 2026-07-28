<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Authentification", description: "Inscription, connexion, déconnexion")]
class AuthController extends Controller
{
    #[OA\Post(
        path: "/register",
        summary: "Créer un compte (rôle employé ou gestionnaire uniquement)",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "role"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Amadou Ba"),
                    new OA\Property(property: "email", type: "string", example: "amadou.ba@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                    new OA\Property(property: "role", type: "string", enum: ["employe", "gestionnaire"], example: "employe"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Compte créé, retourne l'utilisateur et son token"),
            new OA\Response(response: 422, description: "Erreur de validation"),
        ]
    )]
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:employe,gestionnaire',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    #[OA\Post(
        path: "/login",
        summary: "Se connecter et obtenir un token",
        tags: ["Authentification"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", example: "admin@boutique.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Connexion réussie, retourne l'utilisateur et son token"),
            new OA\Response(response: 422, description: "Identifiants incorrects"),
        ]
    )]
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiants incorrects.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    #[OA\Post(
        path: "/logout",
        summary: "Se déconnecter (invalide le token actuel)",
        security: [["sanctum" => []]],
        tags: ["Authentification"],
        responses: [
            new OA\Response(response: 200, description: "Déconnexion réussie"),
            new OA\Response(response: 401, description: "Non authentifié"),
        ]
    )]
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie.',
        ]);
    }

    #[OA\Get(
        path: "/me",
        summary: "Récupérer les informations de l'utilisateur connecté",
        security: [["sanctum" => []]],
        tags: ["Authentification"],
        responses: [
            new OA\Response(response: 200, description: "Informations de l'utilisateur"),
            new OA\Response(response: 401, description: "Non authentifié"),
        ]
    )]
    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}