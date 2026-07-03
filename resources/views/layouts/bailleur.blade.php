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
        <a class="nav-link {{ Route::is('bailleur.explorer') ? 'active' : '' }}" href="#">
          <i class="fas fa-search-dollar"></i> Explorer & Investir
        </a>
      </li>

      <!-- 3. Mes investissements -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.investissements') ? 'active' : '' }}" href="#">
          <i class="fas fa-chart-line"></i> Mes investissements
        </a>
      </li>

      <!-- 4. Échéances & Remboursements -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.echeances') ? 'active' : '' }}" href="#">
          <i class="fas fa-calendar-check"></i> Échéances & Remboursements
        </a>
      </li>

      <!-- 5. Mes critères de financement -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.criteres') ? 'active' : '' }}" href="#">
          <i class="fas fa-sliders-h"></i> Mes critères de financement
        </a>
      </li>

      <!-- 6. Garanties & contrats -->
      <li class="nav-item">
        <a class="nav-link {{ Route::is('bailleur.contrats') ? 'active' : '' }}" href="#">
          <i class="fas fa-shield-alt"></i> Garanties & contrats
        </a>
      </li>

      <!-- Déconnexion -->
      <li class="nav-item mt-4">
        <a class="nav-link text-danger" href="{{ route('logout') }}">
          <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
      </li>
    </ul>
  </aside>

  <main class="main-content">
    <div class="top-bar">
      <div>
        <span class="ms-2 fw-semibold">
          Bonjour, <span class="text-success">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
        </span>
      </div>
      <div><i class="fas fa-bell text-muted"></i></div>
    </div>

    <!-- C'est ici que s'injectera le contenu spécifique des vues du bailleur -->
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