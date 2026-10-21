@extends('layouts.bailleur')

@section('content')
<div class="container-fluid py-3 px-4">
    <div class="mb-3">
        <h4 class="fw-bold text-dark mb-1">Garanties & Contrats</h4>
        <p class="text-muted small mb-0">Gestion des documents juridiques, garanties et contrats de prêt d'honneur.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 py-2 px-3 mb-3 alert-dismissible fade show small" role="alert">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
            <button type="button" class="btn-close py-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 fs-7">
                        <thead class="bg-light text-muted fw-bold text-uppercase" style="font-size: 0.75rem;">
                            <tr>
                                <th class="ps-3 py-2">Projet / Entrepreneur</th>
                                <th class="py-2">Montant</th>
                                <th class="py-2">Durée & Taux</th>
                                <th class="py-2">Garanties</th>
                                <th class="py-2">Date Signature</th>
                                <th class="py-2">Statut Contrat</th>
                                <th class="text-end pe-3 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($financements as $financement)
                                @php
                                    $contrat = $financement->contrat;
                                    $entrepreneur = $financement->projet->entrepreneur ?? $financement->projet->utilisateur ?? null;
                                    $nomEntrepreneur = $entrepreneur 
                                        ? trim(($entrepreneur->prenom ?? '') . ' ' . ($entrepreneur->nom ?? '')) 
                                        : 'Entrepreneur';

                                    $dateSignature = $contrat ? ($contrat->date_signature ?? $contrat->date_signature_entrepreneur ?? $contrat->updated_at) : null;

                                    $statutClean = $contrat ? strtolower(trim($contrat->statut ?? '')) : '';
                                    $estSigne = $contrat && (
                                        in_array($statutClean, ['signe', 'signé', 'valide', 'validé', 'actif', 'signe_entrepreneur', 'signe_bailleur']) ||
                                        !empty($contrat->date_signature) ||
                                        !empty($contrat->date_signature_entrepreneur) ||
                                        !empty($contrat->signature_entrepreneur)
                                    );
                                @endphp
                                <tr>
                                    <!-- Projet & Entrepreneur -->
                                    <td class="ps-3 py-2">
                                        <div class="fw-bold text-dark lh-sm mb-0 fs-7">{{ $financement->projet->titre ?? 'Projet' }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            <i class="fas fa-user me-1 text-secondary" style="font-size: 0.70rem;"></i> {{ $nomEntrepreneur }}
                                        </div>
                                    </td>

                                    <!-- Montant -->
                                    <td class="py-2">
                                        <span class="fw-bold text-success fs-7">
                                            {{ number_format($financement->montant_accorde, 0, ',', ' ') }} <small class="fw-normal" style="font-size: 0.70rem;">FCFA</small>
                                        </span>
                                    </td>

                                    <!-- Durée & Taux -->
                                    <td class="py-2">
                                        <span class="text-dark fw-semibold fs-7">{{ $financement->duree }} mois</span>
                                        <div class="text-muted" style="font-size: 0.75rem;">Taux : {{ $financement->taux_interet }}%</div>
                                    </td>

                                    <!-- Garanties déposées -->
                                    <td class="py-2">
                                        @if($financement->garanties && $financement->garanties->count() > 0)
                                            <div class="d-flex flex-column gap-1">
                                                @foreach($financement->garanties as $garantie)
                                                    <div class="p-1 px-2 rounded bg-light border d-flex align-items-center justify-content-between gap-2" style="min-width: 200px;">
                                                        
                                                        <div class="d-flex align-items-center gap-1.5 overflow-hidden">
                                                            <i class="fas fa-shield-alt text-success me-1" style="font-size: 0.75rem;"></i>
                                                            <div class="lh-1 text-truncate">
                                                                <span class="fw-semibold text-dark text-truncate d-inline-block" style="max-width: 90px; font-size: 0.75rem;" title="{{ $garantie->type_garantie }}">
                                                                    {{ $garantie->type_garantie }}
                                                                </span>
                                                                <small class="text-muted d-block" style="font-size: 0.68rem;">
                                                                    {{ number_format($garantie->valeur_estime, 0, ',', ' ') }} FCFA
                                                                </small>
                                                            </div>

                                                            @if($garantie->document_url)
                                                                <a href="{{ asset('storage/' . $garantie->document_url) }}" target="_blank" class="text-danger ms-1 p-0" title="Voir le justificatif PDF">
                                                                    <i class="fas fa-file-pdf" style="font-size: 0.8rem;"></i>
                                                                </a>
                                                            @endif
                                                        </div>

                                                        <div class="d-flex align-items-center gap-1">
                                                            @if(in_array(strtolower($garantie->statut), ['valide', 'validé']))
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill py-0 px-1" style="font-size: 0.65rem;">
                                                                    Validée
                                                                </span>
                                                            @elseif(in_array(strtolower($garantie->statut), ['rejete', 'rejeté']))
                                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill py-0 px-1" style="font-size: 0.65rem;">
                                                                    Rejetée
                                                                </span>
                                                            @else
                                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill py-0 px-1" style="font-size: 0.65rem;">
                                                                    En attente
                                                                </span>
                                                            @endif

                                                            <!-- Micro-boutons d'action pour garantie -->
                                                            <div class="d-flex ms-1">
                                                                <form action="{{ route('garanties.updateStatut', $garantie->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="statut" value="valide">
                                                                    <button type="submit" class="btn btn-link text-success p-0 px-1 border-0" title="Valider" onclick="return confirm('Valider cette garantie ?')">
                                                                        <i class="fas fa-check" style="font-size: 0.70rem;"></i>
                                                                    </button>
                                                                </form>

                                                                <form action="{{ route('garanties.updateStatut', $garantie->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <input type="hidden" name="statut" value="rejete">
                                                                    <button type="submit" class="btn btn-link text-danger p-0 px-1 border-0" title="Rejeter" onclick="return confirm('Rejeter cette garantie ?')">
                                                                        <i class="fas fa-times" style="font-size: 0.70rem;"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted fst-italic" style="font-size: 0.75rem;">Aucune garantie</span>
                                        @endif
                                    </td>

                                    <!-- Date Signature -->
                                    <td class="py-2">
                                        @if($estSigne && $dateSignature)
                                            <span class="fw-semibold text-dark" style="font-size: 0.75rem;">
                                                <i class="far fa-calendar-check me-1 text-success" style="font-size: 0.70rem;"></i>
                                                {{ \Carbon\Carbon::parse($dateSignature)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.75rem;">-- / -- / ----</span>
                                        @endif
                                    </td>

                                    <!-- Statut Contrat -->
                                    <td class="py-2">
                                        @if(!$contrat)
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2 py-0" style="font-size: 0.70rem;">
                                                Non généré
                                            </span>
                                        @elseif($estSigne)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0" style="font-size: 0.70rem;">
                                                Signé
                                            </span>
                                        @elseif(in_array($statutClean, ['a_signer', 'en_attente', 'en attente de signature', 'à signer', 'transmis']))
                                            <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-0" style="font-size: 0.70rem;">
                                                En attente
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-2 py-0" style="font-size: 0.70rem;">
                                                {{ ucfirst($contrat->statut) }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions principales & Contrat -->
                                    <td class="text-end pe-3 py-2">
                                        <div class="d-inline-flex align-items-center gap-1">
                                            @if($contrat && !empty($contrat->fichier_url))
                                                <!-- Bouton Voir -->
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" target="_blank" class="btn btn-xs btn-light border text-secondary px-2 py-0 rounded" title="Visualiser" style="font-size: 0.75rem;">
                                                    <i class="fas fa-eye text-primary" style="font-size: 0.70rem;"></i>
                                                </a>

                                                <!-- Bouton Télécharger -->
                                                <a href="{{ asset('storage/' . $contrat->fichier_url) }}" download="Contrat_Financement_{{ $financement->id }}.pdf" class="btn btn-xs btn-light border text-secondary px-2 py-0 rounded" title="Télécharger" style="font-size: 0.75rem;">
                                                    <i class="fas fa-download text-success" style="font-size: 0.70rem;"></i>
                                                </a>
                                            @endif

                                            <!-- Bouton Ajouter / Remplacer -->
                                            <button type="button" class="btn btn-xs btn-success rounded px-2 py-0 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalContrat{{ $financement->id }}" style="font-size: 0.75rem;">
                                                <i class="fas fa-upload me-1" style="font-size: 0.65rem;"></i> {{ $contrat ? 'Remplacer' : 'Ajouter' }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-file-contract fa-2x text-secondary mb-2"></i>
                    <h6 class="fw-bold text-dark fs-7">Aucun contrat actif</h6>
                    <p class="small text-muted mb-0" style="font-size: 0.75rem;">Les financements accordés apparaîtront ici.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MODALS DE TRANSMISSION DU CONTRAT -->
@if(isset($financements) && $financements->count() > 0)
    @foreach($financements as $financement)
        <div class="modal fade text-start" id="modalContrat{{ $financement->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content rounded-3 border-0 shadow">
                    <form action="{{ route('bailleur.contrats.upload', $financement->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header border-bottom py-2 px-3">
                            <h6 class="modal-title fw-bold text-dark fs-7">
                                <i class="fas fa-file-contract text-success me-1"></i>Transmission Contrat
                            </h6>
                            <button type="button" class="btn-close ms-auto" style="font-size: 0.70rem;" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body p-3">
                            <div class="p-2 bg-light rounded mb-2 border">
                                <div class="text-muted" style="font-size: 0.68rem;">Projet concerné</div>
                                <div class="fw-bold text-dark fs-7 text-truncate">{{ $financement->projet->titre ?? 'Projet' }}</div>
                            </div>

                            <div class="mb-2">
                                <label class="form-label fw-semibold text-secondary" style="font-size: 0.75rem;">Fichier (PDF / DOC)</label>
                                <input type="file" name="fichier_contrat" class="form-control form-control-sm rounded" accept=".pdf,.doc,.docx" required style="font-size: 0.75rem;">
                            </div>
                        </div>
                        <div class="modal-footer border-top py-2 px-3 bg-light">
                            <button type="button" class="btn btn-xs btn-link text-muted text-decoration-none me-auto" data-bs-dismiss="modal" style="font-size: 0.75rem;">Annuler</button>
                            <button type="submit" class="btn btn-xs btn-success px-3 rounded fw-semibold" style="font-size: 0.75rem;">
                                Transmettre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection