<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Garantie;
use App\Models\Financement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GarantieController extends Controller
{
    /**
     * Côté Entrepreneur : Enregistrer une garantie
     */
    public function store(Request $request, $financementId)
    {
        $request->validate([
            'type_garantie' => 'required|string|max:255',
            'valeur_estime' => 'required|numeric|min:0',
            'document'      => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $financement = Financement::findOrFail($financementId);

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('garanties', 'public');
        }

        Garantie::create([
            'financements_id' => $financement->id,
            'type_garantie'  => $request->type_garantie,
            'valeur_estime'  => $request->valeur_estime,
            'document_url'   => $documentPath,
            'statut'         => 'en_attente',
        ]);

        return redirect()->back()->with('success', 'La garantie a été enregistrée avec succès !');
    }

    /**
     * Côté Entrepreneur : Supprimer une garantie
     */
    public function destroy($id)
    {
        $garantie = Garantie::findOrFail($id);

        if ($garantie->document_url) {
            Storage::disk('public')->delete($garantie->document_url);
        }

        $garantie->delete();

        return redirect()->back()->with('success', 'La garantie a été supprimée.');
    }

    /**
     * Côté Bailleur : Afficher les garanties associées aux financements du bailleur
     */
    public function indexBailleur()
    {
        $user = Auth::user();
        
        // Récupérer le bailleur connecté
        $bailleurId = $user->bailleur->id ?? null;

        if (!$bailleurId) {
            return redirect()->back()->with('error', 'Profil bailleur introuvable.');
        }

        // Récupération des financements du bailleur ayant au moins une garantie
        $financements = Financement::with(['projet.entrepreneur.user', 'garanties'])
            ->where('bailleur_id', $bailleurId)
            ->whereHas('garanties')
            ->latest()
            ->get();

        return view('bailleur.garanties.index', compact('financements'));
    }

    /**
     * Côté Bailleur : Mettre à jour le statut d'une garantie
     */
    public function updateStatut(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:valide,rejete,en_attente',
        ]);

        $garantie = Garantie::findOrFail($id);
        $garantie->update([
            'statut' => $request->statut,
        ]);

        return redirect()->back()->with('success', 'Le statut de la garantie a été mis à jour.');
    }
}