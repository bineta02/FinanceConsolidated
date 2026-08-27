@extends('layouts.bailleur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark m-0">
            <i class="fas fa-plus-circle text-success me-2"></i>Publier une Offre de Financement
        </h4>
        <a href="{{ route('bailleur.offres.index') }}" class="btn btn-outline-secondary btn-sm rounded-4">
            <i class="fas fa-arrow-left me-1"></i> Retour
        </a>
    </div>

    <!-- Affichage des erreurs de validation s'il y en a -->
    @if ($errors->any())
        <div class="alert alert-danger rounded-4 mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('bailleur.offres.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Secteur ciblé</label>
                <select name="secteur_cible" class="form-select rounded-4" required>
                    <option value="Agriculture">Agriculture</option>
                    <option value="Technologie">Technologie</option>
                    <option value="Énergie">Énergie</option>
                    <option value="Santé">Santé</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Montant proposé (FCFA)</label>
                <input type="number" name="montant_propose" class="form-control rounded-4" placeholder="10000000" value="{{ old('montant_propose') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Taux d'intérêt (%)</label>
                <input type="number" step="0.01" name="taux_interet" class="form-control rounded-4" placeholder="5.5" value="{{ old('taux_interet') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Durée de remboursement (Mois)</label>
                <input type="number" name="duree_mois" class="form-control rounded-4" placeholder="24" value="{{ old('duree_mois') }}">
            </div>

            <div class="col-12">
                <label class="form-label fw-bold">Conditions d'éligibilité & Description</label>
                <textarea name="conditions" rows="4" class="form-control rounded-4" placeholder="Précisez les prérequis et modalités pour bénéficier de ce financement..." required>{{ old('conditions') }}</textarea>
            </div>

            <div class="col-12 text-end">
                <button type="submit" class="btn btn-green rounded-4 px-4">
                    <i class="fas fa-paper-plane me-1"></i> Publier l'offre
                </button>
            </div>
        </div>
    </form>
</div>
@endsection