@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">
                <i class="fas fa-bullhorn text-success me-2"></i>Offres de financement disponibles
            </h3>
            <p class="text-muted small mb-0">Consultez les opportunités de financement et postulez directement.</p>
        </div>
    </div>

    @if(!isset($offres) || $offres->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucune offre de financement n'est disponible pour le moment.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($offres as $offre)
                <div class="col-md-6 col-lg-4">
                    <div class="card-modern h-100 border-0 shadow-sm rounded-4 p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1">
                                    {{ $offre->secteur_cible ?? 'Tous secteurs' }}
                                </span>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>{{ $offre->created_at ? $offre->created_at->format('d/m/Y') : '' }}
                                </small>
                            </div>

                            <h4 class="fw-bold text-dark mb-2">
                                {{ number_format($offre->montant_propose ?? 0, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small>
                            </h4>

                            <p class="text-muted small mb-3">
                                <i class="fas fa-user-tie text-success me-1"></i>
                                Proposé par : 
                                <strong>
                                    {{ $offre->bailleur?->utilisateur?->prenom }} {{ $offre->bailleur?->utilisateur?->name ?? $offre->bailleur?->utilisateur?->nom ?? 'Bailleur' }}
                                </strong>
                            </p>

                            <div class="bg-light p-3 rounded-3 mb-3">
                                <small class="text-muted d-block fw-bold mb-1">Aperçu des conditions :</small>
                                <p class="text-secondary small mb-0">{{ Str::limit($offre->conditions ?? '', 90) }}</p>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex justify-content-between text-muted small fw-medium mb-3">
                                <span>Taux : <strong>{{ $offre->taux_interet ?? 'N/A' }}%</strong></span>
                                <span>Durée : <strong>{{ $offre->duree_mois ? $offre->duree_mois.' mois' : 'N/A' }}</strong></span>
                            </div>

                            <!-- Bouton pour ouvrir la Modal de Détails -->
                            <button type="button" class="btn btn-outline-success w-100 rounded-4 mb-2" data-bs-toggle="modal" data-bs-target="#modalOffre{{ $offre->id }}">
                                <i class="fas fa-eye me-1"></i> Voir détails
                            </button>

                            <button class="btn btn-green w-100 rounded-4 py-2">
                                <i class="fas fa-paper-plane me-1"></i> Postuler
                            </button>
                        </div>
                    </div>
                </div>

                <!-- MODAL DE DÉTAILS DE L'OFFRE -->
                <div class="modal fade" id="modalOffre{{ $offre->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content rounded-4 border-0 shadow">
                            <div class="modal-header border-bottom-0 pb-0">
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1">
                                    {{ $offre->secteur_cible }}
                                </span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-4">
                                <h4 class="fw-bold text-dark mb-1">
                                    Offre de {{ number_format($offre->montant_propose, 0, ',', ' ') }} FCFA
                                </h4>
                                <p class="text-muted small mb-4">
                                    Proposé par : 
                                    <strong>
                                        {{ $offre->bailleur?->utilisateur?->prenom }} {{ $offre->bailleur?->utilisateur?->name ?? $offre->bailleur?->utilisateur?->nom ?? 'Bailleur' }}
                                    </strong>
                                </p>

                                <div class="row g-3 mb-4">
                                    <div class="col-6 col-md-4">
                                        <div class="p-3 bg-light rounded-3 text-center">
                                            <small class="text-muted d-block">Montant proposé</small>
                                            <strong class="text-success fs-5">{{ number_format($offre->montant_propose, 0, ',', ' ') }} FCFA</strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-4">
                                        <div class="p-3 bg-light rounded-3 text-center">
                                            <small class="text-muted d-block">Taux d'intérêt</small>
                                            <strong class="fs-5">{{ $offre->taux_interet ?? '0' }}%</strong>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="p-3 bg-light rounded-3 text-center">
                                            <small class="text-muted d-block">Durée remboursement</small>
                                            <strong class="fs-5">{{ $offre->duree_mois ? $offre->duree_mois.' Mois' : 'Flexibilité' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold text-dark mb-2"><i class="fas fa-file-contract text-success me-2"></i>Conditions d'Éligibilité & Description</h6>
                                <p class="text-secondary bg-light p-3 rounded-3" style="white-space: pre-line;">{{ $offre->conditions }}</p>
                            </div>

                            <div class="modal-footer border-top-0 pt-0">
                                <button type="button" class="btn btn-secondary rounded-4 px-4" data-bs-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-green rounded-4 px-4">
                                    <i class="fas fa-paper-plane me-1"></i> Postuler maintenant
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection