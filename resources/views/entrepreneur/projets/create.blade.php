@extends('layouts.entrepreneur')

@section('content')
<h3 class="fw-bold mb-4"><i class="fas fa-plus-circle text-success"></i> Déposer un nouveau projet</h3>

<div class="card-modern p-4">
    <!-- N'oublie pas enctype="multipart/form-data" pour l'envoi de fichiers -->
    <form action="{{ route('entrepreneur.projet.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">Nom du projet *</label>
            <input type="text" name="titre" class="form-control rounded-4 @error('titre') is-invalid @enderror" value="{{ old('titre') }}" placeholder="ex: Eco-Transport Dakar" required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Description détaillée *</label>
            <textarea name="description" class="form-control rounded-4 @error('description') is-invalid @enderror" rows="4" placeholder="Décrivez votre projet, son impact..." required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Montant recherché (FCFA) *</label>
                <input type="number" name="montant_demande" class="form-control rounded-4 @error('montant_demande') is-invalid @enderror" value="{{ old('montant_demande') }}" placeholder="ex: 5000000" required>
                @error('montant_demande')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-semibold">Localisation (Ville / Région) *</label>
                <input type="text" name="localisation" class="form-control rounded-4 @error('localisation') is-invalid @enderror" value="{{ old('localisation') }}" placeholder="ex: Dakar, Thiès, Ziguinchor..." required>
                @error('localisation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Catégorie *</label>
            <select name="categorie" class="form-select rounded-4 @error('categorie') is-invalid @enderror" required>
                <option value="" disabled selected>Sélectionnez une catégorie</option>
                <option value="Agriculture" {{ old('categorie') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                <option value="Tech" {{ old('categorie') == 'Tech' ? 'selected' : '' }}>Tech</option>
                <option value="Artisanat" {{ old('categorie') == 'Artisanat' ? 'selected' : '' }}>Artisanat</option>
                <option value="Énergie" {{ old('categorie') == 'Énergie' ? 'selected' : '' }}>Énergie</option>
                <option value="Autre" {{ old('categorie') == 'Autre' ? 'selected' : '' }}>Autre</option>
            </select>
            @error('categorie')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Champ pour téléverser un document complémentaire -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Document complémentaire (PDF, DOC, DOCX - Max 5Mo)</label>
            <input type="file" name="document" class="form-control rounded-4 @error('document') is-invalid @enderror">
            <small class="text-muted">Optionnel : Joignez votre note conceptuelle ou business plan.</small>
            @error('document')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-green w-100 py-2 rounded-4">
            <i class="fas fa-save me-2"></i> Soumettre mon projet
        </button>
    </form>
</div>
@endsection