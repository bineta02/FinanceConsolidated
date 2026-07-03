<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FinanceConsolidated | Espace Entrepreneur</title>
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
    .entrepreneur-wrapper { display: flex; min-height: 100vh; }
    .sidebar-entrepreneur { width: 280px; background: var(--pure-white); box-shadow: 2px 0 20px rgba(0,0,0,0.03); position: fixed; height: 100vh; overflow-y: auto; z-index: 100; }
    .main-content { flex: 1; margin-left: 280px; padding: 1.5rem 2rem; }
    .sidebar-brand { padding: 1.8rem 1.5rem; border-bottom: 1px solid #edf2f0; }
    .sidebar-brand h3 { color: var(--primary-green); font-weight: 700; margin: 0; }
    .nav-entrepreneur { padding: 1.5rem 0; }
    .nav-entrepreneur .nav-link { display: flex; align-items: center; gap: 12px; padding: 0.75rem 1.8rem; color: #4a5b55; font-weight: 500; text-decoration: none; border-left: 3px solid transparent; }
    .nav-entrepreneur .nav-link.active, .nav-entrepreneur .nav-link:hover { background: var(--light-green); color: var(--primary-green); border-left-color: var(--primary-green); }
    .top-bar { background: white; border-radius: 24px; padding: 0.8rem 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.02); margin-bottom: 1.8rem; display: flex; justify-content: space-between; align-items: center; }
    .card-modern { border: none; border-radius: 24px; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .btn-green { background: var(--primary-green); border: none; color: white; border-radius: 40px; padding: 0.5rem 1.5rem; font-weight: 500; text-decoration: none; }
    .btn-green:hover { background: var(--dark-green); color: white; }
  </style>
</head>
<body>

<div class="entrepreneur-wrapper">
  <aside class="sidebar-entrepreneur">
    <div class="sidebar-brand">
      <h3><img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 80px; width: auto;">Finance</h3>
      <p class="text-muted small mb-0">Espace Entrepreneur</p>
    </div>
    <ul class="nav-entrepreneur flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
      </li>
      
      <li class="nav-item">
  <a class="nav-link {{ Route::is('entrepreneur.projet.index') ? 'active' : '' }}" href="{{ route('entrepreneur.projet.index') }}">
    <i class="fas fa-folder"></i> Mes projets
  </a>
</li>

      <li class="nav-item">
        <a class="nav-link {{ Route::is('entrepreneur.projet.create') ? 'active' : '' }}" href="{{ route('entrepreneur.projet.create') }}">
          <i class="fas fa-plus-circle"></i> Déposer un projet
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('entrepreneur.financements') }}">
          <i class="fas fa-hand-holding-usd"></i> Financements reçus
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('entrepreneur.echeances') }}">
          <i class="fas fa-calendar-alt"></i> Échéances & remboursements
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('entrepreneur.contrats') }}">
          <i class="fas fa-file-contract"></i> Contrats & garanties
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Route::is('entrepreneur.profil.edit') ? 'active' : '' }}" href="{{ route('entrepreneur.profil.edit') }}">
          <i class="fas fa-user-edit"></i> Modifier mon profil
        </a>
      </li>

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
          Bienvenue, <span class="text-success">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
        </span>
      </div>
      <div><i class="fas fa-bell text-muted"></i></div>
    </div>

    @yield('content')

    <footer class="text-center py-3 mt-4"><small>Plateforme de financement alternatif - FinanceConsolidated</small></footer>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>