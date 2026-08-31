@extends('layouts.bailleur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Échéances & Remboursements</h3>
        <p class="text-muted small">Suivi des paiements perçus et du calendrier de remboursement des financements accordés.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4 text-center py-5">
            <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold text-dark">Aucune échéance en cours</h5>
            <p class="text-muted small">Les remboursements s'afficheront ici dès qu'une offre de financement sera acceptée et finalisée.</p>
        </div>
    </div>
</div>
@endsection