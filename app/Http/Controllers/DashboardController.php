<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'Entrepreneur
     */
  public function entrepreneurIndex()
{
    $user = Auth::user();

    // On récupère le profil pour afficher les vraies données sur le dashboard
    $entrepreneur = \App\Models\Entrepreneur::where('id_utilisateur', $user->id)->first();

    // Si aucun profil n'existe en BD pour cet utilisateur, on le crée par défaut
    if (!$entrepreneur) {
        $entrepreneur = \App\Models\Entrepreneur::create([
            'id_utilisateur' => $user->id,
            'secteur_dactivite' => 'Non spécifié',
            'description_profil' => 'Nouveau profil',
            'annees_experiences' => 0
        ]);
    }

    return view('dashboards.entrepreneur', compact('user', 'entrepreneur'));
}

     /**
     * Page d'accueil / Tableau de bord du Bailleur
     */
    use App\Models\Projet;

public function bailleurIndex()
{
    // Projets en attente de financement
    $projetsDisponibles = Projet::where('statut', 'soumis')->latest()->get();

    return view('bailleur.dashboard', compact('projetsDisponibles'));
}

public function bailleurShowProjet($id)
{
    $projet = Projet::findOrFail($id);

    return view('bailleur.show', compact('projet'));
}
}