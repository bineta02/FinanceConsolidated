<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre_financement extends Model
{
    use HasFactory;

    protected $table = 'offre_financements'; // Ajuster le nom de la table si différent dans vos migrations

    protected $guarded = [];

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id');
    }

    public function bailleur()
    {
        return $this->belongsTo(User::class, 'id_bailleur');
    }
}