<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Offre_financement;
use Illuminate\Support\Facades\Auth;

class OffreController extends Controller
{
    /**
     * Enregistre une proposition de financement formulée par un bailleur
     */
    public function store(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        $request->validate([
            'montant_offre' => 'required|numeric|min:10000',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        // Création de l'offre de financement
        Offre_financement::create([
            'projet_id' => $projet->id,
            'id_bailleur' => Auth::id(),
            'montant' => $request->montant_offre,
            'commentaire' => $request->commentaire,
            'statut' => 'en_attente', // Statut initial soumis à l'entrepreneur
        ]);

        return redirect()->route('bailleur.dashboard')
            ->with('success', 'Votre proposition de financement a été soumise avec succès à l\'entrepreneur !');
    }
}