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
        Route::get('/entrepreneur/dashboard', [DashboardController::class, 'entrepreneurIndex'])
            ->name('dashboard');
    });

    Route::middleware(['role:entrepreneur'])->group(function () {
    
    // Le tableau de bord (Géré par DashboardController)
    Route::get('/entrepreneur/dashboard', [DashboardController::class, 'entrepreneurIndex'])->name('dashboard');

    // Le CRUD Profil (Géré par EntrepreneurController et stocké dans le dossier views/entrepreneur)
    Route::get('/entrepreneur/profil/modifier', [\App\Http\Controllers\EntrepreneurController::class, 'edit'])->name('entrepreneur.profil.edit');
    Route::put('/entrepreneur/profil/mettre-a-jour', [\App\Http\Controllers\EntrepreneurController::class, 'update'])->name('entrepreneur.profil.update');

});

    // Espace sécurisé strictement réservé aux Bailleurs
    Route::middleware(['role:bailleur'])->group(function () {
        Route::get('/bailleur/dashboard', [DashboardController::class, 'bailleurIndex'])
            ->name('bailleur.dashboard');
    });
    
});