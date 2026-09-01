@extends('layouts.entrepreneur')

@section('content')
<div class="container-fluid py-3">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Offres et financements reçus</h3>
        <p class="text-muted small">Voici la liste des propositions de financement soumises par les bailleurs pour vos projets.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-3 shadow-sm">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Projet Concerné</th>
                            <th>Bailleur</th>
                            <th>Montant Proposé</th>
                            <th>Conditions</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($financements as $financement)
                            @php
                                // 1. Récupération du Bailleur (Prénom + Nom)
                                $userBailleur = $financement->bailleur->utilisateur ?? $financement->bailleur->user ?? null;
                                
                                $nomCompletBailleur = $userBailleur 
                                    ? trim(($userBailleur->prenom ?? $userBailleur->first_name ?? '') . ' ' . ($userBailleur->nom ?? $userBailleur->name ?? $userBailleur->last_name ?? '')) 
                                    : ($financement->bailleur->nom_organisation ?? 'Bailleur #' . $financement->id_bailleur);

                                if (empty(trim($nomCompletBailleur))) {
                                    $nomCompletBailleur = $userBailleur->email ?? ('Bailleur #' . $financement->id_bailleur);
                                }

                                // 2. Récupération du projet : via relation OU secours sur le premier projet de l'entrepreneur
                                $projet = $financement->projet ?? \App\Models\Projet::where('id_utilisateur', Auth::id())->latest()->first();
                                
                                $titreProjet = $projet->titre ?? $projet->nom ?? $projet->titre_projet ?? 'Projet d\'Agriculture';
                                $categorieProjet = $projet->categorie ?? $projet->secteur ?? $projet->domaine ?? $projet->secteur_activite ?? 'Agriculture';

                                // 3. Récupération Robuste des Conditions (Gère NULL, "" et espaces vides)
                                $rawConditions = trim(
                                    $financement->conditions 
                                    ?? $financement->description 
                                    ?? $financement->note 
                                    ?? $financement->modalites 
                                    ?? $financement->details 
                                    ?? ''
                                );

                                $conditionsTexte = !empty($rawConditions) 
                                    ? $rawConditions 
                                    : 'Aucune condition particulière';
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <strong class="d-block text-dark">{{ $titreProjet }}</strong>
                                    <small class="text-muted">Catégorie : {{ $categorieProjet }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-light text-success rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width:35px; height:35px;">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <strong class="text-dark">{{ $nomCompletBailleur }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-success fs-6">
                                        {{ number_format($financement->montant_accorde ?? $financement->montant, 0, ',', ' ') }} FCFA
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted d-block" style="max-width: 200px;">
                                        {{ Str::limit($conditionsTexte, 40) }}
                                    </small>
                                </td>
                                <td>
                                    @if($financement->statut == 'en_attente')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">En attente</span>
                                    @elseif(in_array($financement->statut, ['approuve', 'valide', 'accepte']))
                                        <span class="badge bg-success rounded-pill px-3">Approuvé</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($financement->statut) }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <!-- Bouton voir les détails -->
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-3 me-1" data-bs-toggle="modal" data-bs-target="#modalFinancement{{ $financement->id }}">
                                        <i class="fas fa-eye me-1"></i> Détails
                                    </button>

                                    @if($financement->statut == 'en_attente')
                                        <form action="{{ route('entrepreneur.financements.accepter', $financement->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-3">
                                                <i class="fas fa-check me-1"></i> Accepter
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-muted border">Validé</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- MODALE FENÊTRE DÉTAILS -->
                            <div class="modal fade" id="modalFinancement{{ $financement->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4 border-0 shadow">
                                        <div class="modal-header border-bottom-0 pb-0">
                                            <h5 class="modal-title fw-bold text-dark">
                                                <i class="fas fa-file-invoice-dollar text-success me-2"></i>Détails de la proposition
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="mb-3 p-3 bg-light rounded-3">
                                                <small class="text-muted d-block mb-1">Projet concerné</small>
                                                <h6 class="fw-bold text-dark mb-0">{{ $titreProjet }}</h6>
                                            </div>

                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <div class="p-3 border rounded-3">
                                                        <small class="text-muted d-block mb-1">Bailleur / Investisseur</small>
                                                        <strong class="text-dark d-block">{{ $nomCompletBailleur }}</strong>
                                                        <small class="text-muted">{{ $userBailleur->email ?? '' }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-3 border rounded-3 bg-success bg-opacity-10">
                                                        <small class="text-success d-block mb-1">Montant proposé</small>
                                                        <h5 class="fw-bold text-success mb-0">
                                                            {{ number_format($financement->montant_accorde ?? $financement->montant, 0, ',', ' ') }} FCFA
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fw-semibold text-dark mb-1"><i class="fas fa-clipboard-list me-1 text-secondary"></i> Conditions & Notes du bailleur :</label>
                                                <div class="p-3 bg-light rounded-3 border">
                                                    <p class="text-secondary small mb-0" style="white-space: pre-line;">
                                                        {{ $conditionsTexte }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center pt-2">
                                                <small class="text-muted">Proposé le : {{ $financement->created_at ? $financement->created_at->format('d/m/Y à H:i') : 'N/A' }}</small>
                                                <div>
                                                    <span class="small me-2">Statut :</span>
                                                    @if($financement->statut == 'en_attente')
                                                        <span class="badge bg-warning text-dark">En attente</span>
                                                    @else
                                                        <span class="badge bg-success">Approuvé</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Fermer</button>
                                            @if($financement->statut == 'en_attente')
                                                <form action="{{ route('entrepreneur.financements.accepter', $financement->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success rounded-3">
                                                        <i class="fas fa-check me-1"></i> Accepter la proposition
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-hand-holding-usd fa-3x mb-3 text-secondary d-block"></i>
                                    Aucune offre de financement reçue pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection