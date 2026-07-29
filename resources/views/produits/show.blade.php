<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $produit->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <p><strong>Catégorie :</strong> {{ $produit->categorie->nom }}</p>
                <p><strong>Prix :</strong> {{ number_format($produit->prix, 0, ',', ' ') }} FCFA</p>
                <p><strong>Stock :</strong> {{ $produit->stock }}</p>
                <p class="mt-2">{{ $produit->description ?? 'Aucune description.' }}</p>
            </div>

            <h3 class="text-lg font-semibold mb-2">Acheteurs de ce produit</h3>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acheteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($produit->acheteurs as $acheteur)
                            <tr>
                                <td class="px-6 py-4">{{ $acheteur->nom }}</td>
                                <td class="px-6 py-4">{{ $acheteur->pivot->quantite }}</td>
                                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($acheteur->pivot->date_achat)->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun acheteur pour ce produit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('produits.index') }}" class="inline-block mt-4 text-indigo-600 hover:underline">← Retour à la liste</a>
        </div>
    </div>
</x-app-layout>