@extends('layouts.entrepreneur')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Échéances & remboursements</h3>
            <p class="text-muted small mb-0">Consultez votre plan de remboursement et l'état de vos échéances.</p>
        </div>
    </div>

    {{-- ALERTES DE SUCCÈS OU D'ERREUR --}}
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 mb-4">
            <i class="fas fa-exclamation-triangle me-1"></i> {{ session('error') }}
        </div>
    @endif

    @php
        $totalRembourse = isset($echeances) ? $echeances->whereIn('statut', ['paye', 'payé', 'regle'])->sum('montant_prevu') : 0;
        $prochaineEcheance = isset($echeances) ? $echeances->whereNotIn('statut', ['paye', 'payé', 'regle'])->first() : null;
        $resteAPayer = isset($financement) ? ($financement->montant_accorde - $totalRembourse) : 0;
    @endphp

    <!-- CARTES STATISTIQUES -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-danger-subtle p-3 me-3 text-danger">
                        <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small mb-1 fw-bold">Prochaine échéance</h6>
                        <h4 class="fw-bold text-dark mb-0">
                            {{ $prochaineEcheance ? \Carbon\Carbon::parse($prochaineEcheance->date_prevu)->format('d/m/Y') : '-- / -- / ----' }}
                        </h4>
                        @if($prochaineEcheance)
                            <small class="text-danger fw-semibold">{{ number_format($prochaineEcheance->montant_prevu, 0, ',', ' ') }} FCFA</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success-subtle p-3 me-3 text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small mb-1 fw-bold">Montant remboursé</h6>
                        <h4 class="fw-bold text-success mb-0">{{ number_format($totalRembourse, 0, ',', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-warning-subtle p-3 me-3 text-warning">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="text-muted text-uppercase small mb-1 fw-bold">Reste à payer</h6>
                        <h4 class="fw-bold text-dark mb-0">{{ number_format($resteAPayer, 0, ',', ' ') }} FCFA</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLEAU DU CALENDRIER DE REMBOURSEMENT -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom-0">
            <h5 class="card-title mb-0 fw-bold text-dark">Calendrier des remboursements</h5>
        </div>
        <div class="card-body p-0">
            @if(isset($echeances) && $echeances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">N°</th>
                                <th>Date prévue</th>
                                <th>Capital</th>
                                <th>Intérêts</th>
                                <th>Montant total</th>
                                <th>Statut</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($echeances as $echeance)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $echeance->numero_echeance }}</td>
                                    <td>
                                        <i class="far fa-calendar me-2 text-secondary"></i>
                                        {{ \Carbon\Carbon::parse($echeance->date_prevu)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ number_format($echeance->montant_capital, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ number_format($echeance->montant_interet, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($echeance->montant_prevu, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        @if(in_array(strtolower($echeance->statut), ['paye', 'payé', 'regle']))
                                            <span class="badge bg-success rounded-pill px-3">
                                                <i class="fas fa-check-circle me-1"></i> Payé
                                            </span>
                                        @elseif(in_array(strtolower($echeance->statut), ['en_retard', 'retard']))
                                            <span class="badge bg-danger rounded-pill px-3">
                                                <i class="fas fa-exclamation-circle me-1"></i> En retard
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark rounded-pill px-3">
                                                <i class="fas fa-clock me-1"></i> En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        @if(!in_array(strtolower($echeance->statut), ['paye', 'payé', 'regle']))
                                            <form action="{{ route('entrepreneur.echeances.payer', $echeance->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary rounded-3" onclick="return confirm('Confirmez-vous le paiement de cette mensualité ?')">
                                                    <i class="fas fa-credit-card me-1"></i> Payer
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted small"><i class="fas fa-check text-success me-1"></i> Réglé</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-muted py-5">
                    <i class="fas fa-calendar-times fa-3x mb-3 text-secondary d-block"></i>
                    <h5 class="fw-bold">Aucun plan de remboursement</h5>
                    <p class="small mb-0">Aucune échéance planifiée pour le moment.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection