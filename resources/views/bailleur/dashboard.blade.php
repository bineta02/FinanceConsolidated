@extends('layouts.bailleur') 

@section('content')
<div class="container-fluid py-2">

    <!-- EN-TÊTE DU TABLEAU DE BORD -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                <i class="fas fa-chart-line text-success me-2"></i>Tableau de bord
            </h3>
            <p class="text-muted small mb-0">Vue d'ensemble de vos investissements et opportunités en cours.</p>
        </div>
        <span class="badge bg-success px-3 py-2 rounded-4 text-white">Espace Investisseur</span>
    </div>

    <!-- CARTES STATISTIQUES (KPIs) -->
    <div class="row g-3 mb-4">
        <!-- Carte 1 : Capital Disponible & Capacité -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-semibold">Capital Disponible</span>
                        <h4 class="fw-bold text-success mb-0">
                            {{ number_format($capitalDisponible ?? 0, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small>
                        </h4>
                    </div>
                    <div class="bg-success-subtle text-success p-3 rounded-4">
                        <i class="fas fa-coins fa-2x"></i>
                    </div>
                </div>
                <small class="text-muted d-block mt-1">
                    Capacité totale : {{ number_format($bailleur->capacite_financement ?? 0, 0, ',', ' ') }} FCFA
                </small>
                <button class="btn btn-sm btn-link text-success p-0 mt-2 text-start text-decoration-none fw-semibold" data-bs-toggle="modal" data-bs-target="#modalCapacite">
                    <i class="fas fa-edit me-1"></i> Modifier la capacité
                </button>
            </div>
        </div>

        <!-- Carte 2 : Capital Total Investi -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-semibold">Total investi</span>
                        <h4 class="fw-bold text-primary mb-0">
                            {{ number_format($totalInvesti ?? 0, 0, ',', ' ') }} <small class="fs-6 text-muted">FCFA</small>
                        </h4>
                    </div>
                    <div class="bg-primary-subtle text-primary p-3 rounded-4">
                        <i class="fas fa-wallet fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 3 : Projets Financés -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-semibold">Projets financés</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $projetsFinancesCount ?? 0 }}</h3>
                    </div>
                    <div class="bg-info-subtle text-info p-3 rounded-4">
                        <i class="fas fa-folder-check fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte 4 : Contrats & Engagements -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-semibold">Contrats engagés</span>
                        <h3 class="fw-bold text-dark mb-0">{{ $contratsActifs ?? 0 }}</h3>
                    </div>
                    <div class="bg-warning-subtle text-warning-emphasis p-3 rounded-4">
                        <i class="fas fa-file-signature fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION OPPORTUNITÉS D'INVESTISSEMENT -->
    <div class="card-modern p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-dark m-0">
                <i class="fas fa-hand-holding-usd text-success me-2"></i>Opportunités d'Investissement
            </h4>
        </div>

        <p class="text-muted mb-4">Découvrez les projets en quête de financement et proposez vos offres d'investissement.</p>

        <!-- BARRE DE RECHERCHE ET FILTRES DYNAMIQUES -->
        @if(isset($projetsDisponibles) && !$projetsDisponibles->isEmpty())
            @php
                $categories = $projetsDisponibles->pluck('categorie')->unique()->filter();
            @endphp
            
            <div class="bg-light p-3 rounded-4 mb-4 border">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0 rounded-start-4 ps-3">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control bg-white border-0 rounded-end-4 py-2" placeholder="Rechercher un projet par titre, mots-clés...">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <select id="categorySelect" class="form-select bg-white border-0 rounded-4 py-2">
                            <option value="all">Toutes les catégories</option>
                            @foreach($categories as $cat)
                                <option value="{{ strtolower($cat) }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="button" id="resetFiltersBtn" class="btn btn-outline-secondary w-100 rounded-4 py-2">
                            <i class="fas fa-sync-alt me-1"></i> Effacer
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if(!isset($projetsDisponibles) || $projetsDisponibles->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted fs-5">Aucun projet n'est disponible pour le financement en ce moment.</p>
            </div>
        @else
            <!-- MESSAGE SI AUCUN RÉSULTAT -->
            <div id="noResultsMessage" class="text-center py-5 d-none">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted fs-5">Aucun projet ne correspond à votre recherche.</p>
            </div>

            <!-- GRILLE DES PROJETS -->
            <div class="row row-cols-1 row-cols-md-2 g-4" id="projetsContainer">
                @foreach($projetsDisponibles as $projet)
                    <div class="col projet-item" 
                         data-titre="{{ strtolower($projet->titre) }}" 
                         data-description="{{ strtolower($projet->description) }}" 
                         data-categorie="{{ strtolower($projet->categorie) }}">
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
                                        <span class="fw-bold text-success">{{ number_format($projet->montant_collecte ?? 0, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                </div>

                                <a href="{{ route('bailleur.show_projet', $projet->id) }}" class="btn btn-success w-100 rounded-4 py-2 mt-auto">
                                    <i class="fas fa-eye me-2"></i>Analyser le projet
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- MODAL MODIFIER LA CAPACITÉ DE FINANCEMENT -->
<div class="modal fade" id="modalCapacite" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Définir votre capacité de financement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('bailleur.update_capacite') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label class="form-label fw-semibold">Capacité totale de financement (FCFA)</label>
                    <div class="input-group">
                        <input type="number" name="capacite_financement" class="form-control rounded-start-3" value="{{ $bailleur->capacite_financement ?? 0 }}" required min="0" step="50000">
                        <span class="input-group-text rounded-end-3">FCFA</span>
                    </div>
                    <small class="text-muted d-block mt-2">Ce montant représente le budget total que vous souhaitez allouer aux investissements.</small>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success rounded-3 px-4">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const resetBtn = document.getElementById('resetFiltersBtn');
    const projetItems = document.querySelectorAll('.projet-item');
    const noResultsMessage = document.getElementById('noResultsMessage');

    function applyFilters() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedCat = categorySelect ? categorySelect.value.toLowerCase() : 'all';
        let visibleCount = 0;

        projetItems.forEach(item => {
            const titre = item.getAttribute('data-titre') || '';
            const description = item.getAttribute('data-description') || '';
            const categorie = item.getAttribute('data-categorie') || '';

            const matchSearch = titre.includes(query) || description.includes(query);
            const matchCategory = (selectedCat === 'all') || (categorie === selectedCat);

            if (matchSearch && matchCategory) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (noResultsMessage) {
            noResultsMessage.classList.toggle('d-none', visibleCount > 0);
        }
    }

    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (categorySelect) categorySelect.addEventListener('change', applyFilters);
    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (categorySelect) categorySelect.value = 'all';
            applyFilters();
        });
    }
});
</script>
@endsection