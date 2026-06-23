<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// --- PAGE D'ACCUEIL / LANDING PAGE ---
// Utilise la méthode verification() pour rediriger automatiquement si déjà connecté
Route::get('/', [AuthController::class, 'verification'])->name('login');


// --- TRAITEMENT AUTHENTIFICATION (MODALS) ---
// Inscription multi-rôles
Route::post('/inscription', [AuthController::class, 'register'])->name('register.submit');

// Connexion
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit');

// Déconnexion
Route::get('/deconnexion', [AuthController::class, 'logout'])->name('logout');


// --- ESPACES SÉCURISÉS & COMPARTIMENTÉS PAR RÔLE ---
Route::middleware(['auth'])->group(function () {

    // Espace sécurisé strictement réservé aux Entrepreneurs
Route::middleware(['role:entrepreneur'])->group(function () {
    // Ta route existante pour le Dashboard
    Route::get('/entrepreneur/dashboard', [DashboardController::class, 'entrepreneurIndex'])->name('dashboard');

    // --- AJOUTE CES ROUTES ICI POUR COMPLÉTER LE DISPOSITIF ---
    // 1. Afficher le formulaire de dépôt de projet
    Route::get('/entrepreneur/projet/creer', [ProjetController::class, 'create'])->name('entrepreneur.projet.create');
    
    // 2. Traiter la soumission du formulaire et l'enregistrer en BDD
    Route::post('/entrepreneur/projet/enregistrer', [ProjetController::class, 'store'])->name('entrepreneur.projet.store');
    
    // 3. Modifier le profil (si pas encore fait)
    Route::get('/entrepreneur/profil/modifier', [EntrepreneurController::class, 'edit'])->name('entrepreneur.profil.edit');
    Route::put('/entrepreneur/profil/mettre-a-jour', [EntrepreneurController::class, 'update'])->name('entrepreneur.profil.update');
});

    // Espace sécurisé strictement réservé aux Bailleurs
    Route::middleware(['role:bailleur'])->group(function () {
        Route::get('/bailleur/dashboard', [DashboardController::class, 'bailleurIndex'])
            ->name('bailleur.dashboard');
    });
    
});