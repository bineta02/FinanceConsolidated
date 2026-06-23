@extends('layouts.entrepreneur')

@section('content')
<div>
    <h3 class="fw-bold mb-4">
        <i class="fas fa-chart-line text-success me-2"></i>Tableau de bord
    </h3>
    
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card">
                <small class="text-muted">Secteur d'activité</small>
                <h4 class="fw-bold text-success mt-1">{{ $entrepreneur->secteur_dactivite ?? 'Non spécifié' }}</h4>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <small class="text-muted">Expérience</small>
                <h2 class="fw-bold mt-1">{{ $entrepreneur->annees_experiences ?? 0 }} ans</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <small class="text-muted">Fonds collectés</small>
                <h2 class="fw-bold text-success mt-1">0 FCFA</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <small class="text-muted">Reste à rembourser</small>
                <h2 class="fw-bold text-warning mt-1">0 FCFA</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card-modern p-3">
                <h5>Progression des financements</h5>
                <canvas id="progressionChart" width="400" height="200"></canvas>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card-modern p-3">
                <h5>Conseil IA</h5>
                <div class="alert alert-success bg-soft-green">
                    <i class="fas fa-robot text-success"></i> Complétez votre profil et déposez votre premier projet pour attirer les investisseurs.
                </div>
                <hr>
                <h6>Description du profil</h6>
                <p class="text-muted small">
                    {{ $entrepreneur->description_profil ?? 'Aucune description fournie pour le moment.' }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Petit script Chart.js temporaire pour éviter les erreurs d'initialisation
    const ctx = document.getElementById('progressionChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Exemple Projet'],
                datasets: [{
                    label: 'Objectif (FCFA)',
                    data: [5000000],
                    backgroundColor: '#e0ede7',
                    borderRadius: 10
                }]
            },
            options: { responsive: true }
        });
    }
</script>
@endsection