<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Entrepreneur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjetController extends Controller
{
    /**
     * 1. INDEX : Affiche la liste des projets de l'entrepreneur connecté
     */
    public function index()
    {
        $projets = Projet::where('id_utilisateur', Auth::id())->latest()->get();
        return view('entrepreneur.projets.index', compact('projets'));
    }

    /**
     * 2. CREATE : Affiche le formulaire de dépôt de projet
     */
    public function create()
    {
        return view('entrepreneur.projets.create');
    }

    /**
     * 3. STORE : Enregistre le projet dans la base de données
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre'           => 'required|string|max:255',
            'description'     => 'required|string',
            'montant_demande' => 'required|numeric|min:1',
            'categorie'       => 'required|string',
            'localisation'    => 'required|string|max:255',
            'document'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $entrepreneur = Entrepreneur::where('id_utilisateur', Auth::id())->firstOrFail();

        $documentUrl = null;
        if ($request->hasFile('document')) {
            $documentUrl = $request->file('document')->store('documents_projets', 'public');
        }

        Projet::create([
            'id_utilisateur'  => Auth::id(),
            'id_entrepreneur' => $entrepreneur->id,
            'titre'           => $request->titre,
            'description'     => $request->description,
            'montant_demande' => $request->montant_demande,
            'montant_collecte'=> 0, 
            'categorie'       => $request->categorie,
            'localisation'    => $request->localisation,
            'statut'          => 'en_attente', 
            'document_url'    => $documentUrl,
        ]);

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été déposé avec succès !');
    }

    /**
     * 4. SHOW : Affiche les détails d'un projet spécifique
     */
    public function show($id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('entrepreneur.projets.show', compact('projet'));
    }

    /**
     * 5. EDIT : Affiche le formulaire de modification
     */
    public function edit($id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        return view('entrepreneur.projets.edit', compact('projet'));
    }

    /**
     * 6. UPDATE : Enregistre les modifications apportées au projet
     */
    public function update(Request $request, $id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        $request->validate([
            'titre'           => 'required|string|max:255',
            'description'     => 'required|string',
            'montant_demande' => 'required|numeric|min:1',
            'categorie'       => 'required|string',
            'localisation'    => 'required|string|max:255',
            'document'        => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'titre'           => $request->titre,
            'description'     => $request->description,
            'montant_demande' => $request->montant_demande,
            'categorie'       => $request->categorie,
            'localisation'    => $request->localisation,
        ];

        if ($request->hasFile('document')) {
            if ($projet->document_url && Storage::disk('public')->exists($projet->document_url)) {
                Storage::disk('public')->delete($projet->document_url);
            }
            $data['document_url'] = $request->file('document')->store('documents_projets', 'public');
        }

        $projet->update($data);

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été mis à jour avec succès !');
    }

    /**
     * Supprime uniquement le document joint à un projet
     */
    public function destroyDocument($id)
    {
        $projet = Projet::where('id', $id)->where('id_utilisateur', Auth::id())->firstOrFail();

        if ($projet->document_url && Storage::disk('public')->exists($projet->document_url)) {
            Storage::disk('public')->delete($projet->document_url);
            $projet->update(['document_url' => null]);
        }

        return redirect()->back()->with('success', 'Le document a été supprimé avec succès !');
    }

    /**
     * 7. DESTROY : Supprime un projet
     */
    public function destroy($id)
    {
        $projet = Projet::findOrFail($id);

        if ($projet->id_utilisateur !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        if ($projet->document_url && Storage::disk('public')->exists($projet->document_url)) {
            Storage::disk('public')->delete($projet->document_url);
        }

        $projet->delete();

        return redirect()->route('entrepreneur.projet.index')->with('success', 'Votre projet a été supprimé.');
    }
}