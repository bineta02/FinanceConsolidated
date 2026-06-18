<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>FinanceConsolidated | Espace Bailleur</title>
  <!-- Bootstrap 5 + Icons + Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Chart.js pour graphiques -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
  <style>
    :root {
      --primary-green: #0e6b3e;
      --light-green: #e8f3ef;
      --dark-green: #095a34;
      --pure-white: #ffffff;
      --off-white: #f9fbfa;
      --text-dark: #1e2a2c;
      --warning-orange: #f39c12;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', 'Inter', system-ui, sans-serif;
      background: var(--off-white);
      min-height: 100vh;
    }
    /* Sidebar & Layout */
    .bailleur-wrapper {
      display: flex;
      min-height: 100vh;
    }
    .sidebar-bailleur {
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
    .sidebar-brand h3 i {
      font-size: 1.8rem;
      margin-right: 8px;
    }
    .nav-bailleur {
      padding: 1.5rem 0;
    }
    .nav-bailleur .nav-item {
      list-style: none;
      margin-bottom: 0.3rem;
    }
    .nav-bailleur .nav-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 0.75rem 1.8rem;
      color: #4a5b55;
      font-weight: 500;
      transition: 0.2s;
      border-radius: 0;
      border-left: 3px solid transparent;
    }
    .nav-bailleur .nav-link i {
      width: 24px;
      font-size: 1.2rem;
    }
    .nav-bailleur .nav-link.active, .nav-bailleur .nav-link:hover {
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
      padding: 0.4rem 1.2rem;
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
    @media (max-width: 992px) {
      .sidebar-bailleur { transform: translateX(-100%); position: fixed; }
      .main-content { margin-left: 0; }
      .sidebar-bailleur.mobile-open { transform: translateX(0); }
    }
    footer { background: transparent; border-top: 1px solid #e2ece8; margin-top: 2rem; }
  </style>
</head>
<body>

<div class="bailleur-wrapper">
  <!-- SIDEBAR BAILLEUR -->
  <aside class="sidebar-bailleur" id="sidebar">
    <div class="sidebar-brand">
      <h3><img src="{{ asset('assets/images/logoFinance.png') }}" alt="Logo" style="max-height: 80px; width: auto;">FinanceConsolidated</h3>
      <p class="text-muted small mb-0">Espace Bailleur</p>
    </div>
    <ul class="nav-bailleur flex-column">
      <li class="nav-item"><a class="nav-link active" href="#" data-page="dashboard"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="investir"><i class="fas fa-search-dollar"></i> Explorer & Investir</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="mes-investissements"><i class="fas fa-chart-line"></i> Mes investissements</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="echeances"><i class="fas fa-calendar-check"></i> Échéances & Remboursements</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="criteres"><i class="fas fa-sliders-h"></i> Mes critères de financement</a></li>
      <li class="nav-item"><a class="nav-link" href="#" data-page="garanties"><i class="fas fa-shield-alt"></i> Garanties & contrats</a></li>
      <li class="nav-item mt-4"><a class="nav-link text-danger" href="{{ route('logout') }}" ><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
    </ul>
    <div class="p-3 text-center small text-muted">© 2025 • Prototype pilote</div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <div class="top-bar">
      <div><i class="fas fa-bars d-lg-none fs-4" id="menuToggle" style="cursor:pointer;"></i> <span class="ms-2 fw-semibold">Bonjour, <span id="bailleurName">Investisseur</span></span></div>
      <div><i class="fas fa-bell text-muted"></i> <span class="badge bg-success rounded-pill ms-1" id="notificationBadge">3</span></div>
    </div>

    <!-- Contenu dynamique -->
    <div id="pageContainer"></div>
    <footer class="text-center py-3"><small>Sécurisé par cryptage quantique (phase pilote) - Taux & garanties contractuels</small></footer>
  </main>
</div>

<!-- Toast notification -->
<div class="toast-container toast-custom">
  <div id="liveToast" class="toast" data-bs-autohide="true" data-bs-delay="3000">
    <div class="toast-header bg-success text-white"><strong><i class="fas fa-check-circle me-2"></i>FinanceConsolidated</strong><button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast"></button></div>
    <div class="toast-body" id="toastMessage">Notification</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ==================== DONNÉES MOCK BAILLEUR ====================
  let bailleur = {
    id: 1,
    name: "Mamadou Diallo",
    email: "bailleur@greencapital.sn",
    totalInvesti: 1250000,
    nbProjetsFinances: 3,
    criteres: { montantMaxAnnu: 5000000, dureeMaxMois: 24, tauxAttendu: 8, garantiesRequises: "personnelle" },
    investments: [
      { id: 101, projectId: 1, projectName: "AgriDrive Sénégal", amount: 500000, date: "2025-02-10", taux: 8, dureeMois: 18, rembourse: 120000, reste: 380000, prochainEcheance: "2025-06-15", statut: "en cours" },
      { id: 102, projectId: 2, projectName: "WeaveUp Création", amount: 350000, date: "2025-01-20", taux: 7.5, dureeMois: 12, rembourse: 175000, reste: 175000, prochainEcheance: "2025-05-10", statut: "en cours" },
      { id: 103, projectId: 3, projectName: "EduConnect Academy", amount: 400000, date: "2025-03-01", taux: 9, dureeMois: 24, rembourse: 50000, reste: 350000, prochainEcheance: "2025-06-01", statut: "en cours" }
    ]
  };

  let projetsDisponibles = [
    { id: 4, name: "SolarKits Pro", desc: "Solutions solaires pour entreprises", goal: 12000000, collected: 4800000, category: "Énergie", risques: "faible", dureeProposee: 24, rendementEstime: 9.5, garantie: "matériel" },
    { id: 5, name: "RecycPlast", desc: "Recyclage plastique innovant", goal: 6500000, collected: 2100000, category: "Environnement", risques: "moyen", dureeProposee: 18, rendementEstime: 11.0, garantie: "caution" },
    { id: 6, name: "SantéMobile", desc: "Application télémédecine rurale", goal: 9500000, collected: 7200000, category: "Santé", risques: "faible", dureeProposee: 20, rendementEstime: 8.2, garantie: "fonds de garantie" }
  ];

  let contratsGaranties = [
    { type: "Contrat de financement participatif", version: "v2.1", signe: true, date: "2025-01-15" },
    { type: "Garantie personnelle", description: "Engagement du porteur", actif: true }
  ];

  // Helper pour afficher toast
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

  // Sauvegarde & mise à jour affichage
  function refreshBailleurData() {
    localStorage.setItem('bailleurData', JSON.stringify(bailleur));
    localStorage.setItem('projetsDisponibles', JSON.stringify(projetsDisponibles));
  }

  function loadStoredData() {
    let stored = localStorage.getItem('bailleurData');
    if (stored) bailleur = JSON.parse(stored);
    let storedProj = localStorage.getItem('projetsDisponibles');
    if (storedProj) projetsDisponibles = JSON.parse(storedProj);
    document.getElementById('bailleurName').innerText = bailleur.name;
    let notifCount = bailleur.investments.filter(i => i.statut === "en cours" && new Date(i.prochainEcheance) < new Date(new Date().setDate(new Date().getDate() + 7))).length;
    document.getElementById('notificationBadge').innerText = notifCount;
  }

  // ========== RENDU DES PAGES ==========
  const pageContainer = document.getElementById('pageContainer');

  // Page Dashboard
  function renderDashboard() {
    let totalRembourse = bailleur.investments.reduce((sum, i) => sum + i.rembourse, 0);
    let totalAttendu = bailleur.investments.reduce((sum, i) => sum + i.amount, 0);
    let rendementProjete = ((totalRembourse / totalAttendu) * 100).toFixed(1);
    let encours = bailleur.investments.reduce((sum, i) => sum + i.reste, 0);
    let graphData = bailleur.investments.map(i => i.amount);
    return `
      <div>
        <h3 class="fw-bold mb-4"><i class="fas fa-chart-pie text-success me-2"></i>Aperçu global</h3>
        <div class="row g-4 mb-5">
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Total investi</small><h2 class="fw-bold text-success">${bailleur.totalInvesti.toLocaleString()} FCFA</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Projets financés</small><h2 class="fw-bold">${bailleur.nbProjetsFinances}</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Remboursé</small><h2 class="fw-bold text-success">${totalRembourse.toLocaleString()} FCFA</h2></div></div>
          <div class="col-md-3"><div class="stat-card"><small class="text-muted">Encours restant</small><h2 class="fw-bold text-warning">${encours.toLocaleString()} FCFA</h2></div></div>
        </div>
        <div class="row">
          <div class="col-md-7"><div class="card-modern p-3"><h5>Rendement estimé</h5><canvas id="rendementChart" width="400" height="200"></canvas></div></div>
          <div class="col-md-5"><div class="card-modern p-3"><h5>Dernières activités</h5><ul class="list-unstyled">${bailleur.investments.slice(0,3).map(i=>`<li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Investissement de ${i.amount.toLocaleString()} FCFA dans ${i.projectName} (${i.date})</li>`).join('')}</ul><a href="#" data-page="mes-investissements" class="small text-success">Voir tout →</a></div></div>
        </div>
      </div>
    `;
  }

  // Page Explorer & Investir
  function renderInvestir() {
    let html = `<h3 class="fw-bold mb-4"><i class="fas fa-rocket text-success"></i> Projets à financer</h3><div class="row g-4">`;
    projetsDisponibles.forEach(p => {
      let percent = (p.collected / p.goal) * 100;
      html += `<div class="col-md-6 col-lg-4"><div class="card-modern p-3">
        <div class="d-flex justify-content-between"><span class="badge bg-light text-dark">${p.category}</span><span class="badge bg-success bg-opacity-10 text-success">Risque ${p.risques}</span></div>
        <h5 class="mt-2 fw-bold">${p.name}</h5><p class="small text-muted">${p.desc}</p>
        <div class="progress-custom mt-2"><div class="progress-bar-custom" style="width:${percent}%"></div></div>
        <div class="d-flex justify-content-between small mt-1"><span>${(p.collected/1e6).toFixed(1)}M / ${(p.goal/1e6).toFixed(1)}M FCFA</span><span>${percent.toFixed(0)}%</span></div>
        <hr><div class="small"><i class="fas fa-chart-line"></i> Rendement estimé : ${p.rendementEstime}% &nbsp;| Durée ${p.dureeProposee} mois</div>
        <button class="btn btn-green w-100 mt-3 investirActionBtn" data-id="${p.id}" data-name="${p.name}" data-rendement="${p.rendementEstime}" data-duree="${p.dureeProposee}"><i class="fas fa-hand-holding-usd"></i> Investir maintenant</button>
      </div></div>`;
    });
    html += `</div><div class="mt-4 alert alert-light border">💡 Vous pouvez définir vos critères de sélection dans l'onglet "Mes critères".</div>`;
    return html;
  }

  // Mes investissements
  function renderMesInvestissements() {
    if (bailleur.investments.length === 0) return `<div class="alert alert-info">Aucun investissement pour le moment.</div>`;
    let rows = bailleur.investments.map(i => `<div class="card-modern p-3 mb-3"><div class="row align-items-center"><div class="col-md-3"><strong>${i.projectName}</strong><br><small class="text-muted">Investi le ${i.date}</small></div><div class="col-md-2">${i.amount.toLocaleString()} FCFA</div><div class="col-md-2">Taux ${i.taux}%</div><div class="col-md-2">Remboursé: ${i.rembourse.toLocaleString()} FCFA</div><div class="col-md-3"><div class="progress-custom"><div class="progress-bar-custom" style="width:${(i.rembourse/i.amount)*100}%;height:6px;"></div></div><span class="small">Reste: ${i.reste.toLocaleString()} FCFA</span></div></div></div>`);
    return `<h3 class="fw-bold mb-4">📊 Mes investissements</h3>${rows}`;
  }

  // Échéances
  function renderEcheances() {
    let echeances = bailleur.investments.filter(i => i.statut === "en cours").map(i => `<div class="card-modern p-3 mb-2"><div class="d-flex justify-content-between"><div><i class="fas fa-calendar-alt text-success"></i> <strong>${i.projectName}</strong> - Prochaine échéance : ${i.prochainEcheance}</div><span class="badge bg-warning">Montant restant ${i.reste.toLocaleString()} FCFA</span></div><div class="small text-muted mt-1">Remboursement estimé mensuel : ${Math.round(i.amount / i.dureeMois).toLocaleString()} FCFA</div><button class="btn btn-sm btn-outline-green mt-2 simulateurBtn" data-montant="${i.reste}">Simuler un versement</button></div>`);
    return `<h3 class="fw-bold mb-3"><i class="fas fa-clock"></i> Échéanciers de remboursement</h3>${echeances.length ? echeances : '<div class="alert alert-secondary">Aucune échéance programmée</div>'}`;
  }

  // Critères
  function renderCriteres() {
    return `<h3 class="fw-bold mb-3">⚙️ Mes critères de financement personnalisés</h3><div class="card-modern p-4"><div class="mb-3"><label>Montant maximum par an (FCFA)</label><input type="number" class="form-control" id="critMontantMax" value="${bailleur.criteres.montantMaxAnnu}"></div><div class="mb-3"><label>Durée de remboursement max (mois)</label><input type="number" class="form-control" id="critDureeMax" value="${bailleur.criteres.dureeMaxMois}"></div><div class="mb-3"><label>Taux de bénéfice attendu (%)</label><input type="number" class="form-control" id="critTaux" step="0.5" value="${bailleur.criteres.tauxAttendu}"></div><div class="mb-3"><label>Garanties exigées</label><select class="form-select" id="critGaranties"><option ${bailleur.criteres.garantiesRequises === 'personnelle' ? 'selected' : ''}>personnelle</option><option ${bailleur.criteres.garantiesRequises === 'matériel' ? 'selected' : ''}>matériel</option><option ${bailleur.criteres.garantiesRequises === 'caution solidaire' ? 'selected' : ''}>caution solidaire</option></select></div><button class="btn btn-green" id="saveCriteresBtn">Enregistrer mes préférences</button></div>`;
  }

  // Garanties et contrats
  function renderGaranties() {
    return `<h3 class="fw-bold mb-3"><i class="fas fa-file-signature"></i> Garanties & Contrats intelligents</h3><div class="card-modern p-4"><p>✅ Contrats numériques signés électroniquement. Archivage des preuves sur blockchain simulée.</p><ul class="list-group">${contratsGaranties.map(c=>`<li class="list-group-item d-flex justify-content-between align-items-center">${c.type} <span class="badge bg-success">${c.signe ? 'Signé' : 'En attente'}</span></li>`).join('')}</ul><div class="alert alert-light-green mt-3 small">🔒 Chaque transaction est protégée par cryptage quantique (prototype). Les garanties sont exécutoires selon le règlement intérieur.</div></div>`;
  }

  // Event listeners dynamiques après injection
  function attachInvestButtons() {
    document.querySelectorAll('.investirActionBtn').forEach(btn => {
      btn.removeEventListener('click', investHandler);
      btn.addEventListener('click', investHandler);
    });
  }
  function investHandler(e) {
    let id = parseInt(e.currentTarget.getAttribute('data-id'));
    let name = e.currentTarget.getAttribute('data-name');
    let rendement = parseFloat(e.currentTarget.getAttribute('data-rendement'));
    let duree = parseInt(e.currentTarget.getAttribute('data-duree'));
    let montant = prompt(`Montant à investir dans "${name}" (FCFA) :\nInvestissement minimum 100 000 FCFA`, "250000");
    if (montant && !isNaN(montant) && parseInt(montant) >= 100000) {
      let amountInvest = parseInt(montant);
      let projet = projetsDisponibles.find(p => p.id === id);
      if (projet) {
        let nouveauCollected = projet.collected + amountInvest;
        if (nouveauCollected <= projet.goal * 1.1) {
          projet.collected = nouveauCollected;
          let newInvest = {
            id: Date.now(), projectId: id, projectName: name, amount: amountInvest, date: new Date().toISOString().slice(0,10),
            taux: rendement, dureeMois: duree, rembourse: 0, reste: amountInvest, prochainEcheance: new Date(new Date().setMonth(new Date().getMonth() + 1)).toISOString().slice(0,10), statut: "en cours"
          };
          bailleur.investments.push(newInvest);
          bailleur.totalInvesti += amountInvest;
          bailleur.nbProjetsFinances = bailleur.investments.length;
          refreshBailleurData();
          loadStoredData();
          showToast(`✅ Investissement de ${amountInvest.toLocaleString()} FCFA dans ${name} effectué !`, "success");
          renderCurrentPage('mes-investissements');
        } else { showToast("Limite de financement du projet dépassée", "danger"); }
      }
    } else { showToast("Montant invalide (minimum 100 000 FCFA)", "warning"); }
  }

  function attachSimulateurButtons() {
    document.querySelectorAll('.simulateurBtn').forEach(btn => {
      btn.removeEventListener('click', simuHandler);
      btn.addEventListener('click', simuHandler);
    });
  }
  function simuHandler(e) {
    let reste = e.currentTarget.getAttribute('data-montant');
    showToast(`📅 Simulation de remboursement : il reste ${parseInt(reste).toLocaleString()} FCFA. Le plan d'amortissement est disponible dans votre contrat.`, "info");
  }

  function attachSaveCriteres() {
    let btn = document.getElementById('saveCriteresBtn');
    if (btn) {
      btn.removeEventListener('click', saveCriteres);
      btn.addEventListener('click', saveCriteres);
    }
  }
  function saveCriteres() {
    let max = document.getElementById('critMontantMax').value;
    let duree = document.getElementById('critDureeMax').value;
    let taux = document.getElementById('critTaux').value;
    let garantie = document.getElementById('critGaranties').value;
    bailleur.criteres = { montantMaxAnnu: parseInt(max), dureeMaxMois: parseInt(duree), tauxAttendu: parseFloat(taux), garantiesRequises: garantie };
    refreshBailleurData();
    showToast("Critères de financement mis à jour", "success");
  }

  let chartInstance = null;
  function renderChart() {
    let ctx = document.getElementById('rendementChart');
    if (ctx && bailleur.investments.length) {
      if (chartInstance) chartInstance.destroy();
      chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: { labels: bailleur.investments.map(i=>i.projectName), datasets: [{ data: bailleur.investments.map(i=>i.amount), backgroundColor: ['#0e6b3e','#2ecc71','#27ae60','#1e8449'] }] },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
      });
    }
  }

  // Fonction de routage
  function renderCurrentPage(pageId) {
    let content = "";
    switch (pageId) {
      case 'dashboard': content = renderDashboard(); setTimeout(()=>renderChart(), 150); break;
      case 'investir': content = renderInvestir(); setTimeout(()=>attachInvestButtons(), 100); break;
      case 'mes-investissements': content = renderMesInvestissements(); break;
      case 'echeances': content = renderEcheances(); setTimeout(()=>attachSimulateurButtons(), 100); break;
      case 'criteres': content = renderCriteres(); setTimeout(()=>attachSaveCriteres(), 100); break;
      case 'garanties': content = renderGaranties(); break;
      default: content = renderDashboard(); setTimeout(()=>renderChart(), 150);
    }
    pageContainer.innerHTML = content;
    // mise en surbrillance menu
    document.querySelectorAll('.nav-link').forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('data-page') === pageId) link.classList.add('active');
    });
    if (pageId === 'echeances') attachSimulateurButtons();
    if (pageId === 'investir') attachInvestButtons();
    if (pageId === 'criteres') attachSaveCriteres();
  }

  // navigation click
  document.querySelectorAll('.nav-link[data-page]').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      let page = link.getAttribute('data-page');
      renderCurrentPage(page);
    });
  });
  document.getElementById('logoutBtn')?.addEventListener('click', (e) => {
    e.preventDefault();
    localStorage.removeItem('bailleurData');
    showToast("Déconnexion réussie. Redirection vers accueil...", "success");
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