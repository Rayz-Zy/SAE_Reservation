<?php
require_once "connexion_bdd.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes de connexion</title>
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

    <div class="container">
        <h2 class="mb-4">Liste des utilisateurs en attente</h2>
        <?php
        try {
            $sql = "SELECT * FROM utilisateur WHERE etat = 'en attente'";
            $stat = $pdo->query($sql);

            if ($stat->rowCount() > 0) {
            echo '<table class="table table-bordered align-middle rounded-4 overflow-hidden">';
                echo '<thead>
                    <tr>
                        <th class="bg-primary text-white">ID</th>
                        <th class="bg-primary text-white">Nom</th>
                        <th class="bg-primary text-white">Prénom</th>
                        <th class="bg-primary text-white">Email</th>
                        <th class="bg-primary text-white">Rôle</th>
                        <th class="bg-primary text-white">Etat</th>
                        <th class="bg-primary text-white">Action</th>
                    </tr>
                </thead><tbody>';
                while ($row = $stat->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row["id_utilisateur"]}</td>
                        <td>{$row["nom"]}</td>
                        <td>{$row["prenom"]}</td>
                        <td>{$row["email"]}</td>
                        <td>{$row["role"]}</td>
                        <td><span class='badge bg-warning text-dark'>{$row["etat"]}</span></td>
                        <td>
                            <form method='POST' action='traitement_etat_utilisateur.php' class='d-inline'>
                                <input type='hidden' name='id_utilisateur' value='{$row["id_utilisateur"]}'>
                                <button type='submit' name='action' value='valider' class='btn btn-success btn-sm'>Valider</button>
                                <button type='submit' name='action' value='refuser' class='btn btn-danger btn-sm'>Refuser</button>
                            </form>
                        </td>
                    </tr>";
                }
                echo '</tbody></table></div>';
            } else {
                echo "<div class='alert alert-info'>Aucun utilisateur en attente.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>