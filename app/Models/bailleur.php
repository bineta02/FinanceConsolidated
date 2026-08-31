<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
    use HasFactory;

    protected $table = 'bailleurs';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = [];

    /**
     * Relation avec l'utilisateur (compte User)
     */
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    /**
     * Relation avec les financements
     */
    public function financements()
    {
        return $this->hasMany(Financement::class, 'id_bailleur');
    }
}