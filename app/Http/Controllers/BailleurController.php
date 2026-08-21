<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Projet;
use App\Models\Offre_financement;
use Illuminate\Support\Facades\Auth;

class BailleurController extends Controller
{
    /**
     * Liste des projets disponibles à l'investissement (Explorer)
     */
    public function explorer()
    {
        $projetsDisponibles = Projet::where('statut', 'soumis')->latest()->get();
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
        return view('bailleur.echeances');
    }

    /**
     * Configuration des critères de financement
     */
    public function criteres()
    {
        return view('bailleur.criteres');
    }

    /**
     * Consultations des contrats et garanties
     */
    public function contrats()
    {
        return view('bailleur.contrats');
    }
}