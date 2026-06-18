// Initialisation AOS
AOS.init({ duration: 800, once: true });

// ========== BASE DE DONNÉES UTILISATEURS ==========
let usersDB = [
  { id: 1, name: "Mamadou Diallo", email: "bailleur@test.com", password: "any", role: "bailleur", status: "actif" },
  { id: 2, name: "Aïssatou Kane", email: "entrepreneur@test.com", password: "any", role: "entrepreneur", status: "actif" },
  { id: 3, name: "Admin Green", email: "admin@financeconsolidated.sn", password: "admin123", role: "admin", status: "actif" }
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

// Sauvegarde des utilisateurs (persistance simple)
function saveUsersToLocal() {
  localStorage.setItem('financeConsolidatedUsers', JSON.stringify(usersDB));
}

function loadUsersFromLocal() {
  let stored = localStorage.getItem('financeConsolidatedUsers');
  if (stored) {
    usersDB = JSON.parse(stored);
  } else {
    saveUsersToLocal();
  }
}

// Connexion
function performLogin(email, password) {
  if (!email || !password) {
    showToast("Veuillez remplir tous les champs", "warning");
    return false;
  }
  let user = usersDB.find(u => u.email.toLowerCase() === email.toLowerCase());
  if (user && user.status === "actif") {
    sessionStorage.setItem('financeConsolidatedUser', JSON.stringify({ id: user.id, name: user.name, email: user.email, role: user.role }));
    showToast(`Bienvenue ${user.name} ! Redirection...`, "success");
    setTimeout(() => {
      window.location.href = getRolePage(user.role);
    }, 800);
    return true;
  } else if (user && user.status !== "actif") {
    showToast("Compte désactivé. Contactez l'administrateur.", "danger");
    return false;
  } else {
    showToast("Email ou mot de passe incorrect", "danger");
    return false;
  }
}

// Inscription
function performRegister(name, email, password, role) {
  if (!name || !email || !password || password.length < 3) {
    showToast("Veuillez remplir tous les champs correctement (mot de passe min 3 caractères)", "warning");
    return false;
  }
  let existing = usersDB.find(u => u.email.toLowerCase() === email.toLowerCase());
  if (existing) {
    showToast("Cet email est déjà utilisé", "danger");
    return false;
  }
  let newId = usersDB.length + 1;
  let newUser = {
    id: newId,
    name: name,
    email: email,
    password: password,
    role: role,
    status: "actif",
    dateInscription: new Date().toISOString().slice(0, 10)
  };
  usersDB.push(newUser);
  saveUsersToLocal();
  sessionStorage.setItem('financeConsolidatedUser', JSON.stringify({ id: newUser.id, name: newUser.name, email: newUser.email, role: newUser.role }));
  showToast(`Inscription réussie ! Bienvenue ${name}.`, "success");
  setTimeout(() => {
    window.location.href = getRolePage(role);
  }, 800);
  return true;
}

function getRolePage(role) {
  if (role === 'bailleur') return '/bailleur';
  if (role === 'entrepreneur') return '/entrepreneur';
  if (role === 'admin') return '/admin';
  return '/';
}

// UI: basculement onglets Connexion/Inscription
function switchAuthTab(tab) {
  const loginForm = document.getElementById('loginForm');
  const registerForm = document.getElementById('registerForm');
  const tabLogin = document.getElementById('tabLoginBtn');
  const tabRegister = document.getElementById('tabRegisterBtn');
  if (tab === 'login') {
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    tabLogin.classList.add('tab-active', 'text-success');
    tabLogin.classList.remove('text-muted');
    tabRegister.classList.remove('tab-active', 'text-success');
    tabRegister.classList.add('text-muted');
  } else {
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
    tabRegister.classList.add('tab-active', 'text-success');
    tabRegister.classList.remove('text-muted');
    tabLogin.classList.remove('tab-active', 'text-success');
    tabLogin.classList.add('text-muted');
  }
}

// Pré-remplissage des emails selon l'acteur choisi
function presetActorLogin(actor) {
  if (actor === 'bailleur') document.getElementById('loginEmail').value = 'bailleur@test.com';
  else if (actor === 'entrepreneur') document.getElementById('loginEmail').value = 'entrepreneur@test.com';
  else if (actor === 'admin') document.getElementById('loginEmail').value = 'admin@financeconsolidated.sn';
  else document.getElementById('loginEmail').value = '';
  document.getElementById('loginPassword').value = 'any';
  switchAuthTab('login');
}

// Vérifier si déjà connecté
function checkAlreadyLoggedIn() {
  let storedUser = sessionStorage.getItem('financeConsolidatedUser');
  if (storedUser) {
    let user = JSON.parse(storedUser);
    window.location.href = getRolePage(user.role);
  }
}

// Initialisation des événements
function initEventListeners() {
  // Boutons ouverture modale
  document.getElementById('showLoginBtn')?.addEventListener('click', () => {
    switchAuthTab('login');
    new bootstrap.Modal(document.getElementById('authModal')).show();
  });
  document.getElementById('showRegisterBtn')?.addEventListener('click', () => {
    switchAuthTab('register');
    new bootstrap.Modal(document.getElementById('authModal')).show();
  });
  document.getElementById('heroLoginBtn')?.addEventListener('click', () => {
    switchAuthTab('login');
    new bootstrap.Modal(document.getElementById('authModal')).show();
  });
  document.getElementById('heroRegisterBtn')?.addEventListener('click', () => {
    switchAuthTab('register');
    new bootstrap.Modal(document.getElementById('authModal')).show();
  });

  // Tabs clic
  document.getElementById('tabLoginBtn')?.addEventListener('click', () => switchAuthTab('login'));
  document.getElementById('tabRegisterBtn')?.addEventListener('click', () => switchAuthTab('register'));

  // Actions login / register
  document.getElementById('doLoginBtn')?.addEventListener('click', () => {
    let email = document.getElementById('loginEmail').value;
    let pwd = document.getElementById('loginPassword').value;
    performLogin(email, pwd);
  });
  document.getElementById('doRegisterBtn')?.addEventListener('click', () => {
    let name = document.getElementById('regName').value;
    let email = document.getElementById('regEmail').value;
    let pwd = document.getElementById('regPassword').value;
    let role = document.getElementById('regRole').value;
    performRegister(name, email, pwd, role);
  });

  // Boutons acteurs rapides
  document.querySelectorAll('.choose-actor-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
      let actor = btn.getAttribute('data-actor');
      presetActorLogin(actor);
      new bootstrap.Modal(document.getElementById('authModal')).show();
    });
  });

  // Permettre l'envoi avec la touche Entrée
  document.getElementById('loginPassword')?.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') document.getElementById('doLoginBtn').click();
  });
  document.getElementById('regPassword')?.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') document.getElementById('doRegisterBtn').click();
  });
}

// Charger les données au démarrage
loadUsersFromLocal();
checkAlreadyLoggedIn();
initEventListeners();