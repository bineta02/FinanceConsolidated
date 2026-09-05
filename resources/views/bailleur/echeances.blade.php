@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Échéances & Remboursements</h3>
        <p class="text-muted small mb-0">Suivi du calendrier de remboursement et des mensualités perçues.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            @if($financements->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Projet / Emprunteur</th>
                                <th>Capital prêté</th>
                                <th>Mensualité estimée</th>
                                <th>Durée</th>
                                <th>Prochaine échéance</th>
                                <th class="text-end pe-4">État</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($financements as $financement)
                                @php
                                    $entrepreneur = $financement->projet->entrepreneur ?? null;
                                    $nomEntrepreneur = $entrepreneur ? trim(($entrepreneur->prenom ?? '') . ' ' . ($entrepreneur->nom ?? '')) : 'Entrepreneur';
                                    
                                    // Calcul de la mensualité indicative : (Capital + Intérêts) / Durée
                                    $totalInteret = $financement->montant_accorde * ($financement->taux_interet / 100);
                                    $mensualite = ($financement->montant_accorde + $totalInteret) / max($financement->duree, 1);
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <strong class="d-block text-dark">{{ $financement->projet->titre ?? 'Projet' }}</strong>
                                        <small class="text-muted"><i class="fas fa-user me-1"></i> {{ $nomEntrepreneur }}</small>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ number_format($mensualite, 0, ',', ' ') }} FCFA / mois</span>
                                    </td>
                                    <td>{{ $financement->duree }} mois</td>
                                    <td>{{ now()->addMonth()->format('05/m/Y') }}</td>
                                    <td class="text-end pe-4">
                                        <span class="badge bg-info text-dark rounded-pill px-3">En cours de remboursement</span>
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
@endsection