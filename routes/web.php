<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\EntrepreneurController;

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
        
// Les 3 routes de gestion ajoutées pour modifier et supprimer :
Route::get('/entrepreneur/projet/{id}/modifier', [ProjetController::class, 'edit'])->name('entrepreneur.projet.edit');
Route::put('/entrepreneur/projet/{id}/mettre-a-jour', [ProjetController::class, 'update'])->name('entrepreneur.projet.update');
Route::delete('/entrepreneur/projet/{id}/supprimer', [ProjetController::class, 'destroy'])->name('entrepreneur.projet.destroy');

        
// --- GESTION DU PROFIL ---
Route::get('/entrepreneur/profil/modifier', [EntrepreneurController::class, 'edit'])->name('entrepreneur.profil.edit');
Route::put('/entrepreneur/profil/mettre-a-jour', [EntrepreneurController::class, 'update'])->name('entrepreneur.profil.update');
        
        
// --- ONGLETS COMPLEMENTAIRES ---
Route::get('/entrepreneur/financements', [EntrepreneurController::class, 'financements'])->name('entrepreneur.financements');
Route::get('/entrepreneur/echeances', [EntrepreneurController::class, 'echeances'])->name('entrepreneur.echeances');
Route::get('/entrepreneur/contrats', [EntrepreneurController::class, 'contrats'])->name('entrepreneur.contrats');
});

// Espace sécurisé strictement réservé aux Bailleurs
Route::middleware(['role:bailleur'])->group(function () {
// Ton dashboard existant
Route::get('/bailleur/dashboard', [DashboardController::class, 'bailleurIndex'])->name('bailleur.dashboard');
    
// --- NOUVELLES ROUTES POUR CONSULTER ET FINANCER ---
// 1. Consulter les détails d'un projet spécifique
Route::get('/bailleur/projet/{id}', [DashboardController::class, 'bailleurShowProjet'])->name('bailleur.projet.show');
    
// 2. Soumettre une offre financière (gérée par l'OffreController de ton Excel)
Route::post('/bailleur/projet/{id}/offrir', [App\Http\Controllers\OffreController::class, 'store'])->name('bailleur.offre.store');
});
    
});