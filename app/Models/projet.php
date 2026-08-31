<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projet extends Model
{
    use HasFactory;

    // Autoriser l'assignation de masse pour ces champs
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

    public function entrepreneur()
{
    // Ajustez 'id_utilisateur' si le champ de votre clé étrangère s'appelle autrement
    return $this->belongsTo(User::class, 'id_utilisateur'); 
}
}
