<?php
session_start();
require_once "connexion_bdd.php";

if ($_SESSION['role'] !== 'admin') {
    header('Location: afficher_reservation.php');
    exit;
}

if (!isset($_GET['id_reservation'])) {
    header('Location: afficher_reservation.php');
    exit;
}

$id = intval($_GET['id_reservation']);
$stmt = $pdo->prepare("SELECT * FROM reservation WHERE id_reservation = ?");
$stmt->execute([$id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    echo "Réservation introuvable.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier la réservation</title>
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
        <h1 class="mb-4">Modifier la réservation #<?= htmlspecialchars($reservation['id_reservation']) ?></h1>
            <form method="post" action="traitement_modifier_reservation.php">
                <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($reservation['id_reservation']) ?>">
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date_emprunt" class="form-control" value="<?= htmlspecialchars($reservation['date_emprunt']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Heure accès</label>
                    <input type="time" name="heure_acces" class="form-control" value="<?= htmlspecialchars($reservation['heure_acces']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Heure rendu</label>
                    <input type="time" name="heure_rendu" class="form-control" value="<?= htmlspecialchars($reservation['heure_rendu']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">État</label>
                    <select name="etat" class="form-select">
                        <option value="en attente" <?= $reservation['etat']=='en attente'?'selected':'' ?>>En attente</option>
                        <option value="valider" <?= $reservation['etat']=='valider'?'selected':'' ?>>Valider</option>
                        <option value="annuler" <?= $reservation['etat']=='annuler'?'selected':'' ?>>Annuler</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="afficher_reservation.php" class="btn btn-secondary">Annuler</a>
            </form>
</div>
</body>
</html>