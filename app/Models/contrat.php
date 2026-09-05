<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    protected $fillable = [
        'financement_id',
        'date_signature',
        'fichier_url',
        'contenu',
        'statut',
    ];

    public function financement()
    {
        return $this->belongsTo(Financement::class, 'financement_id');
    }
}