@extends('layouts.app') @section('content')
<div class="flex h-screen bg-gray-100">
    
    <div class="flex-1 p-10 overflow-y-auto">
        
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-sm">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier mon profil Entrepreneur</h1>

            <form action="{{ route('entrepreneur.profil.update') }}" method="POST">
                @csrf
                @method('PUT') <div class="mb-5">
                    <label for="secteur_dactivite" class="block text-sm font-medium text-gray-700 mb-2">
                        Secteur d'activité
                    </label>
                    <input type="text" 
                           name="secteur_dactivite" 
                           id="secteur_dactivite" 
                           value="{{ old('secteur_dactivite', $entrepreneur->secteur_dactivite) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                           required>
                    @error('secteur_dactivite')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="annees_experiences" class="block text-sm font-medium text-gray-700 mb-2">
                        Années d'expérience
                    </label>
                    <input type="number" 
                           name="annees_experiences" 
                           id="annees_experiences" 
                           value="{{ old('annees_experiences', $entrepreneur->annees_experiences) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                           min="0"
                           required>
                    @error('annees_experiences')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description_profil" class="block text-sm font-medium text-gray-700 mb-2">
                        Description du profil / Biographie
                    </label>
                    <textarea name="description_profil" 
                              id="description_profil" 
                              rows="5" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500"
                              required>{{ old('description_profil', $entrepreneur->description_profil) }}</textarea>
                    @error('description_profil')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Annuler
                    </a>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 shadow-md">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection