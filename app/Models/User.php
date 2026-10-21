<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $guarded = []; // Autorise l'insertion de tous les champs

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function bailleur()
{
    return $this->hasOne(Bailleur::class, 'id_utilisateur');
}

public function mesNotifications()
{
    return $this->hasMany(Notification::class, 'id_utilisateur')->orderBy('created_at', 'desc');
}

public function mesNotificationsNonLues()
{
    return $this->hasMany(Notification::class, 'id_utilisateur')->where('lue', false);
}
}