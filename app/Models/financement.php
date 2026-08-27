<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financement extends Model
{
    use HasFactory;

    // Nom de la table en base de données
    protected $table = 'financements';

    // Autoriser le remplissage de tous les champs
    protected $guarded = [];

    // Relation avec le projet financé
    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    // Relation avec le bailleur qui fait l'offre
    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class, 'id_bailleur');
    }
}