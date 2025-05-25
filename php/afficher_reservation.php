<?php
session_start();
require_once "connexion_bdd.php";
require_once "reservation_logic.php";
$role = $_SESSION['role'] ?? '';

$stmt = $pdo->prepare("SELECT r.*, u.pseudo FROM reservation r JOIN utilisateur u ON r.id_user = u.id_utilisateur WHERE r.etat = 'en attente'");
$stmt->execute();
$reservationsAttente = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT r.*, u.pseudo FROM reservation r JOIN utilisateur u ON r.id_user = u.id_utilisateur WHERE r.etat = 'valide'");
$stmt->execute();
$reservationsValide = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
        <h1 class="mb-4 text-center"><i class="bi bi-calendar-check"></i> Gestion des réservations</h1>
        <div class="mb-5">
            <h2 class="h4 text-warning mb-3"><i class="bi bi-hourglass-split"></i> Réservations en attente</h2>
            <?php afficherTableauReservations($reservationsAttente, true, $role); ?>
        </div>
        <div>
            <h2 class="h4 text-success mb-3"><i class="bi bi-check-circle"></i> Réservations validées</h2>
            <?php afficherTableauReservations($reservationsValide, false, $role); ?>
        </div>
    </div>

</body>
</html>