<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $categorie->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <p class="text-gray-600">{{ $categorie->description ?? 'Aucune description.' }}</p>
            </div>

            <h3 class="text-lg font-semibold mb-2">Produits de cette catégorie</h3>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($categorie->produits as $produit)
                            <tr>
                                <td class="px-6 py-4">{{ $produit->nom }}</td>
                                <td class="px-6 py-4">{{ number_format($produit->prix, 0, ',', ' ') }} FCFA</td>
                                <td class="px-6 py-4">{{ $produit->stock }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun produit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('categories.index') }}" class="inline-block mt-4 text-indigo-600 hover:underline">← Retour à la liste</a>
        </div>
    </div>
</x-app-layout>