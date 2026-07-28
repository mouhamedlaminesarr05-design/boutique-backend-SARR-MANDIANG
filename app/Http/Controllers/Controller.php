<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API Gestion de boutique",
    description: "Documentation de l'API REST pour la gestion de boutique (catégories, produits, acheteurs, achats). CCP 2026."
)]
#[OA\Server(
    url: "http://127.0.0.1:8000/api",
    description: "Serveur de développement local"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "Sanctum token",
    description: "Entrez le token obtenu via /login, sans le mot 'Bearer' devant (Swagger l'ajoute automatiquement)."
)]
abstract class Controller
{
    //
}