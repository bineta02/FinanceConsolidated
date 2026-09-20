@extends('layouts.bailleur')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Garanties & Sûretés</h3>
        <p class="text-muted small mb-0">Consultez les garanties engagées par les emprunteurs pour sécuriser vos financements.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Projet / Emprunteur</th>
                                <th>Capital prêté</th>
                                <th>Type de garantie</th>
                                <th>Valeur estimée</th>
                                <th>Statut garantie</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financements as $financement)
                                @php
                                    $entrepreneur = $financement->projet->entrepreneur ?? null;
                                    $nomEntrepreneur = $entrepreneur ? trim(($entrepreneur->prenom ?? '') . ' ' . ($entrepreneur->nom ?? '')) : 'Entrepreneur';
                                    $garanties = $financement->garanties;
                                    $nombreGaranties = $garanties ? $garanties->count() : 0;
                                    $valeurTotale = $garanties ? $garanties->sum('valeur') : 0;
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <a href="#" class="text-decoration-none text-dark fw-bold d-block" data-bs-toggle="modal" data-bs-target="#modalGaranties{{ $financement->id }}">
                                            {{ $financement->projet->titre ?? 'Projet' }} <i class="fas fa-shield-alt ms-1 text-primary small"></i>
                                        </a>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $nomEntrepreneur }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        @if($nombreGaranties > 0)
                                            <span class="badge bg-light text-dark border me-1">
                                                {{ $garanties->first()->type ?? 'Garantie' }}
                                            </span>
                                            @if($nombreGaranties > 1)
                                                <span class="badge bg-secondary">+{{ $nombreGaranties - 1 }} autre(s)</span>
                                            @endif
                                        @else
                                            <span class="text-muted small">Aucune garantie enregistrée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">
                                            {{ number_format($valeurTotale, 0, ',', ' ') }} FCFA
                                        </span>
                                    </td>
                                    <td>
                                        @if($nombreGaranties > 0)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                                <i class="fas fa-check-circle me-1"></i> Saisie / Validée
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-3">
                                                <i class="fas fa-exclamation-triangle me-1"></i> En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalGaranties{{ $financement->id }}">
                                            <i class="fas fa-shield-alt me-1"></i> Détails
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-shield-alt fa-3x mb-3 text-secondary d-block"></i>
                    <h5 class="fw-bold">Aucune garantie enregistrée</h5>
                    <p class="small mb-0">Les garanties apportées par les porteurs de projet s'afficheront ici.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MODALS DE DÉTAILS DES GARANTIES -->
@if(isset($financements) && $financements->count() > 0)
    @foreach($financements as $financement)
        <div class="modal fade" id="modalGaranties{{ $financement->id }}" tabindex="-1" aria-labelledby="modalGarantiesLabel{{ $financement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-light border-0">
                        <h5 class="modal-title fw-bold text-dark" id="modalGarantiesLabel{{ $financement->id }}">
                            Garanties pour {{ $financement->projet->titre ?? 'Projet' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Type</th>
                                        <th>Description / Intitulé</th>
                                        <th>Valeur Estimée</th>
                                        <th>Document justificatif</th>
                                        <th class="text-end">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($financement->garanties as $garantie)
                                        <tr>
                                            <td class="fw-bold text-dark">{{ $garantie->type ?? 'N/A' }}</td>
                                            <td>{{ $garantie->description ?? 'Pas de description' }}</td>
                                            <td class="fw-bold text-success">{{ number_format($garantie->valeur ?? 0, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @if(!empty($garantie->document_url))
                                                    <a href="{{ asset($garantie->document_url) }}" target="_blank" class="btn btn-xs btn-outline-secondary rounded-pill">
                                                        <i class="fas fa-file-pdf me-1 text-danger"></i> Voir document
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Aucun fichier</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <span class="badge bg-success rounded-pill px-3">Valide</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                Aucune garantie détaillée renseignée pour ce financement.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
@endsection