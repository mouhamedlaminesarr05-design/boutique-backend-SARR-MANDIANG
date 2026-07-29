<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $acheteur->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <p><strong>Email :</strong> {{ $acheteur->email }}</p>
                <p><strong>Téléphone :</strong> {{ $acheteur->telephone ?? 'Non renseigné' }}</p>
            </div>

            <!-- Formulaire d'enregistrement d'un achat -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Enregistrer un nouvel achat</h3>

                <form action="{{ route('achats.store', $acheteur) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="produit_id" value="Produit" />
                        <select id="produit_id" name="produit_id" required
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Choisir un produit --</option>
                            @foreach ($produits as $produit)
                                <option value="{{ $produit->id }}" {{ old('produit_id') == $produit->id ? 'selected' : '' }}>
                                    {{ $produit->nom }} ({{ number_format($produit->prix, 0, ',', ' ') }} FCFA)
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('produit_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantite" value="Quantité" />
                        <x-text-input id="quantite" name="quantite" type="number" min="1" class="block mt-1 w-full" value="{{ old('quantite', 1) }}" required />
                        <x-input-error :messages="$errors->get('quantite')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="date_achat" value="Date de l'achat" />
                        <x-text-input id="date_achat" name="date_achat" type="date" class="block mt-1 w-full" value="{{ old('date_achat', date('Y-m-d')) }}" required />
                        <x-input-error :messages="$errors->get('date_achat')" class="mt-2" />
                    </div>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        Enregistrer l'achat
                    </button>
                </form>
            </div>

            <!-- Historique des achats -->
            <h3 class="text-lg font-semibold mb-2">Historique des achats</h3>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($acheteur->achats as $achat)
                            <tr>
                                <td class="px-6 py-4">{{ $achat->produit->nom }}</td>
                                <td class="px-6 py-4">{{ $achat->quantite }}</td>
                                <td class="px-6 py-4">{{ $achat->date_achat->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Aucun achat enregistré.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <a href="{{ route('acheteurs.index') }}" class="inline-block mt-4 text-indigo-600 hover:underline">← Retour à la liste</a>
        </div>
    </div>
</x-app-layout>