<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>FinanceConsolidated | Espace Entrepreneur</title>
  <!-- Bootstrap 5 + Icons + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <style>
    :root {
      --primary-green: #0e6b3e;
      --light-green: #e8f3ef;
      --dark-green: #095a34;
      --pure-white: #ffffff;
      --off-white: #f9fbfa;
      --text-dark: #1e2a2c;
      --accent-blue: #2c7da0;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', 'Inter', system-ui, sans-serif;
      background: var(--off-white);
      min-height: 100vh;
    }
    /* Layout entrepreneur */
    .entrepreneur-wrapper {
      display: flex;
      min-height: 100vh;
    }
    .sidebar-entrepreneur {
      width: 280px;
      background: var(--pure-white);
      box-shadow: 2px 0 20px rgba(0,0,0,0.03);
      position: fixed;
      height: 100vh;
      overflow-y: auto;
      transition: all 0.3s;
      z-index: 100;
    }
    .main-content {
      flex: 1;
      margin-left: 280px;
      padding: 1.5rem 2rem;
    }
    .sidebar-brand {
      padding: 1.8rem 1.5rem;
      border-bottom: 1px solid #edf2f0;
    }
    .sidebar-brand h3 {
      color: var(--primary-green);
      font-weight: 700;
      margin: 0;
    }
    .sidebar-brand h3 i { font-size: 1.8rem; margin-right: 8px; }
    .nav-entrepreneur {
      padding: 1.5rem 0;
    }
    .nav-entrepreneur .nav-item {
      list-style: none;
      margin-bottom: 0.3rem;
    }
    .nav-entrepreneur .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.75rem 1.8rem;
      color: #4a5b55;
      font-weight: 500;
      transition: 0.2s;
      border-left: 3px solid transparent;
    }
    .nav-entrepreneur .nav-link i { width: 24px; font-size: 1.2rem; }
    .nav-entrepreneur .nav-link.active, .nav-entrepreneur .nav-link:hover {
      background: var(--light-green);
      color: var(--primary-green);
      border-left-color: var(--primary-green);
    }
    .top-bar {
      background: white;
      border-radius: 24px;
      padding: 0.8rem 1.5rem;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
      margin-bottom: 1.8rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .stat-card {
      background: white;
      border-radius: 28px;
      padding: 1.2rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.02);
      transition: transform 0.2s;
      height: 100%;
    }
    .stat-card:hover { transform: translateY(-3px); }
    .card-modern {
      border: none;
      border-radius: 24px;
      background: white;
      transition: all 0.2s;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .progress-custom { height: 8px; border-radius: 10px; background: #e0ede7; }
    .progress-bar-custom { background: var(--primary-green); border-radius: 10px; }
    .btn-green {
      background: var(--primary-green);
      border: none;
      color: white;
      border-radius: 40px;
      padding: 0.5rem 1.5rem;
      font-weight: 500;
      transition: 0.2s;
    }
    .btn-green:hover { background: var(--dark-green); transform: translateY(-1px); }
    .btn-outline-green {
      border: 1.5px solid var(--primary-green);
      color: var(--primary-green);
      background: transparent;
      border-radius: 40px;
      padding: 0.4rem 1.2rem;
      font-weight: 500;
    }
    .btn-outline-green:hover { background: var(--primary-green); color: white; }
    .toast-custom {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1100;
    }
    .badge-progress {
      background: #eafaf1;
      color: var(--primary-green);
      border-radius: 50px;
      padding: 0.3rem 0.8rem;
      font-size: 0.75rem;
    }
    @media (max-width: 992px) {
      .sidebar-entrepreneur { transform: translateX(-100%); position: fixed; }
      .main-content { margin-left: 0; }
      .sidebar-entrepreneur.mobile-open { transform: translateX(0); }
    }
    footer { background: transparent; border-top: 1px solid #e2ece8; margin-top: 2rem; }
  </style>
</head>
<body>

<div class="entrepreneur-wrapper">
  <!-- SIDEBAR ENTREPRENEUR -->
  <aside class="sidebar-entrepreneur" id="sidebar">
    <div class="sidebar-brand">
      <h3><img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 80px; width: auto;">FinanceConsolidated</h3>
      <p class="text-muted small mb-0">Espace Entrepreneur</p>
    </div>
    <ul class="nav-entrepreneur flex-column">
      <li class="nav-item"><a class="nav-link active" href="#" data-page="dashboard"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="mes-projets"><i class="fas fa-folder-open"></i> Mes projets</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="nouveau-projet"><i class="fas fa-plus-circle"></i> Déposer un projet</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="financements"><i class="fas fa-hand-holding-usd"></i> Financements reçus</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="remboursements"><i class="fas fa-calendar-check"></i> Échéances & remboursements</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="contrats"><i class="fas fa-file-signature"></i> Contrats & garanties</a></li>
      <li class="nav-item mt-4"><a class="nav-link text-danger" href="{{ route('logout') }}" ><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>
    <div class="p-3 text-center small text-muted">© 2025 • Prototype pilote</div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <div class="top-bar">
      <div><i class="fas fa-bars d-lg-none fs-4" id="menuToggle" style="cursor:pointer;"></i> <span class="ms-2 fw-semibold">Bienvenue, <span id="entrepreneurName">Porteur de projet</span></span></div>
      <div><i class="fas fa-bell text-muted"></i> <span class="badge bg-success rounded-pill ms-1" id="notificationBadge">0</span></div>
    </div>

    <!-- Contenu dynamique -->
    <div id="pageContainer"></div>
    <footer class="text-center py-3"><small>Plateforme de financement alternatif - Suivi des échéances & garanties intégrées</small></footer>
  </main>
</div>

<!-- Toast notification -->
<div class="toast-container toast-custom">
  <div id="liveToast" class="toast" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header bg-success text-white"><strong><i class="fas fa-check-circle me-2"></i> GreenCapital</strong><button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast"></button></div>
    <div class="toast-body" id="toastMessage">Notification</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ========== DONNÉES MOCK ENTREPRENEUR ==========
  let entrepreneur = {
    id: 1,
    name: "Aïssatou Kane",
    email: "entrepreneur@greencapital.sn",
    telephone: "+221 77 123 45 67",
    secteur: "AgriTech"
  };

  // Projets de l'entrepreneur
  let mesProjets = [
    { 
      id: 101, 
      name: "AgriDrive Sénégal", 
      desc: "Solution IoT pour irrigation connectée et optimisation des rendements agricoles.",
      goal: 8000000, 
      collected: 4200000, 
      category: "Agriculture",
      status: "en_cours",   // en_cours, complete, en_attente
      dateDepot: "2025-01-10",
      dureeRemboursement: 24,
      tauxInteret: 8.5,
      investisseurs: [
        { name: "Mamadou Diallo", amount: 500000, date: "2025-02-10" },
        { name: "Fatou Sarr", amount: 300000, date: "2025-02-15" }
      ],
      remboursementsEffectues: 450000,
      prochainEcheance: "2025-06-15",
      montantEcheance: 180000
    },
    { 
      id: 102, 
      name: "Green Énergie Solaire", 
      desc: "Installation de panneaux solaires pour villages ruraux.",
      goal: 12000000, 
      collected: 7200000, 
      category: "Énergie",
      status: "en_cours",
      dateDepot: "2025-02-20",
      dureeRemboursement: 36,
      tauxInteret: 7.2,
      investisseurs: [
        { name: "Mme Diop", amount: 1000000, date: "2025-03-01" },
        { name: "Club Invest", amount: 6200000, date: "2025-03-05" }
      ],
      remboursementsEffectues: 0,
      prochainEcheance: "2025-07-01",
      montantEcheance: 250000
    }
  ];

  let financementsRecus = [
    { projetId: 101, montantTotal: 4200000, dateDernierVersement: "2025-02-15", investisseursCount: 2 },
    { projetId: 102, montantTotal: 7200000, dateDernierVersement: "2025-03-05", investisseursCount: 2 }
  ];

  let contratsEntrepreneur = [
    { type: "Contrat de financement participatif", projet: "AgriDrive Sénégal", signe: true, date: "2025-02-20" },
    { type: "Garantie personnelle", projet: "Green Énergie Solaire", signe: true, date: "2025-03-10" }
  ];

  // Fonctions utilitaires
  function showToast(msg, type = "success") {
    const toastEl = document.getElementById('liveToast');
    const toastBody = document.getElementById('toastMessage');
    toastBody.innerText = msg;
    const header = toastEl.querySelector('.toast-header');
    header.classList.remove('bg-success', 'bg-danger', 'bg-warning');
    if (type === 'success') header.classList.add('bg-success');
    else if (type === 'danger') header.classList.add('bg-danger');
    else header.classList.add('bg-warning');
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
  }

  function saveData() {
    localStorage.setItem('entrepreneurData', JSON.stringify(entrepreneur));
    localStorage.setItem('mesProjets', JSON.stringify(mesProjets));
    localStorage.setItem('financementsRecus', JSON.stringify(financementsRecus));
    localStorage.setItem('contratsEntrepreneur', JSON.stringify(contratsEntrepreneur));
  }

  function loadStoredData() {
    let stored = localStorage.getItem('entrepreneurData');
    if (stored) entrepreneur = JSON.parse(stored);
    let storedProjets = localStorage.getItem('mesProjets');
    if (storedProjets) mesProjets = JSON.parse(storedProjets);
    let storedFinancements = localStorage.getItem('financementsRecus');
    if (storedFinancements) financementsRecus = JSON.parse(storedFinancements);
    let storedContrats = localStorage.getItem('contratsEntrepreneur');
    if (storedContrats) contratsEntrepreneur = JSON.parse(storedContrats);
    document.getElementById('entrepreneurName').innerText = entrepreneur.name;
    // Notification pour échéances proches
    let echeancesProches = mesProjets.filter(p => p.status === 'en_cours' && p.prochainEcheance && new Date(p.prochainEcheance) < new Date(new Date().setDate(new Date().getDate() + 14))).length;
    document.getElementById('notificationBadge').innerText = echeancesProches;
  }

  // ========== RENDU DES PAGES ==========
  const pageContainer = document.getElementById('pageContainer');

  // Dashboard
  function renderDashboard() {
    let totalCollecte = mesProjets.reduce((sum, p) => sum + p.collected, 0);
    let totalObjectif = mesProjets.reduce((sum, p) => sum + p.goal, 0);
    let progressionGlobale = totalObjectif > 0 ? (totalCollecte / totalObjectif) * 100 : 0;
    let projetsActifs = mesProjets.filter(p => p.status === 'en_cours').length;
    let totalRembourse = mesProjets.reduce((sum, p) => sum + p.remboursementsEffectues, 0);
    let totalRestant = mesProjets.reduce((sum, p) => sum + (p.collected - p.remboursementsEffectues), 0);
    
    return `
      <div>
        <h3 class="fw-bold mb-4"><i class="fas fa-chart-line text-success me-2"></i>Tableau de bord</h3>
        <div class="row g-4 mb-5">
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Fonds collectés</small><h2 class="fw-bold text-success">${totalCollecte.toLocaleString()} FCFA</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Projets actifs</small><h2 class="fw-bold">${projetsActifs}</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Déjà remboursé</small><h2 class="fw-bold text-success">${totalRembourse.toLocaleString()} FCFA</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Reste à rembourser</small><h2 class="fw-bold text-warning">${totalRestant.toLocaleString()} FCFA</h2></div></div>
        </div>
        <div class="row">
          <div class="col-md-7"><div class="card-modern p-3"><h5>Progression globale des financements</h5><canvas id="progressionChart" width="400" height="200"></canvas></div></div>
          <div class="col-md-5"><div class="card-modern p-3"><h5>Conseil IA</h5><div class="alert alert-light-green bg-soft-green"><i class="fas fa-robot text-success"></i> Votre projet AgriDrive a atteint 52% de financement. Partagez votre pitch sur les réseaux pour accélérer !</div><hr><h6>Prochaine échéance</h6>${mesProjets.filter(p=>p.status==='en_cours' && p.prochainEcheance).slice(0,1).map(p=>`<div><strong>${p.name}</strong> : ${p.prochainEcheance} - ${p.montantEcheance.toLocaleString()} FCFA</div>`).join('') || 'Aucune échéance à venir'}</div></div>
        </div>
      </div>
    `;
  }

  // Mes projets
  function renderMesProjets() {
    if (mesProjets.length === 0) return `<div class="alert alert-info">Vous n'avez pas encore déposé de projet. <a href="#" data-page="nouveau-projet" class="alert-link">Cliquez ici pour créer votre premier projet</a>.</div>`;
    let html = `<h3 class="fw-bold mb-4"><i class="fas fa-folder-open"></i> Mes projets</h3><div class="row g-4">`;
    mesProjets.forEach(p => {
      let percent = (p.collected / p.goal) * 100;
      let statusBadge = p.status === 'en_cours' ? '<span class="badge bg-success">En cours de financement</span>' : (p.status === 'complete' ? '<span class="badge bg-secondary">Complété</span>' : '<span class="badge bg-warning">En attente</span>');
      html += `<div class="col-12"><div class="card-modern p-4">
        <div class="d-flex justify-content-between align-items-start flex-wrap"><div><h4 class="fw-bold">${p.name}</h4><p class="text-muted small">Déposé le ${p.dateDepot} • ${p.category}</p></div>${statusBadge}</div>
        <p>${p.desc}</p>
        <div class="progress-custom mt-2"><div class="progress-bar-custom" style="width:${percent}%"></div></div>
        <div class="d-flex justify-content-between mt-2"><span>Collecté : ${(p.collected/1e6).toFixed(1)}M FCFA</span><span>Objectif : ${(p.goal/1e6).toFixed(1)}M FCFA (${percent.toFixed(0)}%)</span></div>
        <hr><div class="row small text-muted"><div class="col-md-4"><i class="fas fa-chart-line"></i> Taux : ${p.tauxInteret}%</div><div class="col-md-4"><i class="fas fa-clock"></i> Durée : ${p.dureeRemboursement} mois</div><div class="col-md-4"><i class="fas fa-users"></i> ${p.investisseurs.length} investisseurs</div></div>
        <button class="btn btn-outline-green mt-2 btn-sm voirDetailsProjet" data-id="${p.id}"><i class="fas fa-eye"></i> Voir les investisseurs</button>
      </div></div>`;
    });
    html += `</div>`;
    return html;
  }

  // Nouveau projet (formulaire)
  function renderNouveauProjet() {
    return `
      <h3 class="fw-bold mb-4"><i class="fas fa-plus-circle text-success"></i> Déposer un nouveau projet</h3>
      <div class="card-modern p-4">
        <div class="mb-3"><label class="form-label">Nom du projet *</label><input type="text" class="form-control" id="projName" placeholder="ex: Eco-Transport Dakar"></div>
        <div class="mb-3"><label class="form-label">Description détaillée *</label><textarea class="form-control" id="projDesc" rows="3" placeholder="Décrivez votre projet, son impact social/environnemental..."></textarea></div>
        <div class="mb-3"><label class="form-label">Montant recherché (FCFA) *</label><input type="number" class="form-control" id="projGoal" placeholder="ex: 5000000"></div>
        <div class="mb-3"><label class="form-label">Catégorie</label><select class="form-select" id="projCategory"><option>Agriculture</option><option>Tech</option><option>Artisanat</option><option>Éducation</option><option>Énergie</option><option>Santé</option></select></div>
        <div class="mb-3"><label class="form-label">Durée de remboursement proposée (mois)</label><input type="number" class="form-control" id="projDuree" value="24"></div>
        <div class="mb-3"><label class="form-label">Taux d'intérêt proposé (%)</label><input type="number" step="0.5" class="form-control" id="projTaux" value="8"></div>
        <button class="btn btn-green w-100" id="submitProjetBtn"><i class="fas fa-save me-2"></i> Soumettre mon projet</button>
        <div class="alert alert-light mt-3 small">ℹ️ Après validation par notre équipe, votre projet sera visible par les bailleurs.</div>
      </div>
    `;
  }

  // Financements reçus
  function renderFinancements() {
    let totalFinancements = financementsRecus.reduce((sum, f) => sum + f.montantTotal, 0);
    return `
      <h3 class="fw-bold mb-4"><i class="fas fa-hand-holding-usd"></i> Financements reçus</h3>
      <div class="row mb-4"><div class="col-md-4"><div class="stat-card"><h5>Total reçu</h5><h2 class="text-success">${totalFinancements.toLocaleString()} FCFA</h2></div></div></div>
      <div class="card-modern p-3"><div class="table-responsive"><table class="table"><thead><tr><th>Projet</th><th>Montant total</th><th>Dernier versement</th><th>Investisseurs</th></tr></thead><tbody>
      ${financementsRecus.map(f => {
        let projet = mesProjets.find(p => p.id === f.projetId);
        return `<tr><td><strong>${projet ? projet.name : 'Projet'}</strong></td><td>${f.montantTotal.toLocaleString()} FCFA</td><td>${f.dateDernierVersement}</td><td>${f.investisseursCount}</td></tr>`;
      }).join('')}
      </tbody></table></div></div>
    `;
  }

  // Échéances & remboursements
  function renderRemboursements() {
    let echeances = mesProjets.filter(p => p.status === 'en_cours' && p.prochainEcheance);
    if (echeances.length === 0) return `<div class="alert alert-info">Aucune échéance de remboursement programmée.</div>`;
    let html = `<h3 class="fw-bold mb-4"><i class="fas fa-calendar-alt"></i> Échéancier des remboursements</h3><div class="row g-4">`;
    echeances.forEach(p => {
      let percentRembourse = (p.remboursementsEffectues / p.collected) * 100;
      html += `<div class="col-md-6"><div class="card-modern p-3"><div class="d-flex justify-content-between"><h5>${p.name}</h5><span class="badge bg-warning">Prochaine échéance</span></div>
        <div class="mt-2"><strong>${p.prochainEcheance}</strong> - ${p.montantEcheance.toLocaleString()} FCFA</div>
        <div class="progress-custom mt-2"><div class="progress-bar-custom" style="width:${percentRembourse}%"></div></div>
        <div class="d-flex justify-content-between small mt-1"><span>Déjà remboursé : ${p.remboursementsEffectues.toLocaleString()} FCFA</span><span>Reste : ${(p.collected - p.remboursementsEffectues).toLocaleString()} FCFA</span></div>
        <button class="btn btn-sm btn-outline-green mt-3 effectuerRemboursementBtn" data-id="${p.id}" data-montant="${p.montantEcheance}"><i class="fas fa-credit-card"></i> Simuler un remboursement</button>
      </div></div>`;
    });
    html += `</div>`;
    return html;
  }

  // Contrats & garanties
  function renderContrats() {
    return `
      <h3 class="fw-bold mb-4"><i class="fas fa-file-contract"></i> Contrats & Garanties</h3>
      <div class="card-modern p-4 mb-4">
        <h5>Documents contractuels</h5>
        <ul class="list-group mt-3">${contratsEntrepreneur.map(c => `<li class="list-group-item d-flex justify-content-between"><span><i class="fas fa-file-pdf text-danger"></i> ${c.type} - ${c.projet}</span><span class="badge bg-success">Signé le ${c.date}</span></li>`).join('')}</ul>
      </div>
      <div class="card-modern p-4">
        <h5><i class="fas fa-shield-alt text-success"></i> Mes garanties actives</h5>
        <p>✅ Garantie personnelle d'honneur<br>✅ Contrat de financement participatif standard (GreenCapital v2.1)<br>✅ Archivage des preuves sur registre numérique</p>
        <div class="alert alert-light-green">🔒 Les garanties sont opposables et sécurisées par cryptage quantique (phase pilote).</div>
      </div>
    `;
  }

  // Gestionnaires d'événements
  function attachProjetDetails() {
    document.querySelectorAll('.voirDetailsProjet').forEach(btn => {
      btn.removeEventListener('click', detailsHandler);
      btn.addEventListener('click', detailsHandler);
    });
  }
  function detailsHandler(e) {
    let id = parseInt(e.currentTarget.getAttribute('data-id'));
    let projet = mesProjets.find(p => p.id === id);
    if (projet && projet.investisseurs.length) {
      let liste = projet.investisseurs.map(i => `${i.name} : ${i.amount.toLocaleString()} FCFA (${i.date})`).join('\n');
      alert(`Investisseurs pour ${projet.name} :\n${liste}`);
    } else {
      alert(`Aucun investisseur enregistré pour ce projet pour le moment.`);
    }
  }

  function attachRemboursementSimu() {
    document.querySelectorAll('.effectuerRemboursementBtn').forEach(btn => {
      btn.removeEventListener('click', remboursementHandler);
      btn.addEventListener('click', remboursementHandler);
    });
  }
  function remboursementHandler(e) {
    let projetId = parseInt(e.currentTarget.getAttribute('data-id'));
    let montantEcheance = parseInt(e.currentTarget.getAttribute('data-montant'));
    let projet = mesProjets.find(p => p.id === projetId);
    if (projet) {
      let confirmation = confirm(`Simulation de remboursement : ${montantEcheance.toLocaleString()} FCFA pour "${projet.name}". Confirmez-vous cet envoi ? (Mode démo)`);
      if (confirmation) {
        projet.remboursementsEffectues += montantEcheance;
        projet.collected -= montantEcheance; // mise à jour du restant dû
        showToast(`✅ Remboursement de ${montantEcheance.toLocaleString()} FCFA enregistré pour ${projet.name}.`, "success");
        saveData();
        renderCurrentPage('remboursements');
      }
    }
  }

  function attachSubmitProjet() {
    let btn = document.getElementById('submitProjetBtn');
    if (btn) {
      btn.removeEventListener('click', submitHandler);
      btn.addEventListener('click', submitHandler);
    }
  }
  function submitHandler() {
    let name = document.getElementById('projName').value.trim();
    let desc = document.getElementById('projDesc').value.trim();
    let goal = parseFloat(document.getElementById('projGoal').value);
    let category = document.getElementById('projCategory').value;
    let duree = parseInt(document.getElementById('projDuree').value);
    let taux = parseFloat(document.getElementById('projTaux').value);
    if (!name || !desc || isNaN(goal) || goal <= 0) {
      showToast("Veuillez remplir tous les champs obligatoires", "danger");
      return;
    }
    let newId = Date.now();
    let newProject = {
      id: newId, name, desc, goal, collected: 0, category, status: "en_attente",
      dateDepot: new Date().toISOString().slice(0,10), dureeRemboursement: duree,
      tauxInteret: taux, investisseurs: [], remboursementsEffectues: 0,
      prochainEcheance: null, montantEcheance: 0
    };
    mesProjets.push(newProject);
    saveData();
    showToast(`✅ Projet "${name}" soumis avec succès ! En attente de validation.`, "success");
    renderCurrentPage('mes-projets');
  }

  let chartInstance = null;
  function renderChart() {
    let ctx = document.getElementById('progressionChart');
    if (ctx && mesProjets.length) {
      if (chartInstance) chartInstance.destroy();
      chartInstance = new Chart(ctx, {
        type: 'bar',
        data: { labels: mesProjets.map(p => p.name), datasets: [{ label: 'Collecté (FCFA)', data: mesProjets.map(p => p.collected), backgroundColor: '#0e6b3e', borderRadius: 10 }, { label: 'Objectif (FCFA)', data: mesProjets.map(p => p.goal), backgroundColor: '#e0ede7', borderRadius: 10 }] },
        options: { responsive: true, plugins: { legend: { position: 'top' } } }
      });
    }
  }

  // Routage
  function renderCurrentPage(pageId) {
    let content = "";
    switch (pageId) {
      case 'dashboard': content = renderDashboard(); setTimeout(() => renderChart(), 100); break;
      case 'mes-projets': content = renderMesProjets(); setTimeout(() => attachProjetDetails(), 100); break;
      case 'nouveau-projet': content = renderNouveauProjet(); setTimeout(() => attachSubmitProjet(), 100); break;
      case 'financements': content = renderFinancements(); break;
      case 'remboursements': content = renderRemboursements(); setTimeout(() => attachRemboursementSimu(), 100); break;
      case 'contrats': content = renderContrats(); break;
      default: content = renderDashboard(); setTimeout(() => renderChart(), 100);
    }
    pageContainer.innerHTML = content;
    document.querySelectorAll('.nav-link').forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('data-page') === pageId) link.classList.add('active');
    });
    if (pageId === 'remboursements') attachRemboursementSimu();
    if (pageId === 'mes-projets') attachProjetDetails();
    if (pageId === 'nouveau-projet') attachSubmitProjet();
  }

  // Navigation
  document.querySelectorAll('.nav-link[data-page]').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      let page = link.getAttribute('data-page');
      renderCurrentPage(page);
    });
  });
  document.getElementById('logoutBtn')?.addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem('entrepreneurData');
    showToast("Déconnexion réussie.", "success");
    setTimeout(() => { window.location.href = "index.html"; }, 1000);
  });
  document.getElementById('menuToggle')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.toggle('mobile-open');
  });
  loadStoredData();
  renderCurrentPage('dashboard');
</script>
</body>
</html>