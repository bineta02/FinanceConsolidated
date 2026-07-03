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
                        <tr>
                            <td class="fw-bold text-dark">{{ $projet->titre }}</td>
                            <td><span class="badge bg-light text-dark border px-3 py-2 rounded-4">{{ $projet->categorie }}</span></td>
                            <td class="fw-semibold">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</td>
                            <td class="text-success fw-semibold">{{ number_format($projet->montant_collecte, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($projet->statut === 'en_attente')
                                    <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2 rounded-4"> En attente</span>
                                @elseif($projet->statut === 'approuve')
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 rounded-4"> Approuvé</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 rounded-4"> Refusé</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $projet->created_at->format('d/m/Y à H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('entrepreneur.projet.edit', $projet->id) }}" class="btn btn-sm btn-outline-warning rounded-3" title="Modifier le projet">
                                        <i class="fas fa-edit"></i>
                                    </a>

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