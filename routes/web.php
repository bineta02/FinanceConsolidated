<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EntrepreneurController;
use App\Http\Controllers\BailleurController;
use App\Http\Controllers\OffreController;

// --- PAGE D'ACCUEIL / LANDING PAGE ---
Route::get('/', [AuthController::class, 'verification'])->name('login');

// --- TRAITEMENT AUTHENTIFICATION (MODALS) ---
Route::post('/inscription', [AuthController::class, 'register'])->name('register.submit');
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit');
Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout');


// --- ESPACES SÉCURISÉS & COMPARTIMENTÉS PAR RÔLE ---
Route::middleware(['auth'])->group(function () {

    // Espace sécurisé strictement réservé aux Entrepreneurs
    Route::middleware(['role:entrepreneur'])->group(function () {
            
        Route::get('/entrepreneur/dashboard', [DashboardController::class, 'entrepreneurIndex'])->name('dashboard');

        // --- GESTION DES PROJETS (CRUD COMPLET) ---
        Route::get('/entrepreneur/projet', [ProjetController::class, 'index'])->name('entrepreneur.projet.index');
        Route::get('/entrepreneur/projet/creer', [ProjetController::class, 'create'])->name('entrepreneur.projet.create');
        Route::post('/entrepreneur/projet/enregistrer', [ProjetController::class, 'store'])->name('entrepreneur.projet.store');
        Route::get('/projet/{id}', [ProjetController::class, 'show'])->name('entrepreneur.projet.show');
                
        // Routes de gestion (Modifier, Supprimer projet & document) :
        Route::get('/entrepreneur/projet/{id}/modifier', [ProjetController::class, 'edit'])->name('entrepreneur.projet.edit');
        Route::put('/entrepreneur/projet/{id}/mettre-a-jour', [ProjetController::class, 'update'])->name('entrepreneur.projet.update');
        Route::delete('/entrepreneur/projet/{id}/supprimer', [ProjetController::class, 'destroy'])->name('entrepreneur.projet.destroy');
        Route::get('/entrepreneur/projet/{id}/document/supprimer', [ProjetController::class, 'destroyDocument'])->name('entrepreneur.projet.document.destroy');

                
        // --- GESTION DU PROFIL ---
        Route::get('/entrepreneur/profil/modifier', [EntrepreneurController::class, 'edit'])->name('entrepreneur.profil.edit');
        Route::put('/entrepreneur/profil/mettre-a-jour', [EntrepreneurController::class, 'update'])->name('entrepreneur.profil.update');
                
                
        // --- ONGLETS COMPLEMENTAIRES ---
        // Route ajoutée pour les offres de financement :
        Route::get('/entrepreneur/offres-financement', [EntrepreneurController::class, 'financements'])->name('entrepreneur.financements.index');
        Route::get('/offres-financement', [OffreController::class, 'indexEntrepreneur'])->name('bailleur.offres.index');
        Route::get('/entrepreneur/financements', [EntrepreneurController::class, 'financements'])->name('entrepreneur.financements');
        Route::post('/entrepreneur/financements/{id}/accepter', [EntrepreneurController::class, 'accepterFinancement'])->name('entrepreneur.financements.accepter');
        Route::get('/offres-financement', [EntrepreneurController::class, 'offresFinancement'])->name('entrepreneur.offres_financement');
        Route::get('/entrepreneur/echeances', [EntrepreneurController::class, 'echeances'])->name('entrepreneur.echeances');
        Route::get('/entrepreneur/contrats', [EntrepreneurController::class, 'contrats'])->name('entrepreneur.contrats');
        
    });

    // Espace sécurisé strictement réservé aux Bailleurs
    Route::middleware(['role:bailleur'])->group(function () {
        Route::get('/bailleur/dashboard', [DashboardController::class, 'bailleurIndex'])->name('bailleur.dashboard');
            
        // --- ROUTES POUR CONSULTER ET FINANCER ---
        Route::get('/bailleur/projet/{id}', [DashboardController::class, 'bailleurShowProjet'])->name('bailleur.show_projet');
        Route::post('/bailleur/projet/{id}/offrir', [App\Http\Controllers\OffreController::class, 'store'])->name('bailleur.offre.store');
        Route::get('/explorer', [BailleurController::class, 'explorer'])->name('explorer');
        Route::get('/investissements', [BailleurController::class, 'investissements'])->name('investissements');
        Route::get('/echeances', [BailleurController::class, 'echeances'])->name('echeances');
        // Routes des critères
        Route::get('/criteres', [BailleurController::class, 'criteres'])->name('bailleur.criteres');
        Route::get('/criteres/edit', [BailleurController::class, 'editCriteres'])->name('bailleur.criteres.edit');
        Route::post('/criteres', [BailleurController::class, 'updateCriteres'])->name('bailleur.criteres.update');
        // Routes des offres
        Route::get('/offres', [OffreController::class, 'indexBailleur'])->name('bailleur.offres.index');
        Route::get('/offres/creer', [OffreController::class, 'create'])->name('bailleur.offres.create');
        Route::post('/bailleur/projet/{id}/proposition', [DashboardController::class, 'storeProposition'])->name('bailleur.propositions.store');
        Route::post('/offres', [OffreController::class, 'store'])->name('bailleur.offres.store');

        Route::get('/bailleur/mes-investissements', [DashboardController::class, 'mesInvestissements'])->name('bailleur.investissements');
        Route::get('/bailleur/explorer', [DashboardController::class, 'explorer'])->name('bailleur.explorer');
        Route::get('/bailleur/echeances', [DashboardController::class, 'echeances'])->name('bailleur.echeances');
        Route::get('/bailleur/contrats', [DashboardController::class, 'contrats'])->name('bailleur.contrats');
        Route::post('/bailleur/contrats/{financementId}/upload', [DashboardController::class, 'uploadContrat'])
        ->name('bailleur.contrats.upload');
        
           });
            
});