@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Explorer & Investir</h3>
        <p class="text-muted small">Découvrez les opportunités de projets nécessitant un financement.</p>
    </div>

    <div class="row g-4">
        @forelse($projets as $projet)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-light text-dark border mb-2">{{ $projet->categorie }}</span>
                        <h5 class="fw-bold text-dark mb-2">{{ $projet->titre }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($projet->description, 100) }}</p>
                    </div>
                    <div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="small text-muted">Montant demandé :</span>
                            <span class="fw-bold text-success">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <a href="{{ route('bailleur.show_projet', $projet->id) }}" class="btn btn-outline-success w-100 rounded-3">
                            <i class="fas fa-eye me-1"></i> Consulter le projet
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border rounded-4 text-center py-4 text-muted">
                    Aucun projet disponible pour le moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection