<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Acheteurs
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (auth()->user()->role === 'gestionnaire' || auth()->user()->role === 'admin')
                <a href="{{ route('acheteurs.create') }}"
                   class="inline-block mb-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                    + Nouvel acheteur
                </a>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Achats</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($acheteurs as $acheteur)
                            <tr>
                                <td class="px-6 py-4">{{ $acheteur->nom }}</td>
                                <td class="px-6 py-4">{{ $acheteur->email }}</td>
                                <td class="px-6 py-4">{{ $acheteur->achats_count }}</td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('acheteurs.show', $acheteur) }}" class="text-indigo-600 hover:underline">Voir</a>

                                    @if (auth()->user()->role === 'gestionnaire' || auth()->user()->role === 'admin')
                                        <a href="{{ route('acheteurs.edit', $acheteur) }}" class="text-yellow-600 hover:underline">Modifier</a>

                                        <form action="{{ route('acheteurs.destroy', $acheteur) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Confirmer la suppression ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun acheteur.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>