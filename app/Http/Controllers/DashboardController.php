<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;
use App\Models\Entrepreneur;
use App\Models\Bailleur;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'Entrepreneur
     */
    public function entrepreneurIndex()
    {
        $user = Auth::user();

        // On récupère le profil pour afficher les vraies données sur le dashboard
        $entrepreneur = Entrepreneur::where('id_utilisateur', $user->id)->first();

        // Si aucun profil n'existe en BD pour cet utilisateur, on le crée par défaut
        if (!$entrepreneur) {
            $entrepreneur = Entrepreneur::create([
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
    $user = Auth::user();
    
    // Récupérer le profil du bailleur connecté
    $bailleur = Bailleur::where('id_utilisateur', $user->id)->first();

    // Construction de la requête pour les projets en attente
    $query = Projet::where('statut', 'en_attente');

    // Filtrer par secteur si le bailleur en a défini un
    if ($bailleur && !empty($bailleur->secteur_prefere)) {
        $query->where('categorie', $bailleur->secteur_prefere);
    }

    $projetsDisponibles = $query->latest()->get();

    return view('bailleur.dashboard', compact('projetsDisponibles', 'bailleur'));
}

    /**
     * Détails d'un projet pour le Bailleur
     */
    public function bailleurShowProjet($id)
    {
        $projet = Projet::findOrFail($id);

        return view('bailleur.show', compact('projet'));
    }
}