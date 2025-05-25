<?php
require_once "connexion_bdd.php";

$total_users = $pdo->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn();

$roles = ['etudiant', 'professeur', 'agent', 'admin'];
$role_counts = [];
foreach ($roles as $role) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE role = :role");
    $stmt->execute(['role' => $role]);
    $role_counts[$role] = $stmt->fetchColumn();
}

$total_materiel = $pdo->query("SELECT COUNT(*) FROM materiel")->fetchColumn();

$types_materiel = $pdo->query("SELECT categorie, COUNT(*) as nb FROM materiel GROUP BY categorie")->fetchAll(PDO::FETCH_ASSOC);

$total_reservations = $pdo->query("SELECT COUNT(*) FROM reservation")->fetchColumn();

$total_salles = $pdo->query("SELECT COUNT(*) FROM salle")->fetchColumn();

$nb_approuvees = $pdo->query("SELECT COUNT(*) FROM reservation WHERE etat = 'approuvee'")->fetchColumn();
$nb_attente = $pdo->query("SELECT COUNT(*) FROM reservation WHERE etat = 'en attente'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/stat.css">
</head>
  <body class="bg-light">

  <nav class="navbar navbar-expand-lg" style="background-color: #1B263B;">
    <div class="container-fluid">
      <a class="navbar-brand text-light d-flex align-items-center gap-2" href="index.php" style="font-weight:bold;">
        <i class="bi bi-house-door-fill me-2"></i>
        SAE <span style="color:#ffe082;">Réservation</span>
      </a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-2" style="margin-left: 30px;">
          <li class="nav-item">
            <a class="nav-link" href="index.php" style="color:#fff;">
              <i class="bi bi-house-door"></i> Accueil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="reservation.php" style="color:#fff;">
              <i class="bi bi-calendar2-plus"></i> Réservation
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="catalogue_materiel.php" style="color:#fff;">
              <i class="bi bi-box-seam"></i> Catalogue matériel
            </a>
          </li>
        </ul>
        <div class="ms-auto d-flex align-items-center">
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="img/profil.png" alt="Profil" width="40" height="40" class="rounded-circle border border-light me-2">
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profil.php"><i class="bi bi-person"></i> Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="traitement_deconnexion.php"><i class="bi bi-box-arrow-right"></i> Déconnexion</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-3">
    <h1 class="mb-4 text-center" style="font-size:1.7rem;">Statistiques du site</h1>
    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <div class="card shadow-sm text-center">
          <div class="card-body d-flex flex-column justify-content-between p-3">
            <div>
              <div class="card-title mb-2">Utilisateurs</div>
              <div class="stat-value mb-2"><?= $total_users ?></div>
              <ul class="list-group mb-2">
                <li class="list-group-item py-1">Étudiants : <span class="fw-semibold"><?= $role_counts['etudiant'] ?></span></li>
                <li class="list-group-item py-1">Professeurs : <span class="fw-semibold"><?= $role_counts['professeur'] ?></span></li>
                <li class="list-group-item py-1">Agents : <span class="fw-semibold"><?= $role_counts['agent'] ?></span></li>
                <li class="list-group-item py-1">Administrateurs : <span class="fw-semibold"><?= $role_counts['admin'] ?></span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
          
      <div class="col-md-4">
        <div class="card shadow-sm text-center">
          <div class="card-body d-flex flex-column justify-content-between p-3">
            <div>
              <div class="card-title mb-2">Matériel & Salles</div>
                <div class="stat-value mb-1"><?= $total_materiel ?></div>
                  <div class="stat-label mb-2">Matériel</div>
                    <button class="btn btn-outline-primary btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#materielModal" id="btnVoirDetailMateriel">
                      Voir les types de matériel
                    </button>
                    <hr class="my-2">
                    <div class="stat-value mb-1"><?= $total_salles ?></div>
                    <div class="stat-label">Salles</div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="card shadow-sm text-center">
                <div class="card-body d-flex flex-column justify-content-between p-3">
                  <div>
                    <div class="card-title mb-2">Réservations</div>
                    <div class="stat-value mb-1"><?= $total_reservations ?></div>
                    <button class="btn btn-outline-primary btn-detail mb-2" data-bs-toggle="modal" data-bs-target="#detailModal" id="btnVoirDetailGlobal">
                      Voir en détail
                    </button>
                  </div>
              </div>
            </div>
          </div>
      </div>
     
      <div class="row mb-4">
          <div class="col-md-6 mx-auto">
              <div class="card shadow-sm text-center">
                  <div class="card-body py-3">
                      <div class="card-title mb-2">Réservations par état</div>
                      <div class="d-flex justify-content-center gap-3">
                          <div class="d-flex align-items-center border rounded px-3 py-2 bg-light">
                              <span class="me-2" style="font-size:1rem;">Approuvées</span>
                              <span class="badge bg-success rounded-pill" style="font-size:1rem;"><?= $nb_approuvees ?></span>
                          </div>
                          <div class="d-flex align-items-center border rounded px-3 py-2 bg-light">
                              <span class="me-2" style="font-size:1rem;">En attente</span>
                              <span class="badge bg-warning text-dark rounded-pill" style="font-size:1rem;"><?= $nb_attente ?></span>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailModalLabel">Statistiques des réservations</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <ul class="list-group" id="reservation-details"></ul>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="materielModal" tabindex="-1" aria-labelledby="materielModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="materielModalLabel">Types de matériel</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
        </div>
        <div class="modal-body">
          <ul class="list-group">
              <?php foreach ($types_materiel as $type): ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                      <?= htmlspecialchars($type['categorie']) ?>
                      <span class="badge bg-primary rounded-pill"><?= $type['nb'] ?></span>
                  </li>
              <?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        const detailsList = document.getElementById('reservation-details');
        detailsList.innerHTML = `
            <li class="list-group-item"><strong>Total réservations :</strong> <?= $total_reservations ?></li>
            <li class="list-group-item"><strong>Réservations approuvées :</strong> <?= $nb_approuvees ?></li>
            <li class="list-group-item"><strong>Réservations en attente :</strong> <?= $nb_attente ?></li>
            <li class="list-group-item"><strong>Total matériel :</strong> <?= $total_materiel ?></li>
            <li class="list-group-item"><strong>Total salles :</strong> <?= $total_salles ?></li>
        `;
        document.getElementById('detailModalLabel').textContent = "Statistiques des réservations";
    });
  </script>
</body>
</html>