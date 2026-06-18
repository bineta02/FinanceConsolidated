<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FinanceConsolidated | Financement Alternatif</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <style>
    :root {
      --primary: #0E6B3E;
      --primary-dark: #0a5230;
      --primary-light: #e6f4ee;
    }
    body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; }

    .navbar-landing { background: #fff; border-bottom: 1px solid #e9ecef; padding: 0.7rem 0; }

    .btn-green {
      background: var(--primary);
      color: #fff;
      border: none;
      border-radius: 50px;
      padding: 0.45rem 1.3rem;
      font-weight: 600;
      transition: background 0.2s;
    }
    .btn-green:hover { background: var(--primary-dark); color: #fff; }

    .btn-outline-green {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
      border-radius: 50px;
      padding: 0.45rem 1.3rem;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-outline-green:hover { background: var(--primary); color: #fff; }

    .hero-landing {
      padding: 5rem 0 4rem;
      background: linear-gradient(135deg, #fff 55%, var(--primary-light) 100%);
    }

    .section-title { font-weight: 800; font-size: 2rem; color: #1a1a1a; }

    .card-modern {
      background: #fff;
      border-radius: 16px;
      border: 1px solid #e4ede9;
      transition: transform 0.25s, box-shadow 0.25s;
    }
    .card-modern:hover {
      transform: translateY(-5px);
      box-shadow: 0 14px 36px rgba(14,107,62,0.13);
    }

    .icon-circle {
      width: 58px;
      height: 58px;
      background: var(--primary-light);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: var(--primary);
      margin-bottom: 1rem;
    }

    .actor-card { cursor: pointer; }

    .hero-badge {
      background: var(--primary-light);
      color: var(--primary);
      border: none;
      font-weight: 600;
    }

    .auth-card {
      border-radius: 20px !important;
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .toast-custom {
      position: fixed;
      bottom: 1.5rem;
      right: 1.5rem;
      z-index: 9999;
    }

    footer { background: #fff; border-top: 1px solid #e9ecef; }

    .nav-item.cursor-pointer { cursor: pointer; }
    .active-tab {
      color: var(--primary) !important;
      border-bottom: 2px solid var(--primary);
    }
    .text-primary-green { color: var(--primary); }

    .hero-img-wrap {
      background: var(--primary-light);
      border-radius: 16px;
      height: 280px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap: 1rem;
    }
  </style>
</head>
<body>

<div id="landingApp">
 
  <nav class="navbar navbar-expand-lg navbar-landing sticky-top py-1">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 180px; width: auto;">
      </a>
      <div>
        <button class="btn btn-outline-green me-2" id="showLoginBtn">Connexion</button>
        <button class="btn btn-green" id="showRegisterBtn">Inscription</button>
      </div>
    </div>
  </nav>

  <section class="hero-landing">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-aos="fade-right">
          <span class="badge hero-badge rounded-pill py-2 px-3 mb-3">
            <i class="fas fa-hand-holding-usd me-1"></i> Financement alternatif
          </span>
          <h1 style="font-weight:800; font-size:2.8rem; line-height:1.2;">
            Libérez le capital <span class="text-primary-green">vert</span> pour les jeunes entrepreneurs
          </h1>
          <p class="lead text-muted mt-3">
            FinanceConsolidated connecte bailleurs, retraités et projets innovants. Plateforme sécurisée, évaluation IA &amp; suivi en temps réel.
          </p>
          <div class="mt-4 d-flex gap-2 flex-wrap">
            <button class="btn btn-green px-4 py-2" id="heroRegisterBtn">
              <i class="fas fa-user-plus me-2"></i>Rejoindre
            </button>
            <button class="btn btn-outline-green px-4 py-2" id="heroLoginBtn">
              <i class="fas fa-sign-in-alt me-2"></i>Se connecter
            </button>
          </div>
        </div>
        <div class="col-lg-6 text-center" data-aos="fade-left">
          <div class="bg-white p-4 rounded-4 shadow-sm d-inline-block" style="max-width:420px; width:100%;">
            <div class="hero-img-wrap">
              <img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 200px; width: auto;">      
              <p style="color:var(--primary); font-weight:700; font-size:1.1rem; margin:0;">Investir. Connecter. Grandir.</p>
              <p class="text-muted small mb-0">Plateforme de financement alternatif &amp; inclusif</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Trois acteurs, une mission commune</h2>
        <p class="text-muted">Des espaces personnalisés pour chaque profil</p>
      </div>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
          <div class="card-modern p-4 text-center actor-card">
            <div class="icon-circle mx-auto"><i class="fas fa-chart-line"></i></div>
            <h4 class="fw-bold">Bailleur / Retraité</h4>
            <p class="text-muted">Définissez vos critères, investissez dans des projets porteurs, suivez vos rendements et échéances.</p>
            <button class="btn btn-outline-green mt-2 choose-actor-btn" data-actor="bailleur">Je suis bailleur</button>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card-modern p-4 text-center actor-card">
            <div class="icon-circle mx-auto"><i class="fas fa-rocket"></i></div>
            <h4 class="fw-bold">Jeune Entrepreneur</h4>
            <p class="text-muted">Déposez votre projet, recevez des financements, gérez vos remboursements et suivez vos investisseurs.</p>
            <button class="btn btn-outline-green mt-2 choose-actor-btn" data-actor="entrepreneur">Je suis entrepreneur</button>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="card-modern p-4 text-center actor-card">
            <div class="icon-circle mx-auto"><i class="fas fa-shield-alt"></i></div>
            <h4 class="fw-bold">Administrateur</h4>
            <p class="text-muted">Supervision globale, validation des projets, gestion des utilisateurs et tableaux de bord.</p>
            <button class="btn btn-outline-green mt-2 choose-actor-btn" data-actor="admin">Je suis admin</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" style="background: var(--primary-light);">
    <div class="container">
      <div class="text-center mb-4">
        <h2 class="section-title">Pourquoi FinanceConsolidated ?</h2>
      </div>
      <div class="row g-4">
        <div class="col-md-4" data-aos="zoom-in">
          <div class="card-modern p-4 text-center">
            <div class="icon-circle mx-auto"><i class="fas fa-building"></i></div>
            <h5 class="fw-bold">Espace Bailleur</h5>
            <p class="text-muted">Définissez vos critères, montant max, garanties, bénéfices attendus.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
          <div class="card-modern p-4 text-center">
            <div class="icon-circle mx-auto"><i class="fas fa-gavel"></i></div>
            <h5 class="fw-bold">Module Juridique</h5>
            <p class="text-muted">Contrats intelligents, engagements, archivage des preuves.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
          <div class="card-modern p-4 text-center">
            <div class="icon-circle mx-auto"><i class="fas fa-calendar-check"></i></div>
            <h5 class="fw-bold">Suivi remboursement</h5>
            <p class="text-muted">Échéanciers, alertes, suivi des paiements transparent.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="pt-4 pb-3 text-center">
    <div class="container">
      <img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 180px; width: auto;">
      <p class="small mb-0 text-muted">©️ 2026 FinanceConsolidated – Prototype pilote | Financement alternatif &amp; inclusif</p>
    </div>
  </footer>
</div>

<div class="modal fade" id="authModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 auth-card">
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 180px; width: auto;">
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        
        <ul class="nav border-0 mb-4 d-flex justify-content-around" style="border-bottom: 2px solid #e9ecef;">
          <li class="nav-item cursor-pointer active-tab" id="tabLoginBtn" style="font-size:1.1rem; font-weight:700; padding:0 0 10px 0; list-style:none;">Connexion</li>
          <li class="nav-item cursor-pointer text-muted" id="tabRegisterBtn" style="font-size:1.1rem; font-weight:600; padding:0 0 10px 0; list-style:none;">Inscription</li>
        </ul>

        <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" id="loginEmail" placeholder="ex: bailleur@test.com" value="{{ old('email') }}">
            @if(session('error_type') === 'connexion')
              @error('email')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
              @enderror
            @endif
          </div>
          <div class="mb-4">
            <label class="form-label fw-semibold">Mot de passe</label>
            <input type="password" class="form-control rounded-pill @error('mot_de_passe') is-invalid @enderror" name="mot_de_passe" id="loginPassword" placeholder="••••••">
            @if(session('error_type') === 'connexion')
              @error('mot_de_passe')
                <div class="invalid-feedback ps-2">{{ $message }}</div>
              @enderror
            @endif
          </div>
          <div class="mb-3 form-check ms-2">
            <input type="checkbox" class="form-check-input" name="remember" id="rememberMe">
            <label class="form-check-label small text-muted" for="rememberMe">Se souvenir de moi</label>
          </div>
          <button type="submit" class="btn btn-green w-100 rounded-pill py-2" id="doLoginBtn">
            Se connecter <i class="fas fa-arrow-right ms-2"></i>
          </button>
        </form>

        <form id="registerForm" method="POST" action="{{ route('register.submit') }}" style="display:none;">
          @csrf 
          <div class="row mb-2">
            <div class="col">
              <input type="text" class="form-control rounded-pill @error('prenom') is-invalid @enderror" name="prenom" id="regPrenom" placeholder="Prénom" value="{{ old('prenom') }}">
              @error('prenom') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
            </div>
            <div class="col">
              <input type="text" class="form-control rounded-pill @error('nom') is-invalid @enderror" name="nom" id="regNom" placeholder="Nom" value="{{ old('nom') }}">
              @error('nom') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
            </div>
          </div>
          
          <div class="mb-2">
            <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" id="regEmail" placeholder="Email" value="{{ session('error_type') === 'inscription' ? old('email') : '' }}">
            @if(session('error_type') === 'inscription')
              @error('email') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
            @endif
          </div>

          <div class="mb-2">
            <input type="text" class="form-control rounded-pill @error('telephone') is-invalid @enderror" name="telephone" id="regTel" placeholder="Téléphone (ex: +221...)" value="{{ old('telephone') }}">
            @error('telephone') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
          </div>
          
          <div class="mb-2">
            <select class="form-select rounded-pill @error('role') is-invalid @enderror" name="role" id="regRole">
              <option value="bailleur" {{ old('role') === 'bailleur' ? 'selected' : '' }}>Bailleur / Retraité</option>
              <option value="entrepreneur" {{ old('role') === 'entrepreneur' ? 'selected' : '' }}>Jeune Entrepreneur</option>
            </select>
            @error('role') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
          </div>
          
          <div class="mb-2">
            <input type="password" class="form-control rounded-pill @error('mot_de_passe') is-invalid @enderror" name="mot_de_passe" id="regPassword" placeholder="Mot de passe (min 6 caractères)">
            @if(session('error_type') === 'inscription')
              @error('mot_de_passe') <div class="invalid-feedback ps-2">{{ $message }}</div> @enderror
            @endif
          </div>

          <div class="mb-3">
            <input type="password" class="form-control rounded-pill" name="mot_de_passe_confirmation" id="regPasswordConfirm" placeholder="Confirmer le mot de passe">
          </div>
          
          <button type="submit" class="btn btn-green w-100 rounded-pill py-2" id="doRegisterBtn">
            S'inscrire &amp; se connecter
          </button>
          
          <p class="text-center text-muted small mt-3">Les administrateurs sont créés manuellement.</p>
        </form>

      </div>
    </div>
  </div>
</div>

<div class="toast-container toast-custom">
  <div id="liveToast" class="toast" data-bs-autohide="true" data-bs-delay="4000">
    <div class="toast-header text-white" style="background:var(--primary);">
      <strong><i class="fas fa-check-circle me-2"></i> FinanceConsolidated</strong>
      <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body" id="toastMessage">Notification</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 700 });

  const authModal = new bootstrap.Modal(document.getElementById('authModal'));
  const toastEl  = document.getElementById('liveToast');
  const toast    = new bootstrap.Toast(toastEl);

  function showToast(msg) {
    document.getElementById('toastMessage').textContent = msg;
    toast.show();
  }

  // Intercepter les messages flash de succès Laravel
  @if(session('success'))
    showToast("{{ session('success') }}");
  @endif

  function openModal(tab) { switchTab(tab); authModal.show(); }

  function switchTab(tab) {
    const lf = document.getElementById('loginForm');
    const rf = document.getElementById('registerForm');
    const tl = document.getElementById('tabLoginBtn');
    const tr = document.getElementById('tabRegisterBtn');
    if (tab === 'login') {
      lf.style.display = ''; rf.style.display = 'none';
      tl.classList.add('active-tab'); tr.classList.remove('active-tab');
    } else {
      lf.style.display = 'none'; rf.style.display = '';
      tr.classList.add('active-tab'); tl.classList.remove('active-tab');
    }
  }

  document.getElementById('showLoginBtn').addEventListener('click', () => openModal('login'));
  document.getElementById('showRegisterBtn').addEventListener('click', () => openModal('register'));
  document.getElementById('heroLoginBtn').addEventListener('click', () => openModal('login'));
  document.getElementById('heroRegisterBtn').addEventListener('click', () => openModal('register'));
  document.getElementById('tabLoginBtn').addEventListener('click', () => switchTab('login'));
  document.getElementById('tabRegisterBtn').addEventListener('click', () => switchTab('register'));
  
  // Gestion dynamique du clic sur "Je suis bailleur/entrepreneur" pour présélectionner le rôle
  document.querySelectorAll('.choose-actor-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const actor = this.getAttribute('data-actor');
      if (actor === 'admin') {
        openModal('login');
      } else {
        document.getElementById('regRole').value = actor;
        openModal('register');
      }
    });
  });

  // RÉOUVERTURE DU MODAL AUTOMATIQUE EN CAS D'ERREURS
  @if ($errors->any())
    let errorType = "{{ session('error_type') }}";
    if (errorType === 'connexion') {
      openModal('login');
    } else {
      openModal('register');
    }
  @endif
</script>
</body>
</html>