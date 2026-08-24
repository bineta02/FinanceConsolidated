@extends('layouts.bailleur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">
                <i class="fas fa-chart-line text-success me-2"></i>Mes investissements & Offres
            </h3>
            <p class="text-muted small mb-0">Suivi des propositions de financement envoyées aux entrepreneurs.</p>
        </div>
    </div>

    @if($investissements->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-hand-holding-usd fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Vous n'avez formulé aucune offre de financement pour le moment.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Projet</th>
                        <th>Montant Proposé</th>
                        <th>Date d'Envoi</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($investissements as $offre)
                        <tr>
                            <td class="fw-bold text-dark">{{ $offre->projet->titre ?? 'N/A' }}</td>
                            <td class="fw-bold text-success">{{ number_format($offre->montant, 0, ',', ' ') }} FCFA</td>
                            <td class="text-muted small">{{ $offre->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($offre->statut == 'acceptee')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-4">Acceptée</span>
                                @elseif($offre->statut == 'refusee')
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-4">Refusée</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1 rounded-4">En attente</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bailleur.projet.show', $offre->projet_id) }}" class="btn btn-sm btn-outline-secondary rounded-3">
                                    <i class="fas fa-eye me-1"></i> Voir Projet
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection