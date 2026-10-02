@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0">
            <i class="fas fa-folder text-success me-2"></i>Mes projets soumis
        </h3>
        <a href="{{ route('entrepreneur.projet.create') }}" class="btn-green">
            <i class="fas fa-plus-circle me-2"></i>Déposer un nouveau projet
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($projets->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Vous n'avez pas encore soumis de projet.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Titre du projet</th>
                        <th>Catégorie</th>
                        <th>Montant Recherché</th>
                        <th>Fonds Collectés</th>
                        <th>Statut</th>
                        <th>Date de soumission</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projets as $projet)
                        @php
                            $montantCollecte = $projet->montant_collecte ?? $projet->fonds_collectes ?? 0;
                            $montantDemande = $projet->montant_demande ?? $projet->montant_recherche ?? 0;
                            
                            // Vérification si le projet est financé ou a un financement actif
                            $aDesFinancements = $projet->financements && $projet->financements->count() > 0;
                            $estTotalementFinance = ($montantCollecte >= $montantDemande && $montantDemande > 0) || in_array(strtolower($projet->statut), ['finance', 'financé']);
                            $estPartiellementFinance = $montantCollecte > 0 || $aDesFinancements;
                        @endphp
                        <tr>
                            <td class="fw-bold text-dark">{{ $projet->titre }}</td>
                            <td><span class="badge bg-light text-dark border px-3 py-2 rounded-4">{{ $projet->categorie }}</span></td>
                            <td class="fw-semibold">{{ number_format($montantDemande, 0, ',', ' ') }} FCFA</td>
                            <td>
                                <span class="fw-bold text-success">
                                    {{ number_format($montantCollecte, 0, ',', ' ') }} FCFA
                                </span>
                            </td>
                            <td>
                                @if($estTotalementFinance)
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-4">
                                        <i class="fas fa-check-circle me-1"></i> Financé
                                    </span>
                                @elseif($estPartiellementFinance)
                                    <span class="badge bg-info-subtle text-info border border-info px-3 py-2 rounded-4">
                                        <i class="fas fa-chart-line me-1"></i> Financé
                                    </span>
                                @elseif(in_array(strtolower($projet->statut), ['approuve', 'approuvé', 'valide']))
                                    <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 rounded-4">
                                        <i class="fas fa-thumbs-up me-1"></i> Approuvé
                                    </span>
                                @elseif(in_array(strtolower($projet->statut), ['refuse', 'refusé']))
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-4">
                                        <i class="fas fa-times-circle me-1"></i> Refusé
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-4">
                                        <i class="fas fa-clock me-1"></i> En attente
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $projet->created_at ? $projet->created_at->format('d/m/Y à H:i') : '--' }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <!-- Bouton Voir les détails -->
                                    <a href="{{ route('entrepreneur.projet.show', $projet->id) }}" class="btn btn-sm btn-outline-info rounded-3" title="Voir les détails">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('entrepreneur.projet.edit', $projet->id) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Modifier le projet">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('entrepreneur.projet.destroy', $projet->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce projet ?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Supprimer le projet">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection