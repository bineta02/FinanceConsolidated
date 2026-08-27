<?php

namespace App\Http\Controllers;

use App\Models\Offre_Financement;
use App\Models\Bailleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    // Liste des offres du bailleur
    public function indexBailleur()
    {
        $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();
        $offres = Offre_Financement::where('id_bailleur', $bailleur->id)->latest()->get();

        return view('bailleur.offres.index', compact('offres'));
    }

    public function indexEntrepreneur()
{
    // On charge l'offre avec le bailleur ET son utilisateur lié
    $offres = OffreFinancement::with(['bailleur.utilisateur'])
                ->where('statut', 'disponible') // Ou 'en_attente'
                ->latest()
                ->get();

    return view('entrepreneur.offres.index', compact('offres'));
}

    // Formulaire de création
    public function create()
    {
        return view('bailleur.offres.create');
    }

    // Enregistrement de l'offre
    public function store(Request $request)
    {
        $request->validate([
            'secteur_cible'   => 'required|string',
            'montant_propose' => 'required|numeric|min:0',
            'taux_interet'    => 'nullable|numeric|min:0',
            'duree_mois'      => 'nullable|integer|min:1',
            'conditions'      => 'required|string',
        ]);

        $bailleur = Bailleur::where('id_utilisateur', Auth::id())->firstOrFail();

        Offre_Financement::create([
            'id_bailleur'     => $bailleur->id,
            'id_utilisateur'  => Auth::id(),
            'secteur_cible'   => $request->secteur_cible,
            'montant_propose' => $request->montant_propose,
            'taux_interet'    => $request->taux_interet,
            'duree_mois'      => $request->duree_mois,
            'conditions'      => $request->conditions,
            'statut'          => 'disponible',
        ]);

        return redirect()->route('bailleur.offres.index')->with('success', 'Offre de financement publiée avec succès.');
    }

}