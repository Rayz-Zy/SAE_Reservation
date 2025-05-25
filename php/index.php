<?php
session_start();
require_once "connexion_bdd.php";

if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}

$role = $_SESSION['role'];
$pseudo = $_SESSION['pseudo'];

$reservations = [];
if ($role === 'admin' || $role === 'agent') {
    $stmt = $pdo->query("SELECT * FROM reservation ORDER BY date_emprunt DESC LIMIT 5");
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} elseif ($role === 'etudiant' || $role === 'enseignant') {
    $stmt = $pdo->prepare("SELECT * FROM reservation WHERE id_user = (SELECT id_utilisateur FROM utilisateur WHERE pseudo = :pseudo) ORDER BY date_emprunt DESC LIMIT 5");
    $stmt->execute([':pseudo' => $pseudo]);
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil SAE Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>

<body>
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

    <div class="container mt-5">
        <h1 class="mb-4 text-center">Bienvenue <?php echo htmlspecialchars($pseudo); ?> !</h1>

   
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-calendar2-week"></i> Vos dernières réservations
            </div>
            <div class="card-body">
                <?php if (empty($reservations)): ?>
                    <div class="alert alert-info mb-0">Aucune réservation récente.</div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Heure accès</th>
                                <th>Heure rendu</th>
                                <th>État</th>
                                <?php if ($role === 'admin' || $role === 'agent'): ?>
                                    <th>Utilisateur</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($reservations as $res): ?>
                            <tr>
                                <td><?= htmlspecialchars($res['date_emprunt']) ?></td>
                                <td><?= htmlspecialchars($res['heure_acces']) ?></td>
                                <td><?= htmlspecialchars($res['heure_rendu']) ?></td>
                                <td>
                                    <span class="badge <?= $res['etat']=='valider' ? 'bg-success' : ($res['etat']=='en attente' ? 'bg-warning text-dark' : 'bg-danger') ?>">
                                        <?= ucfirst($res['etat']) ?>
                                    </span>
                                </td>
                                <?php if ($role === 'admin' || $role === 'agent'): ?>
                                    <td><?= htmlspecialchars($res['id_user']) ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
                <a href="vos_reservation.php" class="btn btn-success btn-sm">Voir vos reservations</a>
            </div>
        </div>

        <div class="row g-4">
        <?php if ($role === 'admin'): ?>
            <div class="col-md-4">
                <div class="card h-100 border-primary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><i class="bi bi-people"></i> Gestion des utilisateurs</h5>
                        <ul class="mb-3">
                            <li>Valider/Refuser les comptes</li>
                            <li>Gérer les rôles</li>
                            <li>Ajouter/Supprimer un utilisateur</li>
                        </ul>
                        <a href="gestion_compte.php" class="btn btn-primary btn-sm">Gérer les comptes</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-success shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="bi bi-bar-chart"></i> Statistiques</h5>
                        <ul class="mb-3">
                            <li>Utilisation des salles et matériel</li>
                            <li>Export CSV/PDF</li>
                        </ul>
                        <a href="statistique.php" class="btn btn-success btn-sm">Voir les stats</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-warning shadow-sm">

                    <div class="card-header bg-warning text-dark d-flex align-items-center">
                        <i class="bi bi-person-plus me-2"></i>
                        <span>Comptes en attente de validation</span>
                    </div>

                    <div class="card-body">
                        <?php
                        $stmtAttente = $pdo->query("SELECT id_utilisateur, pseudo, nom, prenom, email, role FROM utilisateur WHERE etat = 'en attente' ORDER BY id_utilisateur DESC LIMIT 5");
                        $comptesAttente = $stmtAttente->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <?php if (empty($comptesAttente)): ?>
                        <div class="alert alert-info mb-0">Aucune demande de compte en attente.</div>
                        <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Pseudo</th>
                                        <th>Nom</th>
                                        <th>Prénom</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($comptesAttente as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['pseudo']) ?></td>
                                    <td><?= htmlspecialchars($user['nom']) ?></td>
                                    <td><?= htmlspecialchars($user['prenom']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['role']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                        </table>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="text-end mb-2">
                        <a href="demande_connexion.php" class="btn btn-warning btn-sm">Gérer toutes les demandes</a>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-info shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-info"><i class="bi bi-key"></i> Gestion des clés</h5>
                        <ul class="mb-3">
                            <li>Voir les réservations validées</li>
                            <li>Télécharger le PDF de confirmation</li>
                        </ul>
                        <a href="afficher_reservation.php" class="btn btn-info btn-sm">Voir les réservations</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

        <?php if ($role === 'agent'): ?>
            <div class="col-md-4">
                <div class="card h-100 border-info">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-key"></i> Gestion des clés</h5>
                        <ul>
                            <li>Voir les réservations validées</li>
                            <li>Télécharger le PDF de confirmation</li>
                        </ul>
                        <a href="afficher_reservation.php" class="btn btn-info btn-sm">Voir les réservations</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($role === 'etudiant' || $role === 'enseignant'): ?>
            <div class="col-md-4">
                <div class="card h-100 border-secondary shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-secondary"><i class="bi bi-calendar-plus"></i> Réserver</h5>
                        <ul class="mb-3">
                            <li>Faire une nouvelle réservation</li>
                            <li>Voir l’historique</li>
                        </ul>
                        <a href="reservation.php" class="btn btn-secondary btn-sm">Nouvelle réservation</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>