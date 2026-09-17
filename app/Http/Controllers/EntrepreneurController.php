<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
use App\Models\Projet;
use App\Models\Offre_financement;
use App\Models\Financement;
use App\Models\Contrat;
use App\Models\Echeancee;
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
    // On charge le bailleur et son utilisateur relié
    $financements = Financement::with(['projet', 'bailleur.utilisateur'])
        ->where('id_utilisateur', Auth::id())
        ->latest()
        ->get();

    // On récupère le premier projet de l'entrepreneur connecté pour l'affichage
    $projetEntrepreneur = Projet::where('id_utilisateur', Auth::id())->first();

    return view('entrepreneur.financements', compact('financements', 'projetEntrepreneur'));
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

public function echeances(Request $request)
{
    $financementId = $request->get('financement_id');

    $financement = Financement::where('id_utilisateur', auth()->id())
        ->when($financementId, fn($q) => $q->where('id', $financementId))
        ->firstOrFail();

    $echeances = $financement->echeances()->orderBy('date_echeance', 'asc')->get();

    $totalPaye = $echeances->where('statut', 'paye')->sum('montant');
    $resteAPayer = $financement->montant - $totalPaye;

    return view('entrepreneur.echeances', compact('financement', 'echeances', 'totalPaye', 'resteAPayer'));
}

public function contrats()
{
    $userId = Auth::id();

    $financements = Financement::with(['projet', 'bailleur.utilisateur', 'contrat'])
        ->whereHas('projet', function ($query) use ($userId) {
            $query->where('id_utilisateur', $userId);
        })
        ->latest()
        ->get();

    return view('entrepreneur.contrats', compact('financements'));
}
// Action de signature par l'entrepreneur
public function signerContrat($id)
{
    $contrat = Contrat::findOrFail($id);

    // Mettre à jour la vraie date de signature et le statut
    $contrat->update([
        'date_signature' => now(),
        'statut'         => 'Signé',
    ]);

    return redirect()->back()->with('success', 'Félicitations ! Le contrat a été validé et signé avec succès.');
}
}