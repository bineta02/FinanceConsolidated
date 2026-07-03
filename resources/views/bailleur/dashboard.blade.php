@extends('layouts.bailleur') 
@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0">
            <i class="fas fa-hand-holding-usd text-success me-2"></i>Opportunités d'Investissement
        </h3>
        <span class="badge bg-success px-3 py-2 rounded-4 text-white">Espace Investisseur</span>
    </div>

    <p class="text-muted mb-4">Découvrez les projets en quête de financement et proposez vos offres d'investissement.</p>

    @if($projetsDisponibles->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucun projet n'est disponible pour le financement en ce moment.</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($projetsDisponibles as $projet)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold text-dark mb-0">{{ $projet->titre }}</h5>
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-4 small">{{ $projet->categorie }}</span>
                            </div>
                            
                            <p class="text-muted small text-truncate-3 flex-grow-1 mb-4">
                                {{ Str::limit($projet->description, 120, '...') }}
                            </p>

                            <div class="bg-light p-3 rounded-4 mb-3">
                                <div class="d-flex justify-content-between mb-1 small">
                                    <span class="text-secondary">Objectif :</span>
                                    <span class="fw-bold text-dark">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-secondary">Collecté :</span>
                                    <span class="fw-bold text-success">{{ number_format($projet->montant_collecte, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>

                            <a href="{{ route('bailleur.projet.show', $projet->id) }}" class="btn btn-success w-100 rounded-4 py-2 mt-auto">
    <i class="fas fa-eye me-2"></i>Analyser le projet
</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection