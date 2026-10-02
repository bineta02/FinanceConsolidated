<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
use App\Models\Projet;
use App\Models\Offre_financement;
use App\Models\Financement;
use App\Models\Contrat;
use App\Models\Echeance;
use Illuminate\Support\Facades\Auth;

class EntrepreneurController extends Controller
{


public function dashboard()
{
    $userId = Auth::id();

    // 1. Récupérer le profil de l'entrepreneur
    $entrepreneur = Entrepreneur::where('id_utilisateur', $userId)->first();

    // 2. Récupérer les IDs de tous les financements reçus par cet entrepreneur
    $financementIds = Financement::where('id_utilisateur', $userId)
        ->orWhereHas('projet', function ($q) use ($userId) {
            $q->where('id_utilisateur', $userId);
        })
        ->pluck('id');

    // 3. Calculer les Fonds collectés
    $fondsCollectes = Projet::where('id_utilisateur', $userId)->sum('montant_collecte');
    if ($fondsCollectes == 0) {
        $fondsCollectes = Financement::whereIn('id', $financementIds)->sum('montant_accorde');
    }

    // 4. CALCUL DYNAMIQUE DU RESTE À REMBOURSER
    
    // Total global dû selon la table des échéances
    $totalDu = Echeance::whereIn('financements_id', $financementIds)->sum('montant');

    // Total déjà payé (échéances marquées comme paye ou payé)
    $totalPaye = Echeance::whereIn('financements_id', $financementIds)
        ->whereIn('statut', ['paye', 'payé', 'valide', 'validé'])
        ->sum('montant');

    // Si des échéances existent, on calcule (Total dû - Déjà payé)
    // Sinon, on retombe sur (Fonds collectés - Déjà payé)
    if ($totalDu > 0) {
        $resteARembourser = max(0, $totalDu - $totalPaye);
    } else {
        $resteARembourser = max(0, $fondsCollectes - $totalPaye);
    }

    // 5. Récupérer les projets de l'entrepreneur pour les graphiques/listes
    $projets = Projet::where('id_utilisateur', $userId)->get();

    return view('entrepreneur.dashboard', compact(
        'entrepreneur',
        'fondsCollectes',
        'resteARembourser',
        'totalPaye',
        'projets'
    ));
}

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
    $utilisateurId = auth()->id();
    $financementId = $request->get('financement_id');

    // Récupère le financement spécifié OU le premier financement de l'entrepreneur
    $financement = Financement::where('id_utilisateur', $utilisateurId)
        ->when($financementId, function ($query) use ($financementId) {
            return $query->where('id', $financementId);
        })
        ->latest()
        ->first();

    // S'il existe un financement, on récupère ses échéances
    $echeances = collect();
    if ($financement) {
        $echeances = $financement->echeances; // Utilise la relation hasMany définie dans Financement
    }

    return view('entrepreneur.echeances', compact('financement', 'echeances'));
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

public function payerEcheance($id)
{
    // Récupérer l'échéance
    $echeance = Echeance::findOrFail($id);

    // Mettre à jour le statut
    $echeance->update([
        'statut' => 'paye',
        'date_prevu' => now(), // Assurez-vous d'avoir cette colonne ou retirez-la si non utilisée
    ]);

    return redirect()->back()->with('success', 'Le paiement de la mensualité a été effectué avec succès !');
}
}