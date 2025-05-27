<?php
session_start();
include 'connexion_bdd.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$object = new PDO('mysql:host=localhost;dbname=sae_siteweb','root','');

$Stat = $object->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
$Stat->bindValue(':id', $user_id, PDO::PARAM_INT);
$Stat->execute();
$user = $Stat->fetch(PDO::FETCH_ASSOC);

$etudiant = null;
$professeur = null;

$Stat = $object->prepare('SELECT * FROM etudiant WHERE id_utilisateur = :id');
$Stat->bindValue(':id', $user_id, PDO::PARAM_INT);
$Stat->execute();
$etudiant = $Stat->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    $Stat = $object->prepare('SELECT * FROM professeur WHERE id_utilisateur = :id');
    $Stat->bindValue(':id', $user_id, PDO::PARAM_INT);
    $Stat->execute();
    $professeur = $Stat->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Profil utilisateur</title>
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

  <div class="container d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="card shadow-lg p-4" style="max-width: 500px; width:100%;">
      <div class="card-body">
        <h2 class="card-title text-center mb-4">Votre Compte</h2>
          <?php if ($user): ?>
            <ul class="list-group list-group-flush mb-3">
              <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($user['nom']) ?></li>
              <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($user['prenom']) ?></li>
              <li class="list-group-item"><strong>Pseudo :</strong> <?= htmlspecialchars($user['pseudo']) ?></li>
              <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></li>
              <li class="list-group-item"><strong>Adresse :</strong> <?= htmlspecialchars($user['adresse']) ?></li>
              <li class="list-group-item"><strong>Etat :</strong> <?= htmlspecialchars($user['etat']) ?></li>
            </ul>
          <?php if ($etudiant): ?>
            <h5 class="mt-4 mb-2">Informations Étudiant</h5>
              <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Numéro étudiant :</strong> <?= htmlspecialchars($etudiant['num_etudiant']) ?></li>
                <li class="list-group-item"><strong>Date de naissance :</strong> <?= htmlspecialchars($etudiant['date_naissance']) ?></li>
                <li class="list-group-item"><strong>TD :</strong> <?= htmlspecialchars($etudiant['TD']) ?></li>
                <li class="list-group-item"><strong>TP :</strong> <?= htmlspecialchars($etudiant['TP']) ?></li>
              </ul>
          <?php elseif ($professeur): ?>
            <h5 class="mt-4 mb-2">Informations Professeur</h5>
              <ul class="list-group list-group-flush mb-3">
                <li class="list-group-item"><strong>Diplôme :</strong> <?= htmlspecialchars($professeur['diplome']) ?></li>
                <li class="list-group-item"><strong>Qualification :</strong> <?= htmlspecialchars($professeur['qualification']) ?></li>
              </ul>
          <?php endif; ?>
            <div class="d-flex flex-column gap-2">
              <a href="modifier_compte.php?id=<?= $user['id_utilisateur'] ?>" class="btn btn-outline-primary">Modifier votre compte</a>
              <a href="supprimer.php" class="btn btn-outline-danger">Supprimer le compte</a>
              <a href="deconnexion.php" class="btn btn-secondary">Se déconnecter</a>
            </div>
            <?php else: ?>
              <div class="alert alert-danger">Utilisateur non trouvé.</div>
          <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>