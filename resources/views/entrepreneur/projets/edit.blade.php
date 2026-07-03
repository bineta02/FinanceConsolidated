@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark m-0">
            <i class="fas fa-edit text-success me-2"></i>Modifier le projet : {{ $projet->titre }}
        </h3>
    </div>

    <form action="{{ route('entrepreneur.projet.update', $projet->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Indispensable pour la modification sous Laravel --}}

        <div class="mb-3">
            <label for="titre" class="form-label fw-semibold text-secondary">Titre du projet</label>
            <input type="text" name="titre" id="titre" class="form-control rounded-4" value="{{ old('titre', $projet->titre) }}" required>
        </div>

        <div class="mb-3">
            <label for="categorie" class="form-label fw-semibold text-secondary">Catégorie</label>
            <input type="text" name="categorie" id="categorie" class="form-control rounded-4" value="{{ old('categorie', $projet->categorie) }}" required>
        </div>

        <div class="mb-3">
            <label for="montant_demande" class="form-label fw-semibold text-secondary">Montant Recherché (FCFA)</label>
            <input type="number" name="montant_demande" id="montant_demande" class="form-control rounded-4" value="{{ old('montant_demande', $projet->montant_demande) }}" required>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label fw-semibold text-secondary">Description détaillée</label>
            <textarea name="description" id="description" rows="5" class="form-control rounded-4" required>{{ old('description', $projet->description) }}</textarea>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn-green border-0">
                <i class="fas fa-save me-2"></i>Enregistrer les modifications
            </button>
            <a href="{{ route('entrepreneur.projet.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-4">
                Annuler
            </a>
        </div>
    </form>
</div>
@endsection