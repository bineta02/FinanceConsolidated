<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garantie extends Model
{
    use HasFactory;

    protected $table = 'garanties';

    protected $fillable = [
        'financements_id',
        'type_garantie',
        'valeur_estime',
        'document_url',
        'statut',
    ];

    /**
     * Relation vers le financement concerné
     */
    public function financement()
    {
        return $this->belongsTo(Financement::class, 'financements_id');
    }
}