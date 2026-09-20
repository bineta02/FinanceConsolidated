@extends('layouts.bailleur')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Échéances & Remboursements</h3>
        <p class="text-muted small mb-0">Suivi du calendrier de remboursement et des mensualités perçues.</p>
    </div>

    <!-- TABLEAU PRINCIPAL (ÉPURÉ) -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if(isset($financements) && $financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Projet / Emprunteur</th>
                                <th>Capital prêté</th>
                                <th>Mensualité estimée</th>
                                <th>Durée & Progression</th>
                                <th>Prochaine échéance</th>
                                <th>État</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financements as $financement)
                                @php
                                    $entrepreneur = $financement->projet->entrepreneur ?? null;
                                    $nomEntrepreneur = $entrepreneur ? trim(($entrepreneur->prenom ?? '') . ' ' . ($entrepreneur->nom ?? '')) : 'Entrepreneur';
                                    
                                    // Prochaine échéance non réglée
                                    $prochaineEcheance = $financement->echeances
                                        ? $financement->echeances->reject(fn($e) => in_array(strtolower($e->statut), ['paye', 'payé', 'regle']))->first()
                                        : null;

                                    // Compter le nombre d'échéances réglées
                                    $echeancesPayeesCount = $financement->echeances
                                        ? $financement->echeances->filter(fn($e) => in_array(strtolower($e->statut), ['paye', 'payé', 'regle']))->count()
                                        : 0;

                                    $totalEcheances = $financement->echeances ? $financement->echeances->count() : 0;

                                    // Calcul de secours pour la mensualité
                                    $totalInteret = $financement->montant_accorde * (($financement->taux_interet ?? 0) / 100);
                                    $mensualiteDefaut = ($financement->montant_accorde + $totalInteret) / max($financement->duree, 1);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <a href="#" class="text-decoration-none text-dark fw-bold d-block" data-bs-toggle="modal" data-bs-target="#modalEcheances{{ $financement->id }}">
                                            {{ $financement->projet->titre ?? 'Projet' }} <i class="fas fa-external-link-alt ms-1 text-muted small"></i>
                                        </a>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $nomEntrepreneur }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">
                                            {{ number_format($prochaineEcheance->montant_prevu ?? $mensualiteDefaut, 0, ',', ' ') }} FCFA / mois
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $echeancesPayeesCount }} / {{ $totalEcheances }} réglée(s)</span>
                                        <div class="progress mt-1" style="height: 6px; width: 100px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalEcheances > 0 ? ($echeancesPayeesCount / $totalEcheances) * 100 : 0 }}%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($prochaineEcheance)
                                            <span class="fw-semibold text-dark">
                                                <i class="far fa-calendar-alt me-1 text-secondary"></i>
                                                {{ \Carbon\Carbon::parse($prochaineEcheance->date_prevu)->format('d/m/Y') }}
                                            </span>
                                        @elseif($totalEcheances > 0 && $echeancesPayeesCount === $totalEcheances)
                                            <span class="text-success small fw-bold"><i class="fas fa-check-circle me-1"></i> Tout réglé</span>
                                        @else
                                            <span class="text-muted small">-- / -- / ----</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($totalEcheances > 0 && $echeancesPayeesCount === $totalEcheances)
                                            <span class="badge bg-success rounded-pill px-3">Remboursé</span>
                                        @elseif($prochaineEcheance)
                                            <span class="badge bg-info text-dark rounded-pill px-3">En cours</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3">Non démarré</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#modalEcheances{{ $financement->id }}">
                                            <i class="fas fa-list me-1"></i> Détails
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-calendar-alt fa-3x mb-3 text-secondary d-block"></i>
                    <h5 class="fw-bold">Aucune échéance en cours</h5>
                    <p class="small mb-0">Le suivi des remboursements apparaîtra ici une fois les contrats de financement validés.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- MODALS DE DÉTAILS (PLACÉS APRÈS LE TABLEAU POUR UN RENDU PROPRE) -->
@if(isset($financements) && $financements->count() > 0)
    @foreach($financements as $financement)
        @php
            $totalInteret = $financement->montant_accorde * (($financement->taux_interet ?? 0) / 100);
            $totalRembourse = $financement->echeances ? $financement->echeances->whereIn('statut', ['paye', 'payé', 'regle'])->sum('montant_prevu') : 0;
        @endphp
        <div class="modal fade" id="modalEcheances{{ $financement->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $financement->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-light border-0">
                        <h5 class="modal-title fw-bold text-dark" id="modalLabel{{ $financement->id }}">
                            Plan de remboursement - {{ $financement->projet->titre ?? 'Projet' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <!-- Résumé rapide en haut du modal -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <small class="text-muted d-block">Capital prêté</small>
                                    <strong class="text-dark">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-success-subtle rounded-3 text-center">
                                    <small class="text-success d-block">Total perçu</small>
                                    <strong class="text-success">{{ number_format($totalRembourse, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-warning-subtle rounded-3 text-center">
                                    <small class="text-warning-emphasis d-block">Reste à percevoir</small>
                                    <strong class="text-dark">{{ number_format(($financement->montant_accorde + $totalInteret) - $totalRembourse, 0, ',', ' ') }} FCFA</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Tableau synthétique des échéances -->
                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>N°</th>
                                        <th>Date prévue</th>
                                        <th>Capital</th>
                                        <th>Intérêts</th>
                                        <th>Montant total</th>
                                        <th class="text-end">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($financement->echeances as $echeance)
                                        <tr>
                                            <td class="fw-bold text-muted">{{ $echeance->numero_echeance }}</td>
                                            <td>{{ \Carbon\Carbon::parse($echeance->date_prevu)->format('d/m/Y') }}</td>
                                            <td>{{ number_format($echeance->montant_capital, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ number_format($echeance->montant_interet, 0, ',', ' ') }} FCFA</td>
                                            <td class="fw-bold text-dark">{{ number_format($echeance->montant_prevu, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-end">
                                                @if(in_array(strtolower($echeance->statut), ['paye', 'payé', 'regle']))
                                                    <span class="badge bg-success rounded-pill px-3">
                                                        <i class="fas fa-check-circle me-1"></i> Payé
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark rounded-pill px-3">
                                                        <i class="fas fa-clock me-1"></i> En attente
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Aucune échéance enregistrée pour ce projet.</td>
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