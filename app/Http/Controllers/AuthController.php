<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Entrepreneur;
use App\Models\Bailleur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Gère l'accès à la page d'accueil (Landing page)
     */
    public function verification()
    {
        if (Auth::check()){
            $user = Auth::user();
            $redirectRoute = $user->role === 'bailleur' ? 'bailleur.dashboard' : 'dashboard';
            return redirect()->route($redirectRoute);
        }
        return view('accueil');
    }

    /**
     * Traite la tentative de connexion (POST)
     */
    public function login(Request $request)
    {
        // 1. Validation des données
        $validator = Validator::make($request->all(), [
            'email'        => 'required|email',
            'mot_de_passe' => 'required|min:6',
        ], [
            'email.required'         => 'L\'email est obligatoire.',
            'email.email'            => 'L\'email doit être une adresse valide.',
            'mot_de_passe.required'  => 'Le mot de passe est obligatoire.', 
            'mot_de_passe.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',   
        ]);

        // Si la validation échoue, on retourne à l'accueil avec un signal 'connexion'
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'))
                ->with('error_type', 'connexion'); 
        }

        // 2. Tentative de connexion
        $credentials = [
            'email'    => $request->email,
            'password' => $request->mot_de_passe,
        ];
        
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();
            $user = Auth::user();

            $redirectRoute = $user->role === 'bailleur' ? 'bailleur.dashboard' : 'dashboard';

            return redirect()->intended(route($redirectRoute))
                ->with('success', 'Bienvenue ' . $user->prenom . ' ' . $user->nom . ' !');
        }

        // Si les identifiants sont faux, on retourne à l'accueil avec le signal 'connexion'
        return back()
            ->withInput($request->only('email'))
            ->with('error_type', 'connexion')
            ->withErrors([
                'email' => 'Ces identifiants ne correspondent à aucun compte.',
            ]);
    } 

    /**
     * Traite l'inscription multi-rôles (Entrepreneurs et Bailleurs)
     */
   public function register(Request $request)
    {
        // 1. Validation des données d'inscription
        $validator = Validator::make($request->all(), [
            'prenom'       => 'required|string|max:255',
            'nom'          => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'telephone'    => 'required|string', 
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'role'         => 'required|in:entrepreneur,bailleur',
        ], [
            'prenom.required'       => 'Le prénom est obligatoire.',
            'nom.required'          => 'Le nom est obligatoire.',
            'email.required'        => 'L\'email est obligatoire.',
            'email.unique'          => 'Cet email est déjà utilisé.',
            'telephone.required'    => 'Le numéro de téléphone est obligatoire.',
            'mot_de_passe.required' => 'Le mot de passe est obligatoire.',
            'mot_de_passe.confirmed'=> 'Les deux mots de passe ne correspondent pas.',
            'role.required'         => 'Le choix d\'un rôle est obligatoire.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_type', 'inscription');
        }

        // 2. Création de l'utilisateur principal
        $user = User::create([
            'prenom'       => $request->prenom,
            'nom'          => $request->nom,
            'email'        => $request->email,
            'telephone'    => $request->telephone, 
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'role'         => $request->role,
            'statut'       => 'actif',
            'avatar'       => '', 
        ]);

        // 3. Création dans la table enfant selon le rôle
        if ($request->role === 'entrepreneur') {
            Entrepreneur::create([
                'id_utilisateur'     => $user->id,
                'secteur_dactivite'  => '', 
                'description_profil' => '', 
                'annees_experiences' => 0,  
            ]);
            
            return redirect()->route('login')
                ->with('success', 'Votre compte Entrepreneur a été créé avec succès ! Veuillez vous connecter.');

        } elseif ($request->role === 'bailleur') {
            Bailleur::create([
                'id_utilisateur'     => $user->id,
                'capital'            => 0,  
                'montant_max_projet' => 0,  
                'secteurs_preferes'  => '', 
                'types_bailleurs'    => '', 
            ]);

            return redirect()->route('login')
                ->with('success', 'Votre compte Bailleur a été créé avec succès ! Veuillez vous connecter.');
        }

        return redirect()->route('login');
    }

    /**
     * Gère la déconnexion
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}