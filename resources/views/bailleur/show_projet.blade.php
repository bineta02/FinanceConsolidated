@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <a href="{{ route('bailleur.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-4 rounded-4">
        <i class="fas fa-arrow-left me-2"></i>Retour aux opportunités
    </a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card-modern p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-4">{{ $projet->categorie }}</span>
                    <small class="text-muted">Soumis le {{ $projet->created_at->format('d/m/Y') }}</small>
                </div>
                
                <h2 class="fw-bold text-dark mb-4">{{ $projet->titre }}</h2>
                
                <h5 class="fw-bold text-success mb-3">Description du projet</h5>
                <p class="text-secondary lh-lg" style="white-space: pre-line;">{{ $projet->description }}</p>
                
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Zone d'impact : {{ $projet->localisation ?? 'Dakar, Sénégal' }}</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card-modern p-4 bg-white sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-4">Situation Financière</h5>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Objectif global de recherche :</small>
                    <span class="fs-4 fw-bold text-dark">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="mb-4">
                    <small class="text-muted d-block">Fonds actuellement collectés :</small>
                    <span class="fs-4 fw-bold text-success">{{ number_format($projet->montant_collecte, 0, ',', ' ') }} FCFA</span>
                </div>

                <hr>

                <h6 class="fw-bold text-dark mb-3 mt-3"><i class="fas fa-gavel text-success me-2"></i>Faire une offre de financement</h6>
                
                <form action="{{ route('bailleur.offre.store', $projet->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="montant_offre" class="form-label small text-secondary">Montant que vous souhaitez injecter (FCFA)</label>
                        <div class="input-group">
                            <input type="number" name="montant_offre" id="montant_offre" class="form-control rounded-start-4" min="1" max="{{ $projet->montant_demande - $projet->montant_collecte }}" required placeholder="Ex: 500000">
                            <span class="input-group-text bg-light rounded-end-4 fw-bold small">FCFA</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="commentaire" class="form-label small text-secondary">Conditions ou note optionnelle</label>
                        <textarea name="commentaire" id="commentaire" rows="3" class="form-control rounded-4" placeholder="Ex: Taux d'intérêt de x% ou modalités d'accompagnement..."></textarea>
                    </div>

                    <button type="submit" class="btn-green w-100 border-0 py-2.5 rounded-4">
                        <i class="fas fa-paper-plane me-2"></i>Soumettre ma proposition
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection