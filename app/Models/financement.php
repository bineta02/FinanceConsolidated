<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financement extends Model
{
    protected $guarded = [];

    public function projet()
    {
        return $this->belongsTo(Projet::class, 'projet_id'); // Ou le nom exact de votre clé (ex: projet_id)
    }

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class, 'id_bailleur');
    }

    

}