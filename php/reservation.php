<?php
require_once 'controle_reservation.php';
if (!isset($_SESSION['user_id'])) {
    echo "<p>Vous devez être connecté pour accéder à cette page.</p>";
    header("Location: connexion.php");
    exit;
}
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'etudiant', 'enseignant'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg" style="background-color: #1B263B;">
        <div class="container-fluid">
            <a class="navbar-brand text-light d-flex align-items-center gap-2" href="index.php" style="font-weight:bold;">
                <i class="bi bi-house-door-fill me-2"></i>SAE
                <span style="color:#ffe082;">Réservation</span>
            </a>
            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-2" style="margin-left: 30px;">
                    <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color:#fff;"><i class="bi bi-house-door"></i> Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reservation.php" style="color:#fff;"><i class="bi bi-calendar2-plus"></i> Réservation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="catalogue_materiel.php" style="color:#fff;"><i class="bi bi-box-seam"></i> Catalogue matériel</a>
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

    <div class="container mt-4">
        <h1 class="mb-4 text-center"><i class="bi bi-calendar2-plus"></i> Réserver une salle ou du matériel</h1>
        <div class="row">
            <div class="col-md-6">
                <h2 class="h4"><i class="bi bi-door-open"></i> Liste des salles</h2>
                <form method="get" class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="equipement">Équipement</label>
                        <select name="equipement" id="equipement" class="form-select" onchange="this.form.submit()">
                            <option value="">Tous</option>
                            <?php foreach ($equipements as $eq): ?>
                                <option value="<?= htmlspecialchars($eq) ?>" <?= $eq == $equipement ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($eq)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($pageSalle > 1): ?>
                            <input type="hidden" name="page_salle" value="<?= $pageSalle ?>">
                        <?php endif; ?>
                    </div>
                </form>
                <ul class="list-group mb-4">
                    <?php
                    while ($row = $stmtSalle->fetch(PDO::FETCH_ASSOC)) {

                        $equipements = array_filter([$row['equipement1'], $row['equipement2'], $row['equipement3']]);
                        $equipements_str = !empty($equipements) ? ' <span class="badge bg-white text-dark ms-5">' . implode(' / ', $equipements) . '</span>' : '';
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                <span>{$row['nom']}{$equipements_str}</span>
                                <div id='info_salle_{$row['id']}'></div>
                                <form method='post' class='d-inline'>
                                    <input type='hidden' name='item_id' value='{$row['id']}'>
                                    <input type='hidden' name='item_type' value='salle'>
                                    <button type='submit' name='add_panier' class='btn btn-primary btn-sm'>
                                        <i class='bi bi-cart-plus'></i> Ajouter
                                    </button>
                                </form>
                            </li>";
                    }
                    ?>
                </ul>
                <?php if ($nbPagesSalle > 1): ?>
                <nav aria-label="Pagination salle">
                    <ul class="pagination justify-content-center">
                        <?php
                        $paramsSalle = $_GET;
                        for ($i = 1; $i <= $nbPagesSalle; $i++):
                            $paramsSalle['page_salle'] = $i;
                            $linkSalle = '?' . http_build_query($paramsSalle);
                        ?>
                            <li class="page-item<?= $i == $pageSalle ? ' active' : '' ?>">
                                <a class="page-link" href="<?= $linkSalle ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
            
            <div class="col-md-6">
                <h2 class="h4"><i class="bi bi-box-seam"></i> Liste des matériels</h2>
                <form method="get" class="mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="categorie">Catégorie</label>
                        <select name="categorie" id="categorie" class="form-select" onchange="this.form.submit()">
                            <option value="">Toutes</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" <?= $cat == $categorie ? 'selected' : '' ?>>
                                    <?= htmlspecialchars(ucfirst($cat)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if ($page > 1): ?>
                            <input type="hidden" name="page_materiel" value="<?= $page ?>">
                        <?php endif; ?>
                    </div>
                </form>
                <ul class="list-group mb-4">
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>{$row['nom']}
                                <form method='post' class='d-flex align-items-center gap-2'>
                                    <input type='hidden' name='item_id' value='{$row['id']}'>
                                    <input type='hidden' name='item_type' value='materiel'>
                                    <label for='quantite_{$row['id']}' class='mb-0 me-1'>Qté :</label>
                                    <input type='number' id='quantite_{$row['id']}' name='quantite' min='1' value='1' required class='form-control form-control-sm' style='width:70px;'>
                                    <button type='submit' name='add_panier' class='btn btn-primary btn-sm'>
                                        <i class='bi bi-cart-plus'></i> Ajouter
                                    </button>
                                </form>
                            </li>";
                    }
                    ?>
                </ul>
                <?php if ($nbPages > 1): ?>
                <nav aria-label="Pagination matériel">
                    <ul class="pagination justify-content-center">
                        <?php
                        $params = $_GET;
                        for ($i = 1; $i <= $nbPages; $i++):
                            $params['page_materiel'] = $i;
                            $link = '?' . http_build_query($params);
                        ?>
                            <li class="page-item<?= $i == $page ? ' active' : '' ?>">
                                <a class="page-link" href="<?= $link ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4"><i class="bi bi-basket"></i> Votre panier</h2>
                <div class="card p-3">
                    <?php afficherPanier($pdo); ?>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 mb-3"><i class="bi bi-clipboard-check"></i> Finaliser la réservation</h2>
                        <form method="post" action="traitement_reservation.php">
                            <div class="mb-3">
                                <label for="date_emprunt" class="form-label">Date de réservation :</label>
                                <input type="date" id="date_emprunt" name="date_emprunt" class="form-control" required>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="heure_acces" class="form-label">Heure d'accès :</label>
                                    <input type="time" id="heure_acces" name="heure_acces" class="form-control" required min="08:30" max="18:00">
                                </div>
                                <div class="col-md-6">
                                    <label for="heure_rendu" class="form-label">Heure de rendu :</label>
                                    <input type="time" id="heure_rendu" name="heure_rendu" class="form-control" required min="08:30" max="18:00">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire" class="form-label">Commentaire :</label>
                                <textarea id="commentaire" name="commentaire" rows="4" class="form-control"></textarea>
                            </div>
                            <?php
                            if (!empty($_SESSION['panier'])) {
                                foreach ($_SESSION['panier'] as $item) {
                                    echo '<input type="hidden" name="panier_type[]" value="'.htmlspecialchars($item['type']).'">';
                                    echo '<input type="hidden" name="panier_id[]" value="'.htmlspecialchars($item['id']).'">';
                                    echo '<input type="hidden" name="panier_quantite[]" value="'.htmlspecialchars($item['quantite']).'">';
                                }
                            }
                            ?>
                            <div class="d-grid">
                                <button type="submit" name="save_panier" class="btn btn-success btn-lg">
                                    <i class="bi bi-send"></i> Envoyer demande de réservation
                                </button>
                            </div>
                        </form>
                        <script src="../js/reservation.js"></script>
                        <div class="mb-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>