<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenue Dans SAMA-BOUTIQUE
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-10 text-center">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">SAMA-BOUTIQUE</h1>
                <p class="text-gray-600 mb-8">
                    Application de gestion de catégories, produits et acheteurs.
                </p>

                <div class="flex justify-center gap-4 flex-wrap">
                    @auth
                        <a href="{{ route('produits.index') }}"
                           class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Voir les produits
                        </a>
                        <a href="{{ route('dashboard') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Créer un compte
                        </a>
                        <a href="{{ route('produits.index') }}"
                           class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50">
                            Voir le catalogue
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</x-app-layout>