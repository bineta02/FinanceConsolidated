<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        // 1. Si l'utilisateur n'est pas connecté, redirection vers la landing page
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Récupérer le rôle de l'utilisateur connecté
        $userRole = Auth::user()->role;

        // 3. Vérifier si le rôle de l'utilisateur est dans la liste des rôles autorisés
        if (!in_array($userRole, $roles)) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}