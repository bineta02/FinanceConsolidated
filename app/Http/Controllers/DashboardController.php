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
    public function bailleurIndex()
    {
        // On récupère tous les projets au statut 'en_attente' ou 'approuve' pour que le bailleur puisse les voir
        $projetsDisponibles = Projet::whereIn('statut', ['en_attente', 'approuve'])
                                    ->latest()
                                    ->get();

        // On envoie ces projets à la future vue du bailleur
        return view('bailleur.dashboard', compact('projetsDisponibles'));
    }

    /**
 * Afficher les détails d'un projet pour le Bailleur
 */
public function bailleurShowProjet($id)
{
    // Récupérer le projet ou renvoyer une erreur 404
    $projet = Projet::findOrFail($id);
    
    // On l'envoie vers une nouvelle vue dédiée
    return view('bailleur.show_projet', compact('projet'));
}

}