<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nouvel acheteur
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('acheteurs.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="nom" value="Nom" />
                        <x-text-input id="nom" name="nom" type="text" class="block mt-1 w-full" value="{{ old('nom') }}" required autofocus />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="block mt-1 w-full" value="{{ old('email') }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="telephone" value="Téléphone" />
                        <x-text-input id="telephone" name="telephone" type="text" class="block mt-1 w-full" value="{{ old('telephone') }}" />
                        <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('acheteurs.index') }}" class="px-4 py-2 text-gray-600">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>