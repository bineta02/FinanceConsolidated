@extends('layouts.entrepreneur')

@section('content')
<div class="container-fluid py-4 px-4">
    <!-- En-tête -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Contrats & Garanties</h3>
            <p class="text-muted small mb-0">Gérez vos documents officiels, vos garanties et vos échéances de remboursement.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Carte Principale -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="card-title mb-0 fw-bold text-dark">
                    <i class="fas fa-file-contract text-success me-2"></i>Mes financements & garanties
                </h6>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                    Total : {{ $financements ? $financements->count() : 0 }}
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3">Projet & Détails</th>
                                <th class="py-3">Bailleur</th>
                                <th class="py-3">Montant</th>
                                <th class="py-3">Statut contrat</th>
                                <th class="py-3">Garanties</th>
                                <th class="text-end pe-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($financements as $financement)
                                @php
                                    $contrat = $financement->contrat;
                                    $bailleur = $financement->bailleur;
                                    
                                    $userBailleur = $bailleur->utilisateur ?? $bailleur->user ?? null;
                                    if ($userBailleur) {
                                        $nomBailleur = trim(($userBailleur->prenom ?? '') . ' ' . ($userBailleur->nom ?? ''));
                                    } elseif ($bailleur) {
                                        $nomBailleur = trim(($bailleur->prenom ?? '') . ' ' . ($bailleur->nom ?? ''));
                                    } else {
                                        $nomBailleur = 'Bailleur';
                                    }
                                    if (empty(trim($nomBailleur))) { $nomBailleur = 'Bailleur'; }
                                @endphp
                                <tr>
                                    <!-- Projet -->
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-dark mb-1">{{ $financement->projet->titre ?? 'Mon Projet' }}</div>
                                        <div class="text-muted small">
                                            <i class="far fa-clock me-1"></i>{{ $financement->duree }} mois &bull; 
                                            <i class="fas fa-percentage me-1"></i>{{ $financement->taux_interet }}%
                                        </div>
                                    </td>

                                    <!-- Bailleur -->
                                    <td class="py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-light text-success rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user-tie small"></i>
                                            </div>
                                            <span class="fw-semibold text-secondary small">{{ $nomBailleur }}</span>
                                        </div>
                                    </td>

                                    <!-- Montant Accordé -->
                                    <td class="py-3">
                                        <span class="fw-bold text-success">
                                            {{ number_format($financement->montant_accorde, 0, ',', ' ') }} <small class="fw-normal">FCFA</small>
                                        </span>
                                    </td>

                                    <!-- Statut du contrat -->
                                    <td class="py-3">
                                        @if(!$contrat)
                                            <span class="badge bg-light text-muted border rounded-pill px-3 py-1">Non généré</span>
                                        @elseif(in_array(strtolower($contrat->statut), ['signe', 'signé', 'valide', 'actif']))
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                                <i class="fas fa-check-circle me-1"></i> Signé
                                            </span>
                                        @elseif(in_array(strtolower($contrat->statut), ['a_signer', 'en_attente', 'en attente de signature', 'à signé']))
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1">
                                                <i class="fas fa-clock me-1"></i> À signer
                                            </span>
                                        @else
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-3 py-1">{{ $contrat->statut }}</span>
                                        @endif

                                        @if($contrat && $contrat->date_signature)
                                            <div class="text-muted small fs-7 mt-1">
                                                {{ \Carbon\Carbon::parse($contrat->date_signature)->format('d/m/Y') }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Garanties déposées avec option de suppression -->
                                    <td class="py-3">
                                        @if($financement->garanties && $financement->garanties->count() > 0)
                                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                                @foreach($financement->garanties as $garantie)
                                                    <span class="badge bg-light text-dark border rounded-2 px-2 py-1 small d-inline-flex align-items-center gap-1" title="Valeur : {{ number_format($garantie->valeur_estime, 0, ',', ' ') }} FCFA">
                                                        <i class="fas fa-shield-alt text-success"></i>
                                                        {{ $garantie->type_garantie }}
                                                        
                                                        <!-- Bouton de suppression -->
                                                        <form action="{{ route('garanties.destroy', $garantie->id) }}" method="POST" class="d-inline ms-1">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger p-0 border-0 lh-1" onclick="return confirm('Voulez-vous vraiment supprimer cette garantie ?')" title="Supprimer la garantie">
                                                                <i class="fas fa-times-circle fs-7"></i>
                                                            </button>
                                                        </form>
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Aucune garantie</span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end pe-4 py-3">
                                        <div class="d-inline-flex gap-1 align-items-center">
                                            
                                            <!-- Bouton Ajouter Garantie -->
                                            <button type="button" class="btn btn-sm btn-light border rounded-3 text-secondary" data-bs-toggle="modal" data-bs-target="#modalGarantie{{ $financement->id }}" title="Déposer une garantie">
                                                <i class="fas fa-shield-alt text-success me-1"></i> Garantie
                                            </button>

                                            <!-- Bouton Échéances -->
                                            <a href="{{ route('entrepreneur.echeances', ['financement_id' => $financement->id]) }}" class="btn btn-sm btn-light border rounded-3 text-secondary" title="Voir les échéances">
                                                <i class="fas fa-calendar-alt text-primary me-1"></i> Échéances
                                            </a>

                                            <!-- Actions spécifiques au Contrat -->
                                            @if($contrat && !empty($contrat->fichier_url))
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" target="_blank" class="btn btn-sm btn-light border rounded-3 text-secondary" title="Lire le document">
                                                    <i class="fas fa-eye me-1"></i> Lire
                                                </a>

                                                @if(in_array(strtolower($contrat->statut), ['a_signer', 'en_attente', 'en attente de signature', 'à signé']))
                                                    <form action="{{ route('entrepreneur.contrats.signer', $contrat->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success rounded-3 px-3" onclick="return confirm('Confirmez-vous la signature de ce contrat ?')">
                                                            <i class="fas fa-signature me-1"></i> Signer
                                                        </button>
                                                    </form>
                                                @else
                                                    <a href="{{ asset('storage/' . $contrat->fichier_url) }}" download class="btn btn-sm btn-outline-success rounded-3" title="Télécharger le contrat signé">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                @endif
                                            @endif

                                        </div>
                                    </td>
                                </tr>

                                <!-- MODAL GARANTIE -->
                                <div class="modal fade" id="modalGarantie{{ $financement->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow-lg">
                                            <div class="modal-header border-bottom py-3 px-4">
                                                <h5 class="modal-title fw-bold text-dark fs-6">
                                                    <i class="fas fa-shield-alt text-success me-2"></i>Déposer une garantie
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>

                                            <form action="{{ route('garanties.store', $financement->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body p-4 text-start">
                                                    
                                                    <div class="p-3 bg-light rounded-3 mb-3 border">
                                                        <div class="text-muted small">Projet concerné</div>
                                                        <div class="fw-bold text-dark">{{ $financement->projet->titre ?? 'Mon Projet' }}</div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold small text-secondary">Type de garantie</label>
                                                        <select name="type_garantie" class="form-select rounded-3" required>
                                                            <option value="">-- Sélectionner un type --</option>
                                                            <option value="Hypothèque immobilière">Hypothèque immobilière</option>
                                                            <option value="Nantissement d'équipement/véhicule">Nantissement d'équipement / véhicule</option>
                                                            <option value="Caution personnelle / solidaire">Caution personnelle / solidaire</option>
                                                            <option value="Gage sur stock">Gage sur stock / marchandise</option>
                                                            <option value="Autre">Autre garantie</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold small text-secondary">Valeur estimée (FCFA)</label>
                                                        <div class="input-group">
                                                            <input type="number" name="valeur_estime" class="form-control rounded-start-3" placeholder="Ex: 5000000" min="0" required>
                                                            <span class="input-group-text rounded-end-3 bg-light text-muted small">FCFA</span>
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label fw-semibold small text-secondary">Document justificatif (PDF / Image)</label>
                                                        <input type="file" name="document" class="form-control rounded-3" accept=".pdf,.png,.jpg,.jpeg">
                                                        <span class="form-text text-muted fs-7">Titre de propriété, facture, attestation (Max 5 Mo).</span>
                                                    </div>

                                                </div>

                                                <div class="modal-footer border-top py-3 px-4 bg-light">
                                                    <button type="button" class="btn btn-sm btn-link text-muted text-decoration-none me-auto" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-sm btn-success px-4 rounded-3 fw-semibold">
                                                        <i class="fas fa-save me-1"></i> Enregistrer
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5 px-4">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-file-signature fa-2x text-secondary"></i>
                    </div>
                    <h6 class="fw-bold text-dark">Aucun contrat ou garantie disponible</h6>
                    <p class="small text-muted mb-0">Dès qu'un bailleur vous transmettra un contrat, il apparaîtra ici.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection