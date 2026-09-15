<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Nom exact de la table
    protected $table = 'notifications';

    // $guarded vide = toutes les colonnes sont autorisées à l'insertion/modification
    protected $guarded = [];

    // Cast des colonnes
    protected $casts = [
        'lue' => 'boolean',
    ];

    // Relation vers l'utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}