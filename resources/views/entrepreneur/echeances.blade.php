@extends('layouts.entrepreneur')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 font-weight-bold text-dark">Échéances & remboursements</h2>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small">Prochaine échéance</h6>
                    <p class="h3 font-weight-bold text-danger mb-0">-- / -- / ----</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small">Montant total remboursé</h6>
                    <p class="h3 font-weight-bold text-success mb-0">0 FCFA</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 text-secondary">Calendrier des remboursements</h5>
        </div>
        <div class="card-body text-center py-5">
            <div class="text-muted">
                <i class="fas fa-calendar-times fa-2x mb-3 text-secondary"></i>
                <p class="mb-0">Aucun plan de remboursement ou échéance planifiée pour le moment.</p>
            </div>
        </div>
    </div>
</div>
@endsection