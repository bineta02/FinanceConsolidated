<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entrepreneur;
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
}