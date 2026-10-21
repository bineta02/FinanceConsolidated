<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FinanceConsolidated | Espace Bailleur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <style>
    :root {
      --primary-green: #0e6b3e; --light-green: #e8f3ef; --dark-green: #095a34;
      --pure-white: #ffffff; --off-white: #f9fbfa; --text-dark: #1e2a2c; --accent-blue: #2c7da0;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', sans-serif; background: var(--off-white); min-height: 100vh; }
    .bailleur-wrapper { display: flex; min-height: 100vh; }
    .sidebar-bailleur { width: 280px; background: var(--pure-white); box-shadow: 2px 0 20px rgba(0,0,0,0.03); position: fixed; height: 100vh; overflow-y: auto; z-index: 100; }
    .main-content { flex: 1; margin-left: 280px; padding: 1.5rem 2rem; }
    .sidebar-brand { padding: 1.8rem 1.5rem; border-bottom: 1px solid #edf2f0; }
    .sidebar-brand h3 { color: var(--primary-green); font-weight: 700; margin: 0; }
    .nav-bailleur { padding: 1.5rem 0; }
    .nav-bailleur .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.75rem 1.8rem; color: #4a5b55; font-weight: 500; text-decoration: none; border-left: 3px solid transparent; }
    .nav-bailleur .nav-link.active, .nav-bailleur .nav-link:hover { background: var(--light-green); color: var(--primary-green); border-left-color: var(--primary-green); }
    .top-bar { background: white; border-radius: 24px; padding: 0.8rem 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02); margin-bottom: 1.8rem; display: flex; justify-content: space-between; align-items: center; }
    .card-modern { border: none; border-radius: 24px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .btn-green { background: var(--primary-green); border: none; color: white; border-radius: 40px; padding: 0.5rem 1.5rem; font-weight: 500; text-decoration: none; }
    .btn-green:hover { background: var(--dark-green); color: white; }
    .fs-7 { font-size: 0.85rem; }
    .fs-8 { font-size: 0.75rem; }
  </style>
</head>
<body>

<div class="bailleur-wrapper">
  <aside class="sidebar-bailleur">
    <div class="sidebar-brand">
      <h3>
        <img src="{{ asset('assets/images/logoFinance.png') }}" alt="" style="max-height: 40px; width: auto; display: none;">
        FinanceConsolidated
      </h3>
      <p class="text-muted small mb-0">Espace Bailleur</p>
    </div>
    
    <ul class="nav-bailleur flex-column">
      <!-- 1. Tableau de bord -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.dashboard') ? 'active' : '' }}" href="{{ route('bailleur.dashboard') }}">
          <i class="fas fa-chart-pie"></i> Tableau de bord
        </a>
      </li>
      
      <!-- 2. Explorer & Investir -->
      <li class="nav-item">
        <a href="{{ route('bailleur.explorer') }}" class="nav-link {{ Route::is('bailleur.explorer') ? 'active' : '' }}">
          <i class="fas fa-search"></i> Explorer & Investir
        </a>
      </li>

      <!-- 3. Mes investissements -->
      <li class="nav-item">
        <a href="{{ route('bailleur.investissements') }}" class="nav-link {{ Route::is('bailleur.investissements') ? 'active' : '' }}">
          <i class="fas fa-chart-line"></i> Mes investissements
        </a>
      </li>

      

      <!-- 5. Mes critères de financement -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.criteres*') ? 'active' : '' }}" href="{{ route('bailleur.criteres') }}">
          <i class="fas fa-sliders-h"></i> Mes critères de financement
        </a>
      </li>

      <!-- 6. Mes Offres de financement -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.offres.*') ? 'active' : '' }}" href="{{ route('bailleur.offres.index') }}">
          <i class="fas fa-hand-holding-usd"></i> Mes Offres de financement
        </a>
      </li>

      <!-- 7. Échéances & Remboursements -->
      <li class="nav-item">
        <a href="{{ route('bailleur.echeances') }}" class="nav-link {{ Route::is('bailleur.echeances') ? 'active' : '' }}">
          <i class="fas fa-calendar-alt"></i> Échéances & Remboursements
        </a>
      </li>

      <!-- 8. Garanties & contrats -->
      <li class="nav-item">
        <a href="{{ route('bailleur.contrats') }}" class="nav-link {{ Route::is('bailleur.contrats') ? 'active' : '' }}">
          <i class="fas fa-file-contract"></i> Garanties & contrats
        </a>
      </li>

      <!-- Déconnexion -->
      <li class="nav-item mt-4">
        <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
      </li>
    </ul>
  </aside>

  <main class="main-content">
    <!-- BARRE SUPÉRIEURE DYNAMIQUE -->
    <div class="top-bar">
      <div>
        <span class="ms-2 fw-semibold">
          Bonjour, <span class="text-success">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
        </span>
      </div>

      <div class="d-flex align-items-center gap-3">
        <!-- Bouton d'accès rapide -->
        <a href="{{ route('bailleur.criteres.edit') }}" class="btn btn-sm btn-outline-success rounded-4">
          <i class="fas fa-user-cog me-1"></i> Mon Profil & Critères
        </a>

        <!-- DROPDOWN CLOCHE NOTIFICATIONS DYNAMIQUE -->
        <div class="dropdown">
          <a class="nav-link position-relative text-secondary p-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell fs-5"></i>
            @if(auth()->user()->mesNotificationsNonLues->count() > 0)
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light" style="font-size: 0.60rem;">
                {{ auth()->user()->mesNotificationsNonLues->count() }}
              </span>
            @endif
          </a>

          <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2" style="width: 320px;">
            <li class="px-2 py-1 border-bottom d-flex align-items-center justify-content-between mb-2">
              <span class="fw-bold text-dark fs-7">Notifications</span>
              <small class="text-muted fs-8">{{ auth()->user()->mesNotificationsNonLues->count() }} non lue(s)</small>
            </li>

            @forelse(auth()->user()->mesNotificationsNonLues->take(5) as $notif)
              <li>
                <a class="dropdown-item p-2 rounded mb-1 bg-light" href="{{ route('bailleur.messages.index') }}">
                  <div class="fw-semibold text-dark fs-7 text-truncate">{{ $notif->titre ?? 'Notification' }}</div>
                  <div class="text-muted text-truncate fs-8">{{ $notif->contenu ?? '' }}</div>
                  <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">
                    {{ \Carbon\Carbon::parse($notif->created_at ?? $notif->date_creation)->diffForHumans() }}
                  </small>
                </a>
              </li>
            @empty
              <li class="text-center py-3 text-muted fs-7">Aucune nouvelle notification</li>
            @endforelse

            
          </ul>
        </div>
      </div>
    </div>

    <!-- Contenu des vues enfants -->
    @yield('content')

    <footer class="text-center py-3 mt-4">
      <small>© 2026 • Prototype pilote - FinanceConsolidated</small>
    </footer>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>