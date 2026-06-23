<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Entrepreneur;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    /**
     * Affiche le formulaire de dépôt (Ta vue actuelle "Déposer un projet")
     */
    public function create()
    {
        return view('entrepreneur.deposer_projet'); // Ajuste le chemin si nécessaire
    }

    /**
     * Enregistre le projet dans la base de données
     */
    public function store(Request $request)
    {
        // 1. Validation des données du formulaire
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'montant_demande' => 'required|numeric|min:1',
            'categorie' => 'required|string',
        ]);

        // 2. Récupérer le profil entrepreneur de l'utilisateur connecté
        $entrepreneur = Entrepreneur::where('id_utilisateur', Auth::id())->firstOrFail();

        // 3. Insertion en base de données
        Projet::create([
            'id_utilisateur' => Auth::id(),
            'id_entrepreneur' => $entrepreneur->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'montant_demande' => $request->montant_demande,
            'montant_collecte' => 0, // Nouveau projet = 0 FCFA récolté au départ
            'categorie' => $request->categorie,
            'statut' => 'en_attente', // Statut initial par défaut
            'localisation' => 'Dakar', // Tu pourras rajouter un champ plus tard si tu veux
        ]);

        // 4. Redirection avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Votre projet a été déposé avec succès !');
    }
}