@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Garanties & Contrats</h3>
        <p class="text-muted small">Gestion des documents juridiques, garanties et contrats de prêt d'honneur.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 text-center py-5">
            <i class="fas fa-file-contract fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold text-dark">Aucun contrat actif</h5>
            <p class="text-muted small">Les garanties et contrats signés seront générés et accessibles dans cet espace.</p>
        </div>
    </div>
</div>
@endsection