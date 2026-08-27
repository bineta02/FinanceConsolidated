@extends('layouts.bailleur')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark m-0"><i class="fas fa-hand-holding-usd text-success me-2"></i>Mes Offres de Financement</h3>
    <a href="{{ route('bailleur.offres.create') }}" class="btn btn-green rounded-4">
        <i class="fas fa-plus me-1"></i> Publier une offre
    </a>
</div>

<div class="row g-4">
    @forelse($offres as $offre)
        <div class="col-md-6">
            <div class="card-modern p-4 h-100 border-0 shadow-sm rounded-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-pill fw-semibold">
                            {{ $offre->secteur_cible }}
                        </span>
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ ucfirst($offre->statut) }}</span>
                    </div>

                    <h4 class="fw-bold text-dark mb-2">
                        {{ number_format($offre->montant_propose, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small>
                    </h4>

                    <div class="bg-light p-3 rounded-3 mb-3">
                        <small class="text-muted d-block fw-bold mb-1">Conditions :</small>
                        <p class="text-secondary small mb-0">{{ Str::limit($offre->conditions, 100) }}</p>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between text-muted small fw-medium mb-3">
                        <span>Taux : <strong>{{ $offre->taux_interet ?? 'N/A' }}%</strong></span>
                        <span>Durée : <strong>{{ $offre->duree_mois ? $offre->duree_mois.' mois' : 'N/A' }}</strong></span>
                    </div>

                    <button type="button" class="btn btn-outline-success w-100 rounded-4" data-bs-toggle="modal" data-bs-target="#modalBailleurOffre{{ $offre->id }}">
                        <i class="fas fa-info-circle me-1"></i> Détails de l'offre
                    </button>
                </div>
            </div>
        </div>

        <!-- MODAL DÉTAILS BAILLEUR -->
        <div class="modal fade" id="modalBailleurOffre{{ $offre->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 border-0 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Détail de l'offre - {{ $offre->secteur_cible }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <h4 class="text-success fw-bold">{{ number_format($offre->montant_propose, 0, ',', ' ') }} FCFA</h4>
                        <p class="text-muted small">Publiée le : {{ $offre->created_at ? $offre->created_at->format('d/m/Y') : 'N/A' }}</p>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold">Conditions d'éligibilité :</h6>
                            <p class="bg-light p-3 rounded-3 text-secondary" style="white-space: pre-line;">{{ $offre->conditions }}</p>
                        </div>

                        <div class="row text-center g-2 mb-3">
                            <div class="col-6 bg-light p-2 rounded">
                                <small class="text-muted d-block">Taux d'intérêt</small>
                                <strong>{{ $offre->taux_interet ?? '0' }}%</strong>
                            </div>
                            <div class="col-6 bg-light p-2 rounded">
                                <small class="text-muted d-block">Durée</small>
                                <strong>{{ $offre->duree_mois ? $offre->duree_mois.' mois' : 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-4" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-muted">Vous n'avez publié aucune offre pour le moment.</p>
        </div>
    @endforelse
</div>
@endsection