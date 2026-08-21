@extends('layouts.entrepreneur')

@section('content')
<div class="card-modern p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark m-0">
                <i class="fas fa-bullhorn text-success me-2"></i>Offres de financement disponibles
            </h3>
            <p class="text-muted small mb-0">Consultez les appels d'offres et programmes de financement proposés par les bailleurs.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(!isset($offres) || $offres->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">Aucune offre de financement n'est disponible pour le moment.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($offres as $offre)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 p-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-success-subtle text-success border border-success rounded-4 px-3 py-1">
                                {{ $offre->secteur ?? 'Tous secteurs' }}
                            </span>
                            <small class="text-muted"><i class="fas fa-clock me-1"></i>{{ $offre->created_at ? $offre->created_at->format('d/m/Y') : '' }}</small>
                        </div>
                        
                        <h5 class="fw-bold text-dark mb-2">{{ $offre->titre }}</h5>
                        <p class="text-muted small mb-3">{{ Str::limit($offre->description ?? '', 100) }}</p>
                        
                        <div class="mb-2">
                            <small class="text-muted d-block">Bailleur / Organisme :</small>
                            <span class="fw-semibold text-dark">{{ $offre->bailleur->nom ?? 'Bailleur Partenaire' }}</span>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted d-block">Montant / Enveloppe :</small>
                            <span class="fs-6 fw-bold text-success">{{ number_format($offre->montant ?? 0, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                            <small class="text-danger fw-semibold">
                                Limite : {{ isset($offre->date_limite) ? \Carbon\Carbon::parse($offre->date_limite)->format('d/m/Y') : 'Non précisée' }}
                            </small>
                            <a href="#" class="btn btn-sm btn-green px-3 rounded-3">
                                Postuler
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection