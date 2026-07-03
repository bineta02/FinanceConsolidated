<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Entrepreneur;
use Illuminate\Support\Facades\Auth;

class ProjetController extends Controller
{
    /**
     * 1. INDEX : Affiche la liste des projets de l'entrepreneur connecté
     */
    public function index()
    {
        // Récupérer tous les projets liés à l'utilisateur connecté
        $projets = Projet::where('id_utilisateur', Auth::id())->latest()->get();

        // Envoyer les projets à la vue index
        return view('entrepreneur.projets.index', compact('projets'));
    }

    /**
     * 2. CREATE : Affiche le formulaire de dépôt de projet
     */
    public function create()
    {
        return view('entrepreneur.projets.create');
    }

    /**
     * 3. STORE : Enregistre le projet dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'montant_demande' => 'required|numeric|min:1',
            'categorie' => 'required|string',
        ]);

        // Récupérer le profil entrepreneur de l'utilisateur connecté
        $entrepreneur = Entrepreneur::where('id_utilisateur', Auth::id())->firstOrFail();

        // Insertion en base de données
        Projet::create([
            'id_utilisateur' => Auth::id(),
            'id_entrepreneur' => $entrepreneur->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'montant_demande' => $request->montant_demande,
            'montant_collecte' => 0, 
            'categorie' => $request->categorie,
            'statut' => 'en_attente', 
            'localisation' => 'Dakar', 
        ]);

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été déposé avec succès !');
    }

    /**
     * 4. SHOW : Affiche les détails d'un projet spécifique
     */
    public function show($id)
    {
        // On récupère le projet par son ID ou on renvoie une erreur 404 si introuvable
        $projet = Projet::findOrFail($id);

        // Sécurité : Vérifier que ce projet appartient bien à l'utilisateur connecté
        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('entrepreneur.projets.show', compact('projet'));
    }

    /**
     * 5. EDIT : Affiche le formulaire de modification avec les données actuelles
     */
    public function edit($id)
    {
        $projet = Projet::findOrFail($id);

        // Sécurité : Empêcher de modifier le projet d'un autre
        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('entrepreneur.projets.edit', compact('projet'));
    }

    /**
     * 6. UPDATE : Enregistre les modifications apportées au projet
     */
    public function update(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // Validation identique au store
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'montant_demande' => 'required|numeric|min:1',
            'categorie' => 'required|string',
        ]);

        // Mise à jour des données
        $projet->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'montant_demande' => $request->montant_demande,
            'categorie' => $request->categorie,
        ]);

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été mis à jour avec succès !');
    }

    /**
     * 7. DESTROY : Supprime un projet
     */
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $projet->delete();

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été supprimé.');
    }
}