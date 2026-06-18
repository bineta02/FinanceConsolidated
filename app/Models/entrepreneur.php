<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrepreneur extends Model
{
    use HasFactory;

    protected $table = 'entrepreneurs';

    public $incrementing = true;

    // Colonnes autorisées
    protected $guarded = []; // Autorise l'insertion de tous les champs

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}