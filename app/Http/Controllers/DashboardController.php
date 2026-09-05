<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Projet;
use App\Models\Entrepreneur;
use App\Models\Bailleur;
use App\Models\Financement;
use App\Models\Contrat;

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

    // 2. Calcul des Fonds collectés (Offres acceptées/validées OU en attente)
    $fondsCollectes = Financement::where('id_utilisateur', $user->id)
        ->whereIn('statut', ['valide', 'accepte', 'approuve', 'en_attente']) // Inclut les offres reçues/en attente
        ->sum('montant_accorde');

    // 3. Calcul du Reste à rembourser (Offres validées/acceptées)
    $resteARembourser = Financement::where('id_utilisateur', $user->id)
        ->whereIn('statut', ['valide', 'accepte', 'approuve'])
        ->sum('montant_accorde');

    return view('dashboards.entrepreneur', compact('user', 'entrepreneur', 'fondsCollectes', 'resteARembourser'));
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
    // 1. Récupérer le projet concerné par l'ID passé en paramètre ($id = 4)
    $projet = Projet::findOrFail($id);

    // 2. Récupérer l'enregistrement du bailleur connecté
    $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

    // 3. Validation des données (optionnel mais recommandé)
    $request->validate([
        'montant'    => 'required|numeric',
        'conditions' => 'nullable|string',
    ]);

    // 4. Création de l'offre de financement
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

// Page Échéances & Remboursements
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

// Page Garanties & Contrats
public function contrats()
{
    $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

    // On charge 'projet.entrepreneur' ET 'contrat'
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
        'fichier_contrat' => 'required|mimes:pdf,doc,docx|max:5120', // 5MB max
        'date_signature'  => 'required|date',
    ]);

    $financement = Financement::findOrFail($financementId);

    // Sauvegarde du fichier dans storage/app/public/contrats
    $path = $request->file('fichier_contrat')->store('contrats', 'public');

    // Mettre à jour ou créer l'entrée contrat (avec le champ 'contenu' pour éviter l'erreur 1364)
    Contrat::updateOrCreate(
        ['financement_id' => $financement->id],
        [
            'date_signature' => $request->date_signature,
            'fichier_url'    => $path,
            'contenu'        => 'Contrat officiel de financement', 
            'statut'         => 'Signé',
        ]
    );

    return redirect()->back()->with('success', 'Le contrat a été importé avec succès !');
}
}