<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function lireEtRediriger($id)
    {
        $notification = Notification::where('id_utilisateur', auth()->id())
            ->findOrFail($id);

        // 1. Marquer la notification comme lue
        $notification->update(['lue' => true]);

        // 2. Rediriger l'entrepreneur vers la page des contrats
        return redirect()->route('entrepreneur.contrats');
    }
}