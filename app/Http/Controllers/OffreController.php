<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OffreController extends Controller
{
    /**
     * Traite la soumission d'une offre de financement.
     */
    public function store(Request $request, $projet_id)
    {
        // 1. Validation basique des données du formulaire
        $request->validate([
            'montant' => 'required|numeric|min:1',
            'conditions' => 'nullable|string',
        ]);

        // Pour le moment, on fait un dump pour vérifier que les données arrivent bien !
        dd([
            'message' => 'L\'offre a bien été capturée !',
            'projet_id' => $projet_id,
            'montant_injecte' => $request->input('montant'),
            'conditions_note' => $request->input('conditions'),
        ]);

        /*
        // Plus tard, la logique ressemblera à ça :
        Offre::create([
            'projet_id' => $projet_id,
            'user_id' => auth()->id(),
            'montant' => $request->montant,
            'conditions' => $request->conditions,
        ]);
        return redirect()->back()->with('success', 'Votre offre a été soumise avec succès !');
        */
    }
}