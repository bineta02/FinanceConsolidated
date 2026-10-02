<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;
use App\Models\Entrepreneur;
use App\Models\Bailleur;
use App\Models\Financement;
use App\Models\Contrat;
use App\Models\Echeance;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'Entrepreneur
     */
    public function entrepreneurIndex()
    {
        $user = Auth::user();

        // 1. Récupération ou création du profil entrepreneur
        $entrepreneur = Entrepreneur::where('id_utilisateur', $user->id)->first();

        if (!$entrepreneur) {
            $entrepreneur = Entrepreneur::create([
                'id_utilisateur'     => $user->id,
                'secteur_dactivite'  => 'Non spécifié',
                'description_profil' => 'Nouveau profil',
                'annees_experiences' => 0
            ]);
        }

        // 2. Calcul des Fonds collectés
        $fondsCollectes = Financement::where('id_utilisateur', $user->id)
            ->whereIn('statut', ['valide', 'accepte', 'approuve', 'en_attente'])
            ->sum('montant_accorde');

        // 3. Récupérer tous les IDs des financements validés de cet entrepreneur
        $financementIds = Financement::where('id_utilisateur', $user->id)
            ->whereIn('statut', ['valide', 'accepte', 'approuve'])
            ->pluck('id');

        // Total des financements ou du capital à rembourser
        $totalDu = Financement::where('id_utilisateur', $user->id)
            ->whereIn('statut', ['valide', 'accepte', 'approuve'])
            ->sum('montant_accorde');

        // Somme des échéances payées
        $totalPaye = Echeance::whereIn('financements_id', $financementIds)
            ->whereIn('statut', ['paye', 'payé', 'valide', 'validé'])
            ->sum('montant_prevu');

        // Soustraction dynamique : Reste à rembourser = Total dû - Déjà payé
        $resteARembourser = max(0, $totalDu - $totalPaye);

        return view('dashboards.entrepreneur', compact('user', 'entrepreneur', 'fondsCollectes', 'resteARembourser'));
    }



    /**
 * Mettre à jour la capacité de financement
 */
public function updateCapacite(Request $request)
{
    $request->validate([
        'capacite_financement' => 'required|numeric|min:0',
    ]);

    $user = Auth::user();
    $bailleur = Bailleur::where('id_utilisateur', $user->id)->firstOrFail();

    $bailleur->update([
        'capacite_financement' => $request->capacite_financement
    ]);

    return redirect()->back()->with('success', 'Votre capacité de financement a été mise à jour !');
}

 /**
 * Page d'accueil / Tableau de bord du Bailleur
 */
public function bailleurIndex()
{
    $user = Auth::user();
    
    // 1. Récupérer le profil du bailleur
    $bailleur = Bailleur::where('id_utilisateur', $user->id)->first();$bailleurId = $bailleur ? $bailleur->id : null;

    // 2. Récupérer les financements existants
    $financementsBailleur = Financement::where(function($q) use ($bailleurId,$user) {
            if ($bailleurId) {
                $q->where('id_bailleur',$bailleurId);
            }
            $q->orWhere('id_utilisateur',$user->id);
        })
        ->get();

    $projetsFinancesIds =$financementsBailleur->pluck('projet_id')->unique()->filter()->toArray();

    // 3. Calculs des cartes KPIs
    $projetsFinancesCount = count($projetsFinancesIds);
    $totalInvesti =$financementsBailleur->sum('montant_accorde');
    
    $capaciteTotale =$bailleur->capacite_financement ?? 0;
    $capitalDisponible = max(0, $capaciteTotale -$totalInvesti);

    $contratsActifs = Contrat::whereIn('financements_id',$financementsBailleur->pluck('id'))->count();

    // 4. Base de la requête : Projets non encore financés et avec statut valide
    $queryProjets = Projet::whereNotIn('id',$projetsFinancesIds)
        ->whereIn('statut', ['en_attente', 'approuve', 'soumis']);

    // 5. Filtrage sur le/les secteur(s) préféré(s) du bailleur
    if ($bailleur && !empty($bailleur->secteurs_preferes)) {
        
        // Découpage si plusieurs secteurs (ex: "Agriculture, Élevage") ou format JSON
        $raw = is_array($bailleur->secteurs_preferes) 
            ? $bailleur->secteurs_preferes 
            : explode(',', trim((string)$bailleur->secteurs_preferes, '[]"\' '));

        $secteurs = array_filter(array_map('trim',$raw));

        if (!empty($secteurs)) {$queryProjets->where(function($parentQuery) use ($secteurs) {
                foreach ($secteurs as$secteur) {
                    // Recherche insensible à la casse et souple dans la colonne `categorie`
                    $parentQuery->orWhere('categorie', 'LIKE', '\%' .$secteur . '%');
                }
            });
        }
    }

    $projetsDisponibles =$queryProjets->latest()->get();

    return view('bailleur.dashboard', compact(
        'projetsDisponibles', 
        'bailleur',
        'projetsFinancesCount',
        'totalInvesti',
        'capitalDisponible',
        'contratsActifs'
    ));
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
        $projet = Projet::findOrFail($id);
        $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

        $request->validate([
            'montant'    => 'required|numeric',
            'conditions' => 'nullable|string',
        ]);

        Financement::create([
            'id_utilisateur'  => $projet->id_utilisateur,
            'id_bailleur'     => $bailleur->id,
            'projet_id'       => $projet->id,
            'montant_accorde' => $request->montant,
            'duree'           => $request->duree ?? 36,
            'taux_interet'    => $request->taux_interet ?? 5.5,
            'conditions'      => $request->conditions,
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
        $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

        $financements = Financement::with(['projet.entrepreneur'])
            ->where('id_bailleur', $bailleur->id)
            ->whereIn('statut', ['valide', 'accepte', 'approuve'])
            ->latest()
            ->get();

        return view('bailleur.echeances', compact('financements'));
    }

    public function contrats()
    {
        $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

        $financements = Financement::with(['projet.entrepreneur', 'contrat'])
            ->where('id_bailleur', $bailleur->id)
            ->whereIn('statut', ['valide', 'accepte', 'approuve'])
            ->latest()
            ->get();

        return view('bailleur.contrats', compact('financements'));
    }

    public function uploadContrat(Request $request, $financementId)
    {
        $request->validate([
            'fichier_contrat' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $financement = Financement::findOrFail($financementId);
        $path = $request->file('fichier_contrat')->store('contrats', 'public');

        Contrat::updateOrCreate(
            ['financement_id' => $financement->id],
            [
                'date_signature' => null,
                'fichier_url'    => $path,
                'contenu'        => 'Contrat transmis par le bailleur',
                'statut'         => 'a_signer', 
            ]
        );

        $entrepreneurId = $financement->projet->id_utilisateur ?? $financement->id_utilisateur;
        
        if ($entrepreneurId) {
            \App\Models\Notification::create([
                'id_utilisateur' => $entrepreneurId,
                'titre'          => 'Nouveau contrat disponible',
                'contenu'        => 'Un contrat a été déposé pour votre projet "' . ($financement->projet->titre ?? 'Projet') . '". Veuillez le consulter et le signer.',
                'type'           => 'contrat',
                'lue'            => false,
            ]);
        }

        return redirect()->back()->with('success', 'Contrat transmis avec succès à l’entrepreneur !');
    }

    public function signerContrat($id)
    {
        $contrat = Contrat::findOrFail($id);
        $contrat->update(['statut' => 'signe', 'date_signature' => now()]);

        $financement = $contrat->financement;

        if ($financement && $financement->echeances()->count() === 0) {
            
            $capital = $financement->montant_accorde;
            $duree = max($financement->duree, 1);
            $taux = $financement->taux_interet / 100;

            $totalInteret = $capital * $taux;
            $mensualiteTotal = ($capital + $totalInteret) / $duree;
            $capitalParMois = $capital / $duree;
            $interetParMois = $totalInteret / $duree;

            for ($i = 1; $i <= $duree; $i++) {
                Echeance::create([
                    'financements_id' => $financement->id,
                    'numero_echeance' => $i,
                    'date_prevu'       => now()->addMonths($i)->setDay(5),
                    'montant_prevu'   => $mensualiteTotal,
                    'montant_capital' => $capitalParMois,
                    'montant_interet' => $interetParMois,
                    'statut'          => 'en_attente',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Contrat signé avec succès. Le calendrier de remboursement a été généré !');
    }
}