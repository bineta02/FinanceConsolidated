<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Offre_financement;
use App\Models\Bailleur;
use Illuminate\Support\Facades\Auth;

class BailleurController extends Controller
{




public function dashboard()
{
    $user = auth()->user();

    // 1. Récupération du bailleur lié à cet utilisateur
    $bailleur = \App\Models\Bailleur::where('id_utilisateur', $user->id)->first();
    $bailleurId = $bailleur ? $bailleur->id : null;

    // 2. Recherche TRÈS LARGE des financements du bailleur
    $financements = \App\Models\Financement::where(function($query) use ($bailleurId, $user) {
            if ($bailleurId) {
                $query->where('id_bailleur', $bailleurId);
            }
            $query->orWhere('id_utilisateur', $user->id)
                  ->orWhere('user_id', $user->id);
        })
        // On inclut aussi les financements issus des offres faites par ce bailleur
        ->orWhereHas('offreFinancement', function ($q) use ($bailleurId, $user) {
            if ($bailleurId) {
                $q->where('bailleur_id', $bailleurId)
                  ->orWhere('id_bailleur', $bailleurId);
            }
            $q->orWhere('id_utilisateur', $user->id)
              ->orWhere('user_id', $user->id);
        })
        ->get();

    // 3. Récupération des projets financés
    $projetsFinancesIds = $financements->pluck('projet_id')->unique()->filter()->toArray();

    // Si la table projets fait directement référence au bailleur ou à l'utilisateur
    $projetsDirects = \App\Models\Projet::where(function($q) use ($bailleurId, $user) {
            if ($bailleurId) {
                $q->where('id_bailleur', $bailleurId)->orWhere('bailleur_id', $bailleurId);
            }
            $q->orWhere('id_bailleur_retenir', $user->id);
        })
        ->pluck('id')
        ->toArray();

    $allProjetsFinancesIds = array_unique(array_merge($projetsFinancesIds, $projetsDirects));

    // 4. Calculs des KPIs pour les cartes
    $projetsFinancesCount = count($allProjetsFinancesIds);
    
    // Somme financée (recherche dans financements puis fallback dans projets)
    $totalInvesti = $financements->sum('montant_accorde');
    if ($totalInvesti == 0 && !empty($allProjetsFinancesIds)) {
        $totalInvesti = \App\Models\Projet::whereIn('id', $allProjetsFinancesIds)->sum('montant_collecte');
    }

    // Nombre de contrats engagés
    $financementIds = $financements->pluck('id')->toArray();
    $contratsActifs = \App\Models\Contrat::whereIn('financements_id', $financementIds)
        ->orWhereIn('projet_id', $allProjetsFinancesIds)
        ->count();

    // 5. Projets disponibles (exclure ceux déjà financés)
    $projetsDisponibles = \App\Models\Projet::whereNotIn('id', $allProjetsFinancesIds)
        ->whereIn('statut', ['en_attente', 'approuve', 'soumis', 'en_cours', 'soumise'])
        ->latest()
        ->get();

    return view('bailleur.dashboard', compact(
        'projetsDisponibles',
        'projetsFinancesCount',
        'totalInvesti',
        'contratsActifs'
    ));
}
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
    $user = auth()->user();
    $bailleurId = $user->bailleur->id ?? null;

    // Récupère TOUS les financements rattachés au bailleur
    $financements = Financement::where('bailleur_id', $bailleurId)
        ->orWhereHas('offreFinancement', function ($query) use ($bailleurId) {
            $query->where('bailleur_id', $bailleurId);
        })
        ->with(['projet.entrepreneur', 'echeances'])
        ->latest()
        ->get();

    return view('bailleur.echeances', compact('financements'));
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

    public function garanties()
{
    $user = auth()->user();
    $bailleurId = $user->bailleur->id ?? null;

    // Récupérer les financements du bailleur avec leurs garanties et projets
    $financements = Financement::where('bailleur_id', $bailleurId)
        ->orWhereHas('offreFinancement', function ($query) use ($bailleurId) {
            $query->where('bailleur_id', $bailleurId);
        })
        ->with(['projet.entrepreneur', 'garanties'])
        ->latest()
        ->get();

    return view('bailleur.garanties', compact('financements'));
}
}