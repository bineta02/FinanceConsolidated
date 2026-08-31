@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Mes Investissements & Propositions</h3>
            <p class="text-muted small mb-0">Suivi des fonds engagés et de l'état des propositions soumises aux porteurs de projets.</p>
        </div>
        <a href="{{ route('bailleur.dashboard') }}" class="btn btn-sm btn-outline-success rounded-4">
            <i class="fas fa-plus me-1"></i> Explorer d'autres projets
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-3">
            <i class="fas fa-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Projet / Entrepreneur</th>
                            <th>Montant Proposé</th>
                            <th>Taux / Durée</th>
                            <th>Date d'offre</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($financements as $financement)
                            <tr>
                                <td class="ps-4">
                                    <strong class="d-block text-dark">{{ $financement->projet->titre ?? 'Projet Agro/Business' }}</strong>
                                    <small class="text-muted">Porteur ID : #{{ $financement->id_utilisateur }}</small>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($financement->montant_accorde, 0, ',', ' ') }} FCFA</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $financement->taux_interet }}% / {{ $financement->duree }} mois</span>
                                </td>
                                <td>{{ $financement->created_at ? $financement->created_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($financement->statut == 'en_attente')
                                        <span class="badge bg-warning text-dark rounded-pill px-3">En attente</span>
                                    @elseif($financement->statut == 'valide' || $financement->statut == 'accepte')
                                        <span class="badge bg-success rounded-pill px-3">Accepté</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3">{{ ucfirst($financement->statut) }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    @if($financement->projet)
                                        <a href="{{ route('bailleur.projet.show', $financement->projet->id) }}" class="btn btn-sm btn-light border rounded-3">
                                            <i class="fas fa-eye me-1"></i> Voir Projet
                                        </a>
                                    @else
                                        <span class="text-muted small">N/A</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 text-secondary d-block"></i>
                                    Vous n'avez encore soumis aucune offre de financement.
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