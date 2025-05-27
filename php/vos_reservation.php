<?php
session_start();
require_once "connexion_bdd.php";

if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour voir vos réservations.</p>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos réservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="mb-4">Liste de vos réservations</h2>
        <?php
        try {
            $user_id = $_SESSION['user_id'];

            $sql = "SELECT r.id_reservation, r.date_emprunt, r.heure_acces, r.heure_rendu, r.commentaire, r.etat FROM reservation r WHERE r.id_user = :id_user ORDER BY r.date_emprunt DESC, r.heure_acces DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id_user' => $user_id]);

            if ($stmt->rowCount() > 0) {
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered align-middle rounded-4 overflow-hidden">';
                echo '<thead>
                        <tr>
                            <th class="bg-primary text-white">ID</th>
                            <th class="bg-primary text-white">Date</th>
                            <th class="bg-primary text-white">Heure accès</th>
                            <th class="bg-primary text-white">Heure rendu</th>
                            <th class="bg-primary text-white">Salles</th>
                            <th class="bg-primary text-white">Matériels</th>
                            <th class="bg-primary text-white">Commentaire</th>
                            <th class="bg-primary text-white">État</th>
                            <th class="bg-primary text-white">Action</th>
                        </tr>
                    </thead><tbody>';
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    
                    $sqlSalle = "SELECT s.nom FROM salle_emprunt se INNER JOIN salle s ON se.id_salle = s.id_salle WHERE se.id_reservation = ?";
                    $stmtSalle = $pdo->prepare($sqlSalle);
                    $stmtSalle->execute([$row['id_reservation']]);
                    $salles = $stmtSalle->fetchAll(PDO::FETCH_COLUMN);
                    $sallesStr = $salles ? implode(', ', $salles) : '-';

                    $sqlMat = "SELECT m.nom, me.quantite FROM materiel_emprunt me INNER JOIN materiel m ON me.id_materiel = m.id_materiel WHERE me.id_reservation = ?";
                    $stmtMat = $pdo->prepare($sqlMat);
                    $stmtMat->execute([$row['id_reservation']]);
                    $materiels = [];
                    while ($mat = $stmtMat->fetch(PDO::FETCH_ASSOC)) {
                        $materiels[] = $mat['nom'] . " (x" . $mat['quantite'] . ")";
                    }
                    $materielsStr = $materiels ? implode(', ', $materiels) : '-';

                    echo "<tr>
                            <td>{$row["id_reservation"]}</td>
                            <td>{$row["date_emprunt"]}</td>
                            <td>{$row["heure_acces"]}</td>
                            <td>{$row["heure_rendu"]}</td>
                            <td>{$sallesStr}</td>
                            <td>{$materielsStr}</td>
                            <td>{$row["commentaire"]}</td>
                            <td>{$row["etat"]}</td>
                            <td>";

                    if ($row["etat"] == "en attente" || $row["etat"] == "valide") {
                        echo "<form method='POST' action='annuler_reservation.php' onsubmit=\"return confirm('Voulez-vous vraiment annuler cette réservation ?');\" style='display:inline;'>
                                <input type='hidden' name='id_reservation' value='{$row["id_reservation"]}'>
                                <button type='submit' class='btn btn-danger btn-sm'>Annuler</button>
                            </form>";
                    } else {
                        echo "-";
                    }
                    echo "</td>
                        </tr>";
                }
                echo '</tbody></table></div>';
                
            } else {
                echo "<div class='alert alert-info'>Aucune réservation trouvée.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Erreur lors de la récupération des données : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>