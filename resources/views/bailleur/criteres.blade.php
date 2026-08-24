@extends('layouts.bailleur')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0"><i class="fas fa-sliders-h text-success me-2"></i>Mes critères & Profil</h3>
        <a href="{{ route('bailleur.criteres.edit') }}" class="btn btn-green rounded-4">
            <i class="fas fa-edit me-1"></i> Modifier le profil & critères
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-4 mb-4 shadow-sm">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <!-- Secteurs d'intérêt -->
        <div class="col-md-6">
            <div class="card-modern p-4 h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-industry text-success me-2"></i>Secteurs d'intérêt</h5>
                <hr class="text-muted opacity-25">
                <div class="mb-3">
                    <span class="text-muted small d-block">Secteur préféré actuel :</span>
                    <span class="fs-5 fw-bold text-dark">{{ $bailleur->secteurs_preferes ?? 'Tous les secteurs' }}</span>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="col-md-6">
            <div class="card-modern p-4 h-100">
                <h5 class="fw-bold text-dark mb-3"><i class="fas fa-file-contract text-success me-2"></i>Documents & Conformité</h5>
                <hr class="text-muted opacity-25">
                @if(!empty($bailleur->document_agrement))
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                        <div>
                            <span class="fw-bold text-dark d-block">Document d'agrément</span>
                            <a href="{{ asset('storage/' . $bailleur->document_agrement) }}" target="_blank" class="small text-success fw-bold text-decoration-none">
                                <i class="fas fa-download me-1"></i>Télécharger / Visualiser
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-muted small m-0">
                        <i class="fas fa-exclamation-circle text-warning me-1"></i> Aucun document d'agrément n'a été fourni.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection