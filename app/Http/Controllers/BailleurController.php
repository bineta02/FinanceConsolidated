<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Offre_financement;
use App\Models\Bailleur;
use Illuminate\Support\Facades\Auth;

class BailleurController extends Controller
{
    /**
     * Liste des projets disponibles à l'investissement (Explorer)
     */
    public function explorer()
    {
        $projetsDisponibles = Projet::where('statut', 'en_attente')->latest()->get();
        return view('bailleur.dashboard', compact('projetsDisponibles'));
    }

    /**
     * Historique des propositions & investissements du bailleur
     */
    public function investissements()
    {
        $investissements = Offre_financement::where('id_bailleur', Auth::id())
            ->with('projet')
            ->latest()
            ->get();

        return view('bailleur.investissements', compact('investissements'));
    }

    /**
     * Suivi des échéances et remboursements
     */
    public function echeances()
    {
        return view('bailleur.echeances');
    }

    /**
     * Affichage du formulaire des critères de financement (GET)
     */
    // Afficher la page des critères (Consultation)
public function criteres()
{
    $bailleur = Bailleur::where('id_utilisateur', Auth::id())->first();
    return view('bailleur.criteres', compact('bailleur'));
}

// Afficher le formulaire de modification
public function editCriteres()
{
    $bailleur = Bailleur::where('id_utilisateur', Auth::id())->first();
    return view('bailleur.edit_criteres', compact('bailleur'));
}

// Sauvegarder les données et le document
public function updateCriteres(Request $request)
{
    $request->validate([
        'secteur_prefere' => 'nullable|string',
        'document_agrement' => 'nullable|file|mimes:pdf,jpg,png|max:4096',
    ]);

    $bailleur = Bailleur::firstOrCreate(
        ['id_utilisateur' => Auth::id()],
        ['capital' => 0, 'montant_max_projet' => 0, 'types_bailleurs' => 'Individuel']
    );

    if ($request->hasFile('document_agrement')) {
        $path = $request->file('document_agrement')->store('documents_bailleurs', 'public');
        $bailleur->document_agrement = $path;
    }

    $bailleur->secteurs_preferes = $request->secteur_prefere;
    $bailleur->save();

    return redirect()->route('bailleur.criteres')->with('success', 'Votre profil et vos critères ont été mis à jour.');
}

    /**
     * Consultations des contrats et garanties
     */
    public function contrats()
    {
        return view('bailleur.contrats');
    }
}