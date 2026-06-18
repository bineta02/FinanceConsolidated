<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
    use HasFactory;

    protected $table = 'bailleurs';

    // Configuration essentielle pour tes ID incrémentaux classiques
    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = []; // Autorise l'insertion de tous les champs

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }
}
