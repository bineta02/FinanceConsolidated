<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
use App\Models\Projet;
use App\Models\Offre_financement;
use App\Models\Financement;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{
    /**
     * Montre le formulaire de modification (recherche dans views/entrepreneur/edit.blade.php)
     */
    public function edit()
    {
        $entrepreneur = Entrepreneur::where('id_utilisateur', Auth::id())->firstOrFail();

        // On pointe vers ton nouveau dossier : entrepreneur.edit
        return view('entrepreneur.edit', compact('entrepreneur'));
    }

    /**
     * Traite la modification en base de données
     */
    public function update(Request $request)
    {
        $request->validate([
            'secteur_dactivite' => 'required|string|max:255',
            'description_profil' => 'required|string',
            'annees_experiences' => 'required|integer|min:0',
        ]);

        $entrepreneur = Entrepreneur::where('id_utilisateur', Auth::id())->firstOrFail();
        
        $entrepreneur->update([
            'secteur_dactivite' => $request->secteur_dactivite,
            'description_profil' => $request->description_profil,
            'annees_experiences' => $request->annees_experiences,
        ]);

        // Redirige vers le tableau de bord avec un message de succès
        return redirect()->route('dashboard')->with('success', 'Profil mis à jour avec succès !');
    }

  public function financements()
{
    $financements = Financement::with(['projet', 'bailleur.utilisateur'])
        ->where('id_utilisateur', Auth::id())
        ->latest()
        ->get();

    return view('entrepreneur.financements', compact('financements'));
}

// Méthode pour accepter l'offre
public function accepterFinancement($id)
{
    $financement = Financement::findOrFail($id);
    
    // Mettre à jour le statut du financement
    $financement->update([
        'statut' => 'approuve' 
    ]);

    // Optionnel : Mettre à jour le montant collecté sur le projet
    if ($financement->projet) {
        $financement->projet->increment('montant_collecte', $financement->montant_accorde);
    }

    return redirect()->back()->with('success', 'Proposition de financement acceptée avec succès !');
}


public function offresFinancement()
{
    $offres = Offre_financement::with('bailleur')->latest()->get();
    return view('entrepreneur.offres_financement', compact('offres'));
}

public function echeances()
{
    // Cette action demande à Laravel de charger la page "echeances.blade.php"
    return view('entrepreneur.echeances');
}

public function contrats()
{
    // Cette action demande à Laravel de charger la page "contrats.blade.php"
    return view('entrepreneur.contrats');
}
}