<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;
use App\Models\Entrepreneur;
use App\Models\Bailleur;
use App\Models\Financement;

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

    // On utilise "secteurs_preferes" au pluriel
    if ($bailleur && !empty($bailleur->secteurs_preferes)) {
        $query->where('categorie', trim($bailleur->secteurs_preferes));
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

        return view('bailleur.show_projet', compact('projet'));
    }

    public function storeProposition(Request $request, $id)
{
    $request->validate([
        'montant' => 'required|numeric|min:1',
        'conditions' => 'nullable|string',
    ]);

    try {
        $projet = Projet::findOrFail($id);
        $bailleur = auth()->user()->bailleur;

        if (!$bailleur) {
            return redirect()->back()->with('error', 'Profil bailleur non trouvé.');
        }

        Financement::create([
            'id_utilisateur'  => $projet->id_utilisateur,
            'id_bailleur'     => $bailleur->id,
            'montant_accorde' => $request->montant,
            'duree'           => 36,
            'taux_interet'    => 5.5,
            'statut'          => 'en_attente',
            'date_accorde'    => now(),
        ]);

        return redirect()->back()->with('success', 'Votre proposition de financement a été soumise avec succès !');

    } catch (\Exception $e) {
        // Enregistre l'erreur exacte dans storage/logs/laravel.log
        Log::error('Erreur financement: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
    }
}
}