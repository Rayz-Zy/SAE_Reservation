<?php
session_start();
require_once "connexion_bdd.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

$sql = "SELECT * FROM utilisateur";
$users = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$roles = [
    'etudiant' => [],
    'professeur' => [],
    'agent' => [],
    'admin' => [],
    'autre' => []
];

foreach ($users as $user) {
    $role = isset($user['role']) && $user['role'] !== null ? strtolower($user['role']) : 'autre';
    if (isset($roles[$role])) {
        $roles[$role][] = $user;
    } else {
        $roles['autre'][] = $user;
    }
}

function afficher_tableau($users, $titre, $color = "primary") {
    if (count($users) === 0) {
        echo "<div class='card mb-4 shadow'>";
        echo "<div class='card-header bg-$color text-white'><h4 class='mb-0'>$titre</h4></div>";
        echo "<div class='card-body'>";
        echo "<div class='alert alert-warning mb-0'>Aucun compte trouvé pour ce rôle.</div>";
        echo "</div></div>";
        return;
    }
    echo "<div class='card mb-4 shadow'>";
    echo "<div class='card-header bg-$color text-white'><h4 class='mb-0'>$titre</h4></div>";
    echo "<div class='card-body p-0'>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-hover mb-0'>";
    echo "<thead class='table-light'><tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Pseudo</th>
            <th>Email</th>
            <th>Adresse</th>
            <th>Téléphone</th>
            <th>État</th>
            <th>Actions</th>
        </tr></thead><tbody>";
    foreach ($users as $user) {
        echo "<tr>
                <td>{$user['id_utilisateur']}</td>
                <td>".htmlspecialchars($user['nom'])."</td>
                <td>".htmlspecialchars($user['prenom'])."</td>
                <td>".htmlspecialchars($user['pseudo'])."</td>
                <td>".htmlspecialchars($user['email'])."</td>
                <td>".htmlspecialchars($user['adresse'])."</td>
                <td>".htmlspecialchars($user['telephone'])."</td>
                <td>".htmlspecialchars($user['etat'])."</td>
                <td>
                    <a href='modifier_compte.php?id={$user['id_utilisateur']}' class='btn btn-sm btn-outline-primary me-1'>Modifier</a>
                    <a href='supprimer_compte.php?id={$user['id_utilisateur']}' class='btn btn-sm btn-outline-danger');\">Supprimer</a>
                </td>
            </tr>";
    }
    echo "</tbody></table></div></div></div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des comptes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar.css">
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

  <div class="container py-5">
    <div class="text-center mb-5">
      <h1 class="display-5 fw-bold">Gestion des comptes</h1>
      <p class="lead text-muted">Tous les comptes sont listés et séparés par rôle.</p>
    </div>
    <?php
      afficher_tableau($roles['etudiant'], "Étudiants", "info");
      afficher_tableau($roles['professeur'], "Professeurs", "success");
      afficher_tableau($roles['agent'], "Agents", "warning");
      afficher_tableau($roles['admin'], "Administrateurs", "danger");
      afficher_tableau($roles['autre'], "Autres rôles", "secondary");
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>