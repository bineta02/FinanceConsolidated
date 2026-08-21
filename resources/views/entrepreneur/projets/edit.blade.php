@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark m-0">
            <i class="fas fa-edit text-success me-2"></i>Modifier le projet : {{ $projet->titre }}
        </h3>
    </div>

    <form action="{{ route('entrepreneur.projet.update', $projet->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titre" class="form-label fw-semibold text-secondary">Titre du projet *</label>
            <input type="text" name="titre" id="titre" class="form-control rounded-4 @error('titre') is-invalid @enderror" value="{{ old('titre', $projet->titre) }}" required>
            @error('titre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="categorie" class="form-label fw-semibold text-secondary">Catégorie *</label>
                <input type="text" name="categorie" id="categorie" class="form-control rounded-4 @error('categorie') is-invalid @enderror" value="{{ old('categorie', $projet->categorie) }}" required>
                @error('categorie')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label for="localisation" class="form-label fw-semibold text-secondary">Localisation *</label>
                <input type="text" name="localisation" id="localisation" class="form-control rounded-4 @error('localisation') is-invalid @enderror" value="{{ old('localisation', $projet->localisation) }}" placeholder="ex: Dakar, Thiès..." required>
                @error('localisation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="montant_demande" class="form-label fw-semibold text-secondary">Montant Recherché (FCFA) *</label>
            <input type="number" name="montant_demande" id="montant_demande" class="form-control rounded-4 @error('montant_demande') is-invalid @enderror" value="{{ old('montant_demande', $projet->montant_demande) }}" required>
            @error('montant_demande')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold text-secondary">Description détaillée *</label>
            <textarea name="description" id="description" rows="5" class="form-control rounded-4 @error('description') is-invalid @enderror" required>{{ old('description', $projet->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Section Gestion du Document Joint -->
        <div class="mb-4">
            <label for="document" class="form-label fw-semibold text-secondary">Document de présentation (PDF, DOC, DOCX - Max 5Mo)</label>

            @if($projet->document_url)
                <div class="p-3 bg-light rounded-4 mb-3 d-flex align-items-center justify-content-between border">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold small text-dark">Document actuellement joint</p>
                            <a href="{{ asset('storage/' . $projet->document_url) }}" target="_blank" class="text-success small text-decoration-none">
                                <i class="fas fa-external-link-alt me-1"></i> Consulter le document
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('entrepreneur.projet.document.destroy', $projet->id) }}" 
                       onclick="return confirm('Voulez-vous vraiment supprimer ce document ?')"
                       class="btn btn-sm btn-outline-danger rounded-4">
                        <i class="fas fa-trash me-1"></i> Supprimer le fichier
                    </a>
                </div>
            @endif

            <input type="file" name="document" id="document" class="form-control rounded-4 @error('document') is-invalid @enderror">
            @error('document')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Laissez ce champ vide si vous ne souhaitez pas remplacer le document existant.</small>
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