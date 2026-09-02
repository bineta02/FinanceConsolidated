@extends('layouts.bailleur')

@section('content')
@php
    // Récupération et formatage du porteur de projet
    $entrepreneur = $projet->entrepreneur 
        ?? $projet->utilisateur 
        ?? $projet->user 
        ?? null;

    if (!$entrepreneur && !empty($projet->id_utilisateur)) {
        $entrepreneur = \App\Models\User::find($projet->id_utilisateur);
    }

    $nomPorteur = $entrepreneur 
        ? trim(($entrepreneur->prenom ?? $entrepreneur->first_name ?? '') . ' ' . ($entrepreneur->nom ?? $entrepreneur->name ?? $entrepreneur->last_name ?? '')) 
        : null;

    if (empty(trim($nomPorteur))) {
        $nomPorteur = $entrepreneur->email 
            ?? $projet->nom_entreprise 
            ?? 'Nom non renseigné';
    }
@endphp

<div class="container-fluid">
    <a href="{{ route('bailleur.dashboard') }}" class="btn btn-sm btn-outline-secondary mb-4 rounded-4">
        <i class="fas fa-arrow-left me-2"></i>Retour aux opportunités
    </a>

    <div class="row g-4">
        {{-- Colonne Gauche : Détails du Projet --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-4">{{ $projet->categorie }}</span>
                    <small class="text-muted">Soumis le {{ $projet->created_at ? $projet->created_at->format('d/m/Y') : '-' }}</small>
                </div>
                
                <h2 class="fw-bold text-dark mb-4">{{ $projet->titre }}</h2>
                
                <h5 class="fw-bold text-success mb-3">Description du projet</h5>
                <p class="text-secondary lh-lg" style="white-space: pre-line;">{{ $projet->description }}</p>
                
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Zone d'impact : {{ $projet->localisation ?? 'Dakar, Sénégal' }}</small>
                </div>
            </div>

            {{-- Section Document & Business Plan --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3">
                    <i class="fas fa-file-pdf text-danger me-2"></i>Document & Business Plan
                </h5>

                @if(!empty($projet->document_url))
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                        <div class="d-flex align-items-center me-3">
                            <i class="fas fa-file-alt fa-2x text-success me-3"></i>
                            <div>
                                <strong class="d-block text-dark">Document officiel du projet</strong>
                                <small class="text-muted">Consultez les pièces justificatives fournies par l'entrepreneur.</small>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $projet->document_url) }}" target="_blank" class="btn btn-outline-success rounded-3">
                            <i class="fas fa-download me-1"></i> Consulter / Télécharger
                        </a>
                    </div>
                @else
                    <div class="alert alert-light border rounded-3 mb-0 text-muted small">
                        <i class="fas fa-info-circle me-1"></i> Aucun document complémentaire n'a été joint à ce projet.
                    </div>
                @endif
            </div>
        </div>

        {{-- Colonne Droite : Situation Financière & Formulaire --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 20px;">
                <h5 class="fw-bold text-dark mb-4">Situation Financière</h5>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Objectif global de recherche :</small>
                    <span class="fs-4 fw-bold text-dark">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="mb-4">
                    <small class="text-muted d-block">Fonds actuellement collectés :</small>
                    <span class="fs-4 fw-bold text-success">{{ number_format($projet->montant_collecte, 0, ',', ' ') }} FCFA</span>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold text-dark mb-3"><i class="fas fa-gavel text-success me-2"></i>Faire une offre de financement</h6>
                
                {{-- Messages d'alerte --}}
                @if(session('success'))
                    <div class="alert alert-success border-0 rounded-3 mb-3">
                        <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger border-0 rounded-3 mb-3">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulaire autonome --}}
                <form action="{{ route('bailleur.propositions.store', $projet->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Montant que vous souhaitez injecter (FCFA) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" name="montant" class="form-control" placeholder="Ex: 15000000" min="1" required>
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-dark">Conditions ou note optionnelle</label>
                        <textarea name="conditions" class="form-control" rows="3" placeholder="Ex: Taux d'intérêt de 5.5%, durée 36 mois..."></textarea>
                    </div>

                    <!-- Infos Porteur du projet + Bouton unique pleine largeur -->
                    <div class="pt-3 border-top">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                <i class="fas fa-user text-secondary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block lh-1 mb-1">Porteur du projet</small>
                                <strong class="text-dark fs-6">{{ $nomPorteur }}</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-3 py-2 fw-semibold shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i>Soumettre ma proposition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection