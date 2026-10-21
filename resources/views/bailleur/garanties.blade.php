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
                                a@extends('layouts.bailleur')

@section('content')
<div class="container-fluid py-4 px-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Garanties reçues</h3>
            <p class="text-muted small mb-0">Examinez et validez les garanties déposées par les porteurs de projets.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light">
            <h6 class="card-title mb-0 fw-bold text-dark">
                <i class="fas fa-shield-alt text-success me-2"></i>Liste des garanties par financement
            </h6>
        </div>

        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3">Projet & Entrepreneur</th>
                                <th class="py-3">Type de Garantie</th>
                                <th class="py-3">Valeur Estimée</th>
                                <th class="py-3">Document</th>
                                <th class="py-3">Statut</th>
                                <th class="text-end pe-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @foreach($financements as $financement)
                                @foreach($financement->garanties as $garantie)
                                    @php
                                        $entrepreneurUser = $financement->projet->entrepreneur->user ?? $financement->projet->entrepreneur->utilisateur ?? null;
                                        $nomEntrepreneur = $entrepreneurUser ? trim(($entrepreneurUser->prenom ?? '') . ' ' . ($entrepreneurUser->nom ?? '')) : 'Entrepreneur';
                                    @endphp
                                    <tr>
                                        <!-- Projet & Entrepreneur -->
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark mb-1">{{ $financement->projet->titre ?? 'Projet' }}</div>
                                            <div class="text-muted small">
                                                <i class="fas fa-user me-1"></i>{{ $nomEntrepreneur }}
                                            </div>
                                        </td>

                                        <!-- Type -->
                                        <td class="py-3">
                                            <span class="fw-semibold text-secondary">
                                                <i class="fas fa-shield-alt text-success me-1"></i>{{ $garantie->type_garantie }}
                                            </span>
                                        </td>

                                        <!-- Valeur -->
                                        <td class="py-3">
                                            <span class="fw-bold text-dark">
                                                {{ number_format($garantie->valeur_estime, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                                            </span>
                                        </td>

                                        <!-- Document -->
                                        <td class="py-3">
                                            @if($garantie->document_url)
                                                <a href="{{ asset('storage/' . $garantie->document_url) }}" target="_blank" class="btn btn-sm btn-light border rounded-3 text-secondary">
                                                    <i class="fas fa-file-pdf text-danger me-1"></i> Consulter
                                                </a>
                                            @else
                                                <span class="text-muted small fst-italic">Aucun fichier</span>
                                            @endif
                                        </td>

                                        <!-- Statut -->
                                        <td class="py-3">
                                            @if(in_array(strtolower($garantie->statut), ['valide', 'validé']))
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1">
                                                    <i class="fas fa-check-circle me-1"></i> Validée
                                                </span>
                                            @elseif(in_array(strtolower($garantie->statut), ['rejete', 'rejeté']))
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3 py-1">
                                                    <i class="fas fa-times-circle me-1"></i> Rejetée
                                                </span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1">
                                                    <i class="fas fa-clock me-1"></i> En attente
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td class="text-end pe-4 py-3">
                                            <div class="d-inline-flex gap-1">
                                                <!-- Valider -->
                                                <form action="{{ route('bailleur.garanties.updateStatut', $garantie->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="valide">
                                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Valider la garantie" onclick="return confirm('Valider cette garantie ?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                <!-- Rejeter -->
                                                <form action="{{ route('bailleur.garanties.updateStatut', $garantie->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="statut" value="rejete">
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Rejeter la garantie" onclick="return confirm('Rejeter cette garantie ?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5 px-4">
                    <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                        <i class="fas fa-shield-alt fa-2x text-secondary"></i>
                    </div>
                    <h6 class="fw-bold text-dark">Aucune garantie déposée pour le moment</h6>
                    <p class="small text-muted mb-0">Les garanties soumises par les entrepreneurs apparaîtront ici pour validation.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection        </span>
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