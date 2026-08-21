<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre_financement extends Model
{
    use HasFactory;

    // Définissez les champs autorisés si nécessaire
    protected $guarded = [];

    /**
     * Relation avec le Projet
     */
    public function projet()
    {
        // Remplacez 'id_projet' ou 'projet_id' par le nom exact de votre clé étrangère si différent
        return $this->belongsTo(Projet::class, 'projet_id'); 
    }

    /**
     * Relation avec le Bailleur (Optionnel)
     */
    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class, 'id_bailleur');
    }
}