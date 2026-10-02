@extends('layouts.bailleur')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Explorer & Investir</h3>
        <p class="text-muted small mb-0">Découvrez les opportunités d'investissement et filtrez selon vos secteurs de prédilection.</p>
    </div>

    <!-- BOUTONS DE FILTRES PAR CATÉGORIE -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <button type="button" class="btn btn-sm btn-success rounded-pill px-3 filter-btn active" data-category="all">
            <i class="fas fa-th-large me-1"></i> Toutes les catégories
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 filter-btn" data-category="Agriculture">
            <i class="fas fa-leaf me-1"></i> Agriculture
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 filter-btn" data-category="Technologie">
            <i class="fas fa-laptop-code me-1"></i> Technologie
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 filter-btn" data-category="Commerce">
            <i class="fas fa-shopping-cart me-1"></i> Commerce
        </button>
        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 filter-btn" data-category="Énergie">
            <i class="fas fa-bolt me-1"></i> Énergie
        </button>
    </div>

    <!-- LISTE DES PROJETS -->
    <div class="row g-4" id="projetsContainer">
        @forelse($projets as $projet)
            <div class="col-md-6 col-lg-4 projet-card" data-category="{{ $projet->categorie }}">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">
                                {{ $projet->categorie }}
                            </span>
                            <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $projet->region ?? 'Sénégal' }}</small>
                        </div>
                        <h5 class="fw-bold text-dark mb-2">{{ $projet->titre }}</h5>
                        <p class="text-muted small flex-grow-1">{{ Str::limit($projet->description, 100) }}</p>
                        
                        <div class="mt-3 pt-3 border-top">
                            <div class="d-flex justify-content-between small mb-1">
                                <span class="text-muted">Objectif :</span>
                                <strong class="text-dark">{{ number_format($projet->montant_demande, 0, ',', ' ') }} FCFA</strong>
                            </div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-muted">Collecté :</span>
                                <strong class="text-success">{{ number_format($projet->montant_collecte ?? 0, 0, ',', ' ') }} FCFA</strong>
                            </div>
                            <a href="{{ route('bailleur.show_projet', $projet->id) }}" class="btn btn-outline-primary w-100 rounded-3 mt-2">
                                <i class="fas fa-eye me-1"></i> Examiner le projet
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                <h5>Aucun projet disponible</h5>
            </div>
        @endforelse
    </div>
</div>

<!-- SCRIPT DE FILTRAGE INSTANTANÉ PAR CATEGORIE -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const projetCards = document.querySelectorAll('.projet-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Mettre à jour l'apparence des boutons
            filterButtons.forEach(btn => {
                btn.classList.remove('btn-success', 'active');
                btn.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-success', 'active');

            const selectedCategory = this.getAttribute('data-category');

            // Filtrer les cartes
            projetCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (selectedCategory === 'all' || cardCategory.toLowerCase() === selectedCategory.toLowerCase()) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection