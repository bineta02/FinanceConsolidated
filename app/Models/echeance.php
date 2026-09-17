<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Echeance extends Model
{
    use HasFactory;


    // Autoriser le remplissage de toutes les colonnes
    protected $guarded = [];

    // Cast des dates et montants
    protected $casts = [
        'date_prevu' => 'date',
        'montant'       => 'decimal:2',
    ];

    /**
     * Relation vers le Financement rattaché
     */
    public function financement()
    {
        return $this->belongsTo(Financement::class, 'financements_id');
    }
}