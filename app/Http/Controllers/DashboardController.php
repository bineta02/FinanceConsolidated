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
        'conditions' => 'nullable|string|max:5000',
    ]);

    $projet = Projet::findOrFail($id);
    $bailleur = auth()->user()->bailleur;

    if (!$bailleur) {
        return redirect()->back()->with('error', 'Profil bailleur introuvable.');
    }

    // VÉRIFICATION ANTI-DOUBLON : Bloque si une offre est déjà en attente
    $dejaSoumis = Financement::where('id_utilisateur', $projet->id_utilisateur)
        ->where('id_bailleur', $bailleur->id)
        ->where('statut', 'en_attente')
        ->exists();

    if ($dejaSoumis) {
        return redirect()->back()->with('error', 'Vous avez déjà une proposition en attente pour ce projet.');
    }

    // Création de l'offre
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
}

public function mesInvestissements()
{
    $bailleur = auth()->user()->bailleur;

    if (!$bailleur) {
        return redirect()->back()->with('error', 'Profil bailleur introuvable.');
    }

    // Récupère tous les financements soumis par ce bailleur
    $financements = Financement::with('projet')
        ->where('id_bailleur', $bailleur->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('bailleur.investissements', compact('financements'));
}

public function explorer()
{
    $projets = Projet::with('entrepreneur')->latest()->get();
    return view('bailleur.explorer', compact('projets'));
}

public function echeances()
{
    return view('bailleur.echeances');
}

public function contrats()
{
    return view('bailleur.contrats');
}
}