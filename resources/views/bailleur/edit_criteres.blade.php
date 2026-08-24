@extends('layouts.bailleur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0">
            <i class="fas fa-user-edit text-success me-2"></i>Modifier mon profil & mes critères
        </h4>
        <!-- REMPLACER .edit PAR .criteres POUR REVENIR A LA PAGE D'AFFICHAGE -->
        <a href="{{ route('bailleur.criteres') }}" class="btn btn-outline-secondary rounded-4 btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Retour aux critères
        </a>
    </div>

    <!-- LE FORMULAIRE EST CORRECT -->
    <form action="{{ route('bailleur.criteres.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Secteur d'intérêt préféré</label>
                <select name="secteur_prefere" class="form-select rounded-4">
                    <option value="">Tous les secteurs</option>
                    <option value="Agriculture" {{ ($bailleur->secteurs_preferes ?? '') == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                    <option value="Technologie" {{ ($bailleur->secteurs_preferes ?? '') == 'Technologie' ? 'selected' : '' }}>Technologie</option>
                    <option value="Énergie" {{ ($bailleur->secteurs_preferes ?? '') == 'Énergie' ? 'selected' : '' }}>Énergie</option>
                    <option value="Santé" {{ ($bailleur->secteurs_preferes ?? '') == 'Santé' ? 'selected' : '' }}>Santé</option>
                    <option value="Éducation" {{ ($bailleur->secteurs_preferes ?? '') == 'Éducation' ? 'selected' : '' }}>Éducation</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Document d'agrément / Pièce (PDF, PNG, JPG)</label>
                <input type="file" name="document_agrement" class="form-control rounded-4" accept=".pdf,.png,.jpg">
            </div>

            <div class="col-12 text-end mt-4">
                <button type="submit" class="btn btn-green rounded-4 px-4">
                    <i class="fas fa-save me-2"></i>Enregistrer les modifications
                </button>
            </div>
        </div>
    </form>
</div>
@endsection