<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_utilisateur',
        'id_entrepreneur',
        'titre',
        'description',
        'montant_demande',
        'montant_collecte',
        'categorie',
        'statut',
        'localisation',
        'document_url',
    ];

    // Relation principale
    public function entrepreneur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur'); 
    }

    // Alias pour la compatibilité
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}