@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <!-- En-tête avec bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0">
            <i class="fas fa-info-circle text-success me-2"></i>Détails du projet : {{ $projet->titre }}
        </h3>
        <a href="{{ route('entrepreneur.projet.index') }}" class="btn btn-outline-secondary rounded-4">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="row g-4">
        <!-- Informations Générales -->
        <div class="col-md-8">
            <div class="p-3 bg-light rounded-4 mb-4">
                <h5 class="fw-bold text-secondary mb-3">Description</h5>
                <p class="text-dark" style="white-space: pre-line;">{{ $projet->description }}</p>
            </div>

            <!-- Document Joint -->
            <div class="p-3 bg-light rounded-4">
                <h5 class="fw-bold text-secondary mb-3">Document de présentation</h5>
                @if($projet->document_url)
                    <div class="d-flex align-items-center justify-content-between bg-white p-3 rounded-3 border">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Document joint au projet</h6>
                                <small class="text-muted">Format PDF / DOC</small>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $projet->document_url) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-3">
                            <i class="fas fa-download me-1"></i> Consulter / Télécharger
                        </a>
                    </div>
                @else
                    <p class="text-muted m-0">Aucun document n'a été joint à ce projet.</p>
                @endif
            </div>
        </div>

        <!-- Récapitulatif Clé (Sidebar) -->
        <div class="col-md-4">
            <div class="p-4 bg-light rounded-4">
                <h5 class="fw-bold text-secondary mb-3">Informations Clés</h5>

                <div class="mb-3">
                    <small class="text-muted d-block">Statut du dossier</small>
                    @if($projet->statut === 'en_attente')
                        <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-4">En attente</span>
                    @elseif($projet->statut === 'approuve')
                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-4">Approuvé</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-4">Refusé</span>
                    @endif
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Catégorie</small>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-4">{{ $projet->categorie }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Localisation</small>
                    <span class="fw-semibold text-dark"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $projet->localisation ?? 'Non renseignée' }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Montant Recherché</small>
                    <span class="fs-5 fw-bold text-dark">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Fonds Collectés</small>
                    <span class="fs-5 fw-bold text-success">{{ number_format($projet->montant_collecte, 0, ',', ' ') }} FCFA</span>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <a href="{{ route('entrepreneur.projet.edit', $projet->id) }}" class="btn btn-warning rounded-4 text-white">
                        <i class="fas fa-edit me-2"></i>Modifier le projet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection