@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">
                <i class="fas fa-hand-holding-usd text-success me-2"></i>Financements reçus
            </h3>
            <p class="text-muted small mb-0">Historique et suivi des financements obtenus pour vos projets.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($financements->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-coins fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucun financement reçu pour le moment.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Projet</th>
                        <th>Bailleur</th>
                        <th>Montant Accordé</th>
                        <th>Statut</th>
                        <th>Date de Validation</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($financements as $financement)
                        <tr>
                            <td class="fw-bold text-dark">{{ $financement->projet->titre ?? 'N/A' }}</td>
                            <td>{{ $financement->bailleur->nom ?? 'Bailleur Partenaire' }}</td>
                            <td class="fw-bold text-success">{{ number_format($financement->montant, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-4">
                                    <i class="fas fa-check-circle me-1"></i> Accordé
                                </span>
                            </td>
                            <td class="text-muted small">{{ $financement->updated_at->format('d/m/Y') }}</td>
                            <td class="text-end">
                                <a href="{{ route('entrepreneur.projet.show', $financement->projet_id) }}" class="btn btn-sm btn-outline-success rounded-3">
                                    <i class="fas fa-eye me-1"></i> Voir le projet
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